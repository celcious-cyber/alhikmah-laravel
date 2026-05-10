import express from 'express'
import { PrismaClient } from '@prisma/client'

const router = express.Router()
const prisma = new PrismaClient()

router.post('/', async (req, res) => {
  try {
    const { childName, parentName, email, phone, grade, address } = req.body
    
    const registration = await prisma.registration.create({
      data: { childName, parentName, email, phone, grade, address }
    })
    
    res.status(201).json({ success: true, data: registration })
  } catch (error) {
    res.status(500).json({ success: false, error: error.message })
  }
})

export default router
