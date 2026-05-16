import express from 'express'
import db from '../db.js'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()

// GET /api/settings - Ambil semua pengaturan konten
router.get('/', async (req, res) => {
  try {
    const [rows] = await db.execute('SELECT `key`, `value` FROM Settings')
    const settings = rows.reduce((acc, row) => {
      acc[row.key] = row.value
      return acc
    }, {})
    res.json(settings)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil data pengaturan.' })
  }
})

// POST /api/settings/batch - Update banyak pengaturan sekaligus (Admin)
router.post('/batch', authenticate, async (req, res) => {
  const settings = req.body 
  try {
    for (const [key, value] of Object.entries(settings)) {
      await db.execute(
        'INSERT INTO Settings (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = ?',
        [key, value, value]
      )
    }
    res.json({ message: 'Konten berhasil diperbarui.' })
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal memperbarui konten.' })
  }
})

export default router
