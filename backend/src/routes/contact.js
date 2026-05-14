import express from 'express'
import { PrismaClient } from '@prisma/client'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()
const prisma = new PrismaClient()

// POST /api/contact - Kirim pesan (publik)
router.post('/', async (req, res) => {
  try {
    const { name, email, phone, message } = req.body
    const contact = await prisma.contact.create({
      data: { name, email, phone, message }
    })
    res.status(201).json({ success: true, data: contact })
  } catch (error) {
    res.status(500).json({ success: false, error: error.message })
  }
})

// GET /api/contact - Ambil semua pesan (admin)
router.get('/', authenticate, async (req, res) => {
  try {
    const contacts = await prisma.contact.findMany({
      orderBy: { createdAt: 'desc' }
    })
    res.json(contacts)
  } catch (error) {
    res.status(500).json({ success: false, error: error.message })
  }
})

export default router
