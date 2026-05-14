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

// GET /api/registrations - Ambil semua pendaftar (admin)
router.get('/', authenticate, async (req, res) => {
  try {
    const registrations = await prisma.pendaftaran.findMany({
      orderBy: { created_at: 'desc' }
    })
    res.json(serialize(registrations))
  } catch (err) {
    console.error('Fetch Error:', err)
    res.status(500).json({ message: 'Gagal mengambil data pendaftaran.' })
  }
})

// GET /api/registrations/export - Export ke CSV (admin)
router.get('/export', authenticate, async (req, res) => {
  try {
    const data = await prisma.pendaftaran.findMany({
      orderBy: { created_at: 'desc' }
    })
    
    // Header CSV yang lebih lengkap
    const headers = [
      'No Registrasi', 'Nama Lengkap', 'Email', 'NISN', 'NIK', 'Tempat Lahir', 
      'Tanggal Lahir', 'Jenis Kelamin', 'Asal Sekolah', 'Nama Ayah', 'Nama Ibu', 
      'Status Verifikasi', 'Tanggal Daftar'
    ]
    
    const rows = data.map(r => [
      r.no_registrasi, 
      r.nama_lengkap, 
      r.email_pendaftar, 
      r.nisn, 
      r.nik, 
      r.tempat_lahir,
      r.tanggal_lahir,
      r.jenis_kelamin,
      r.asal_sekolah,
      r.nama_ayah_kandung,
      r.nama_ibu_kandung,
      r.verified ? 'Terverifikasi' : 'Belum Verifikasi',
      new Date(r.created_at).toLocaleDateString('id-ID')
    ])
    
    const csv = [headers, ...rows].map(row => {
      return row.map(cell => `"${(cell || '').toString().replace(/"/g, '""')}"`).join(',')
    }).join('\n')
    
    res.setHeader('Content-Type', 'text/csv')
    res.setHeader('Content-Disposition', 'attachment; filename=pendaftaran_al_hikmah.csv')
    res.send(csv)
  } catch (err) {
    console.error('Export Error:', err)
    res.status(500).json({ message: 'Gagal export data.' })
  }
})

// PUT /api/registrations/:id/verify - Update status verifikasi (admin)
router.put('/:id/verify', authenticate, async (req, res) => {
  const { verified } = req.body
  try {
    const reg = await prisma.pendaftaran.update({
      where: { id: BigInt(req.params.id) },
      data: { 
        verified,
        verified_by: req.user.username 
      }
    })
    res.json(serialize(reg))
  } catch (err) {
    console.error('Verify Error:', err)
    res.status(500).json({ message: 'Gagal mengubah status verifikasi.' })
  }
})

// DELETE /api/registrations/:id - Hapus pendaftar (admin)
router.delete('/:id', authenticate, async (req, res) => {
  try {
    await prisma.pendaftaran.delete({
      where: { id: BigInt(req.params.id) }
    })
    res.json({ success: true, message: 'Pendaftaran berhasil dihapus' })
  } catch (err) {
    console.error('Delete Error:', err)
    res.status(500).json({ message: 'Gagal menghapus data.' })
  }
})

export default router
