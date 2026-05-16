import express from 'express'
import db from '../db.js'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()

// GET /api/registrations - Ambil semua pendaftar (admin)
router.get('/', authenticate, async (req, res) => {
  try {
    const [registrations] = await db.execute('SELECT * FROM pendaftaran ORDER BY created_at DESC')
    // Convert BigInt to string for JSON serialization
    const serialized = registrations.map(r => ({
      ...r,
      id: r.id.toString()
    }))
    res.json(serialized)
  } catch (err) {
    console.error('Fetch Error:', err)
    res.status(500).json({ message: 'Gagal mengambil data pendaftaran.' })
  }
})

// GET /api/registrations/export - Export ke CSV (admin)
router.get('/export', authenticate, async (req, res) => {
  try {
    const [data] = await db.execute('SELECT * FROM pendaftaran ORDER BY created_at DESC')
    
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
    await db.execute(
      'UPDATE pendaftaran SET verified = ?, verified_by = ?, updated_at = NOW() WHERE id = ?',
      [verified ? 1 : 0, req.admin.username, req.params.id]
    )
    const [rows] = await db.execute('SELECT * FROM pendaftaran WHERE id = ?', [req.params.id])
    const reg = rows[0]
    res.json({ ...reg, id: reg.id.toString() })
  } catch (err) {
    console.error('Verify Error:', err)
    res.status(500).json({ message: 'Gagal mengubah status verifikasi.' })
  }
})

// DELETE /api/registrations/:id - Hapus pendaftar (admin)
router.delete('/:id', authenticate, async (req, res) => {
  try {
    await db.execute('DELETE FROM pendaftaran WHERE id = ?', [req.params.id])
    res.json({ success: true, message: 'Pendaftaran berhasil dihapus' })
  } catch (err) {
    console.error('Delete Error:', err)
    res.status(500).json({ message: 'Gagal menghapus data.' })
  }
})

export default router
