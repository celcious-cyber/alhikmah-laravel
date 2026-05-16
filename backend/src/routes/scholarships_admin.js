import express from 'express'
import db from '../db.js'
import { authenticate } from '../middleware/auth.js'

const router = express.Router()

// GET /api/admin/beasiswa - Ambil semua pendaftar beasiswa (admin)
router.get('/', authenticate, async (req, res) => {
  try {
    const [scholarships] = await db.execute('SELECT * FROM beasiswa ORDER BY created_at DESC')
    const serialized = scholarships.map(s => ({
      ...s,
      id: s.id.toString()
    }))
    res.json(serialized)
  } catch (err) {
    console.error('Fetch Scholarships Error:', err)
    res.status(500).json({ message: 'Gagal mengambil data beasiswa.' })
  }
})

// PUT /api/admin/beasiswa/:id/verify - Update status verifikasi beasiswa (admin)
router.put('/:id/verify', authenticate, async (req, res) => {
  const { verified } = req.body
  try {
    await db.execute(
      'UPDATE beasiswa SET verified = ?, updated_at = NOW() WHERE id = ?',
      [verified ? 1 : 0, req.params.id]
    )
    const [rows] = await db.execute('SELECT * FROM beasiswa WHERE id = ?', [req.params.id])
    res.json({ ...rows[0], id: rows[0].id.toString() })
  } catch (err) {
    console.error('Verify Scholarship Error:', err)
    res.status(500).json({ message: 'Gagal mengubah status verifikasi beasiswa.' })
  }
})

// DELETE /api/admin/beasiswa/:id - Hapus pendaftar beasiswa (admin)
router.delete('/:id', authenticate, async (req, res) => {
  try {
    await db.execute('DELETE FROM beasiswa WHERE id = ?', [req.params.id])
    res.json({ success: true, message: 'Data beasiswa berhasil dihapus' })
  } catch (err) {
    console.error('Delete Scholarship Error:', err)
    res.status(500).json({ message: 'Gagal menghapus data beasiswa.' })
  }
})

export default router
