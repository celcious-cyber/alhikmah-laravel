import express from 'express'
import { PrismaClient } from '@prisma/client'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()
const prisma = new PrismaClient()

// Helper untuk menangani BigInt saat JSON serialization
const serialize = (data) => {
  return JSON.parse(JSON.stringify(data, (key, value) =>
    typeof value === 'bigint' ? value.toString() : value
  ))
}

// GET /api/admin/beasiswa - Ambil semua pendaftar beasiswa (admin)
router.get('/', authenticate, async (req, res) => {
  try {
    const scholarships = await prisma.beasiswa.findMany({
      orderBy: { created_at: 'desc' }
    })
    res.json(serialize(scholarships))
  } catch (err) {
    console.error('Fetch Scholarships Error:', err)
    res.status(500).json({ message: 'Gagal mengambil data beasiswa.' })
  }
})

// PUT /api/admin/beasiswa/:id/verify - Update status verifikasi beasiswa (admin)
router.put('/:id/verify', authenticate, async (req, res) => {
  const { verified } = req.body
  try {
    const scholarship = await prisma.beasiswa.update({
      where: { id: BigInt(req.params.id) },
      data: { verified }
    })
    res.json(serialize(scholarship))
  } catch (err) {
    console.error('Verify Scholarship Error:', err)
    res.status(500).json({ message: 'Gagal mengubah status verifikasi beasiswa.' })
  }
})

// DELETE /api/admin/beasiswa/:id - Hapus pendaftar beasiswa (admin)
router.delete('/:id', authenticate, async (req, res) => {
  try {
    await prisma.beasiswa.delete({
      where: { id: BigInt(req.params.id) }
    })
    res.json({ success: true, message: 'Data beasiswa berhasil dihapus' })
  } catch (err) {
    console.error('Delete Scholarship Error:', err)
    res.status(500).json({ message: 'Gagal menghapus data beasiswa.' })
  }
})

export default router
