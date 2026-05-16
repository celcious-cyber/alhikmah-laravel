import express from 'express'
import bcrypt from 'bcryptjs'
import jwt from 'jsonwebtoken'
import db from '../db.js'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()
const JWT_SECRET = process.env.JWT_SECRET || 'alhikmah-secret-key-2024'

// POST /api/auth/login
router.post('/login', async (req, res) => {
  const { username, password } = req.body

  if (!username || !password) {
    return res.status(400).json({ message: 'Username dan password wajib diisi.' })
  }

  try {
    const [rows] = await db.execute('SELECT * FROM Admin WHERE username = ?', [username])
    const admin = rows[0]

    if (!admin) {
      return res.status(401).json({ message: 'Username atau password salah.' })
    }

    const isMatch = await bcrypt.compare(password, admin.password)
    if (!isMatch) {
      return res.status(401).json({ message: 'Username atau password salah.' })
    }

    const token = jwt.sign(
      { id: admin.id, username: admin.username, name: admin.name },
      JWT_SECRET,
      { expiresIn: '24h' }
    )

    res.json({
      token,
      admin: { id: admin.id, username: admin.username, name: admin.name }
    })
  } catch (err) {
    console.error('Login error:', err)
    res.status(500).json({ message: 'Terjadi kesalahan server.', detail: err.message })
  }
})

// GET /api/auth/me
router.get('/me', authenticate, (req, res) => {
  res.json({ admin: req.admin })
})

export default router
