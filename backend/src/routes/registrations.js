import express from 'express'
import { PrismaClient } from '@prisma/client'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()
const prisma = new PrismaClient()

// GET /api/registrations - Ambil semua pendaftar (admin)
router.get('/', authenticate, async (req, res) => {
  try {
    const registrations = await prisma.registration.findMany({
      orderBy: { createdAt: 'desc' }
    })
    res.json(registrations)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengambil data pendaftaran.' })
  }
})

// GET /api/registrations/export - Export ke CSV (admin)
router.get('/export', authenticate, async (req, res) => {
  try {
    const data = await prisma.registration.findMany({
      orderBy: { createdAt: 'desc' }
    })
    const headers = ['ID', 'Nama Santri', 'Nama Orang Tua', 'Email', 'Telepon', 'Jenjang', 'Alamat', 'Status', 'Tanggal Daftar']
    const rows = data.map(r => [
      r.id, r.childName, r.parentName, r.email, r.phone, r.grade, r.address, r.status,
      new Date(r.createdAt).toLocaleDateString('id-ID')
    ])
    const csv = [headers, ...rows].map(row => row.join(',')).join('\n')
    res.setHeader('Content-Type', 'text/csv')
    res.setHeader('Content-Disposition', 'attachment; filename=pendaftaran.csv')
    res.send(csv)
  } catch (err) {
    res.status(500).json({ message: 'Gagal export data.' })
  }
})

// PUT /api/registrations/:id/status - Update status pendaftar (admin)
router.put('/:id/status', authenticate, async (req, res) => {
  const { status } = req.body
  try {
    const reg = await prisma.registration.update({
      where: { id: parseInt(req.params.id) },
      data: { status }
    })
    res.json(reg)
  } catch (err) {
    console.error(err)
    res.status(500).json({ message: 'Gagal mengubah status.' })
  }
})

export default router
