import express from 'express'
import { PrismaClient } from '@prisma/client'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()
const prisma = new PrismaClient()

// Helper: generate slug dari judul
function generateSlug(title) {
  return title
    .toLowerCase()
    .replace(/[^a-z0-9\s-]/g, '')
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-')
    .trim() + '-' + Date.now()
}

// GET /api/news - Ambil berita yang dipublish (publik)
router.get('/', async (req, res) => {
  try {
    const news = await prisma.news.findMany({
      where: { isPublished: true },
      orderBy: { createdAt: 'desc' },
      select: { id: true, title: true, slug: true, excerpt: true, thumbnail: true, createdAt: true }
    })
    res.json(news)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil berita.' })
  }
})

// GET /api/news/all - Ambil semua berita termasuk draft (admin)
router.get('/all', authenticate, async (req, res) => {
  try {
    const news = await prisma.news.findMany({
      orderBy: { createdAt: 'desc' }
    })
    res.json(news)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil berita.' })
  }
})

// GET /api/news/:slug - Detail berita (publik)
router.get('/:slug', async (req, res) => {
  try {
    const news = await prisma.news.findUnique({
      where: { slug: req.params.slug, isPublished: true }
    })
    if (!news) return res.status(404).json({ message: 'Berita tidak ditemukan.' })
    res.json(news)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil berita.' })
  }
})

// POST /api/news - Buat berita baru (admin)
router.post('/', authenticate, async (req, res) => {
  const { title, excerpt, content, thumbnail, isPublished } = req.body
  if (!title || !excerpt || !content) {
    return res.status(400).json({ message: 'Judul, ringkasan, dan isi berita wajib diisi.' })
  }
  try {
    const news = await prisma.news.create({
      data: {
        title,
        slug: generateSlug(title),
        excerpt,
        content,
        thumbnail: thumbnail || null,
        isPublished: isPublished || false,
      }
    })
    res.status(201).json(news)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal membuat berita.' })
  }
})

// PUT /api/news/:id - Edit berita (admin)
router.put('/:id', authenticate, async (req, res) => {
  const { title, excerpt, content, thumbnail, isPublished } = req.body
  try {
    const news = await prisma.news.update({
      where: { id: parseInt(req.params.id) },
      data: {
        title,
        excerpt,
        content,
        thumbnail: thumbnail || null,
        isPublished: isPublished !== undefined ? isPublished : undefined,
      }
    })
    res.json(news)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengubah berita.' })
  }
})

// DELETE /api/news/:id - Hapus berita (admin)
router.delete('/:id', authenticate, async (req, res) => {
  try {
    await prisma.news.delete({ where: { id: parseInt(req.params.id) } })
    res.json({ message: 'Berita berhasil dihapus.' })
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal menghapus berita.' })
  }
})

export default router
