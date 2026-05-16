import express from 'express'
import db from '../db.js'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()

// GET /api/programs - Ambil semua program unggulan
router.get('/', async (req, res) => {
  try {
    const [rows] = await db.execute('SELECT * FROM Programs ORDER BY `order` ASC')
    res.json(rows)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil data program.' })
  }
})

// POST /api/programs - Tambah program baru (Admin)
router.post('/', authenticate, async (req, res) => {
  const { title, category, description, imageUrl, order } = req.body
  try {
    const [result] = await db.execute(
      'INSERT INTO Programs (title, category, description, imageUrl, `order`) VALUES (?, ?, ?, ?, ?)',
      [title, category, description, imageUrl, order || 0]
    )
    res.status(201).json({ id: result.insertId, title, category })
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal menambah program.' })
  }
})

// DELETE /api/programs/:id - Hapus program (Admin)
router.delete('/:id', authenticate, async (req, res) => {
  try {
    await db.execute('DELETE FROM Programs WHERE id = ?', [req.params.id])
    res.json({ message: 'Program berhasil dihapus.' })
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal menghapus program.' })
  }
})

export default router
