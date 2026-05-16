import express from 'express'
import db from '../db.js'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()

// POST /api/contact - Kirim pesan (publik)
router.post('/', async (req, res) => {
  try {
    const { name, email, phone, message } = req.body
    const [result] = await db.execute(
      'INSERT INTO Contact (name, email, phone, message, isRead, createdAt) VALUES (?, ?, ?, ?, false, NOW())',
      [name, email, phone, message]
    )
    const [rows] = await db.execute('SELECT * FROM Contact WHERE id = ?', [result.insertId])
    res.status(201).json({ success: true, data: rows[0] })
  } catch (error) {
    console.error('Contact Error:', error)
    res.status(500).json({ success: false, error: error.message })
  }
})

// GET /api/contact - Ambil semua pesan (admin)
router.get('/', authenticate, async (req, res) => {
  try {
    const [contacts] = await db.execute('SELECT * FROM Contact ORDER BY createdAt DESC')
    res.json(contacts)
  } catch (error) {
    console.error('Contact Fetch Error:', error)
    res.status(500).json({ success: false, error: error.message })
  }
})

export default router
