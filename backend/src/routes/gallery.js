import express from 'express'
import multer from 'multer'
import path from 'path'
import db from '../db.js'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()

// Konfigurasi Multer untuk upload gambar
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, 'uploads/gallery/')
  },
  filename: (req, file, cb) => {
    const unique = Date.now() + '-' + Math.round(Math.random() * 1e9)
    cb(null, 'gallery-' + unique + path.extname(file.originalname))
  }
})

const upload = multer({
  storage,
  limits: { fileSize: 5 * 1024 * 1024 }, // max 5MB
  fileFilter: (req, file, cb) => {
    const allowed = /jpeg|jpg|png|gif|webp/
    const ext = allowed.test(path.extname(file.originalname).toLowerCase())
    const mime = allowed.test(file.mimetype)
    if (ext && mime) cb(null, true)
    else cb(new Error('Hanya file gambar yang diperbolehkan!'))
  }
})

// GET /api/gallery - Ambil semua foto (publik)
router.get('/', async (req, res) => {
  try {
    const [items] = await db.execute('SELECT * FROM Gallery ORDER BY `order` ASC, createdAt DESC')
    res.json(items)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil galeri.' })
  }
})

// POST /api/gallery - Upload foto baru (admin)
router.post('/', authenticate, upload.single('image'), async (req, res) => {
  if (!req.file) {
    return res.status(400).json({ message: 'File gambar wajib diupload.' })
  }
  const { caption, category, order } = req.body
  try {
    const baseUrl = process.env.BASE_URL || 'http://localhost:5000'
    const imageUrl = `${baseUrl}/uploads/gallery/${req.file.filename}`
    const [result] = await db.execute(
      'INSERT INTO Gallery (imageUrl, caption, category, `order`, createdAt) VALUES (?, ?, ?, ?, NOW())',
      [imageUrl, caption || null, category || 'umum', order ? parseInt(order) : 0]
    )
    const [rows] = await db.execute('SELECT * FROM Gallery WHERE id = ?', [result.insertId])
    res.status(201).json(rows[0])
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal menyimpan foto.' })
  }
})

// DELETE /api/gallery/:id - Hapus foto (admin)
router.delete('/:id', authenticate, async (req, res) => {
  try {
    await db.execute('DELETE FROM Gallery WHERE id = ?', [parseInt(req.params.id)])
    res.json({ message: 'Foto berhasil dihapus.' })
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal menghapus foto.' })
  }
})

export default router
