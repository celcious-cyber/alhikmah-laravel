import express from 'express'
import { PrismaClient } from '@prisma/client'

const router = express.Router()
const prisma = new PrismaClient()

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

export default router
