import express from 'express'
import db from '../db.js'
import { authenticate } from '../middleware/auth.js'
import multer from 'multer'
import path from 'path'
import fs from 'fs'
import { fileURLToPath } from 'url'
import sharp from 'sharp'

const router = express.Router()

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

// Setup Multer for Thumbnail Uploads (Memory Storage for Processing)
const storage = multer.memoryStorage()
const upload = multer({ 
  storage,
  limits: { fileSize: 10 * 1024 * 1024 }, // 10MB
  fileFilter: (req, file, cb) => {
    const allowedTypes = /jpeg|jpg|png|webp/
    const extname = allowedTypes.test(path.extname(file.originalname).toLowerCase())
    const mimetype = allowedTypes.test(file.mimetype)
    if (extname && mimetype) return cb(null, true)
    cb(new Error('Hanya file gambar (jpg, png, webp) yang diperbolehkan!'))
  }
})

// Helper: Process and Save Image as WebP
async function processImage(buffer, originalName) {
  const dir = path.join(__dirname, '../../uploads/news')
  try {
    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir, { recursive: true })
    }
  } catch (e) {
    console.error('❌ Folder Permission Error:', e)
    throw new Error('Server tidak memiliki izin untuk membuat folder uploads.')
  }

  const fileName = `news-${Date.now()}-${Math.round(Math.random() * 1e9)}.webp`
  const filePath = path.join(dir, fileName)

  try {
    sharp.concurrency(1)
    await sharp(buffer)
      .resize(1200, 750, { fit: 'cover', withoutEnlargement: true })
      .webp({ quality: 80 })
      .toFile(filePath)
    return `/uploads/news/${fileName}`
  } catch (e) {
    console.error('⚠️ Sharp Failed, falling back to original file:', e)
    const ext = path.extname(originalName) || '.jpg'
    const fallbackName = `news-fallback-${Date.now()}${ext}`
    const fallbackPath = path.join(dir, fallbackName)
    fs.writeFileSync(fallbackPath, buffer)
    return `/uploads/news/${fallbackName}`
  }
}

// Helper: generate slug dari judul
function generateSlug(title) {
  return title
    .toLowerCase()
    .replace(/[^a-z0-9\s-]/g, '')
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-')
    .trim() + '-' + Math.round(Math.random() * 10000)
}

// GET /api/news - Ambil berita yang dipublish (publik)
router.get('/', async (req, res) => {
  try {
    const [news] = await db.execute(
      'SELECT id, title, slug, excerpt, thumbnail, createdAt FROM News WHERE isPublished = true ORDER BY createdAt DESC'
    )
    res.json(news)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil berita.' })
  }
})

// GET /api/news/all - Ambil semua berita termasuk draft (admin)
router.get('/all', authenticate, async (req, res) => {
  try {
    const [news] = await db.execute('SELECT * FROM News ORDER BY createdAt DESC')
    res.json(news)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil berita.' })
  }
})

// GET /api/news/:slug - Detail berita (publik)
router.get('/:slug', async (req, res) => {
  try {
    const [rows] = await db.execute('SELECT * FROM News WHERE slug = ?', [req.params.slug])
    const news = rows[0]
    if (!news) return res.status(404).json({ message: 'Berita tidak ditemukan.' })
    
    if (!news.isPublished) {
      return res.status(404).json({ message: 'Berita belum dipublikasikan.' })
    }
    
    res.json(news)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil berita.' })
  }
})

// POST /api/news - Buat berita baru (admin)
router.post('/', authenticate, upload.single('thumbnail'), async (req, res) => {
  const { title, excerpt, content, isPublished } = req.body
  
  if (!title || !excerpt || !content) {
    return res.status(400).json({ message: 'Judul, ringkasan, dan isi berita wajib diisi.' })
  }

  let thumbnail = req.body.thumbnail 
  if (req.file) {
    try {
      thumbnail = await processImage(req.file.buffer, req.file.originalname)
    } catch (err) {
      console.error('❌ Sharp Error:', err)
      return res.status(500).json({ message: 'Gagal memproses gambar: ' + err.message })
    }
  }

  try {
    const slug = generateSlug(title)
    const published = String(isPublished) === 'true' ? 1 : 0
    const [result] = await db.execute(
      'INSERT INTO News (title, slug, excerpt, content, thumbnail, isPublished, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())',
      [title, slug, excerpt, content, thumbnail || null, published]
    )
    const [rows] = await db.execute('SELECT * FROM News WHERE id = ?', [result.insertId])
    res.status(201).json(rows[0])
  } catch (err) {
    console.error('❌ DB Error (POST):', err)
    res.status(500).json({ message: 'Gagal menyimpan ke database: ' + err.message })
  }
})

// PUT /api/news/:id - Edit berita (admin)
router.put('/:id', authenticate, upload.single('thumbnail'), async (req, res) => {
  const { title, excerpt, content, isPublished } = req.body
  
  let thumbnail = req.body.thumbnail
  if (req.file) {
    try {
      thumbnail = await processImage(req.file.buffer, req.file.originalname)
    } catch (err) {
      console.error('❌ Sharp Error:', err)
      return res.status(500).json({ message: 'Gagal memproses gambar: ' + err.message })
    }
  }

  try {
    const fields = []
    const values = []
    
    if (title !== undefined) { fields.push('title = ?'); values.push(title) }
    if (excerpt !== undefined) { fields.push('excerpt = ?'); values.push(excerpt) }
    if (content !== undefined) { fields.push('content = ?'); values.push(content) }
    if (thumbnail !== undefined) { fields.push('thumbnail = ?'); values.push(thumbnail || null) }
    if (isPublished !== undefined) { fields.push('isPublished = ?'); values.push(String(isPublished) === 'true' ? 1 : 0) }
    
    fields.push('updatedAt = NOW()')
    values.push(parseInt(req.params.id))

    await db.execute(`UPDATE News SET ${fields.join(', ')} WHERE id = ?`, values)
    const [rows] = await db.execute('SELECT * FROM News WHERE id = ?', [parseInt(req.params.id)])
    res.json(rows[0])
  } catch (err) {
    console.error('❌ DB Error (PUT):', err)
    res.status(500).json({ message: 'Gagal mengubah berita: ' + err.message })
  }
})

// DELETE /api/news/:id - Hapus berita (admin)
router.delete('/:id', authenticate, async (req, res) => {
  try {
    const [rows] = await db.execute('SELECT * FROM News WHERE id = ?', [parseInt(req.params.id)])
    const news = rows[0]
    if (news && news.thumbnail && news.thumbnail.startsWith('/uploads/news/')) {
      const filePath = path.join(__dirname, '../../', news.thumbnail)
      if (fs.existsSync(filePath)) fs.unlinkSync(filePath)
    }

    await db.execute('DELETE FROM News WHERE id = ?', [parseInt(req.params.id)])
    res.json({ message: 'Berita berhasil dihapus.' })
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal menghapus berita.' })
  }
})

export default router
