import express from 'express'
import db from '../db.js'
import multer from 'multer'
import path from 'path'
import fs from 'fs'

const router = express.Router()

// Konfigurasi Multer untuk Upload Dokumen Beasiswa
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    const dir = 'uploads/beasiswa'
    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir, { recursive: true })
    }
    cb(null, dir)
  },
  filename: (req, file, cb) => {
    const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1e9)
    cb(null, file.fieldname + '-' + uniqueSuffix + path.extname(file.originalname))
  }
})

const upload = multer({
  storage: storage,
  limits: { fileSize: 5 * 1024 * 1024 },
  fileFilter: (req, file, cb) => {
    const allowedTypes = ['.jpg', '.jpeg', '.png', '.pdf']
    const ext = path.extname(file.originalname).toLowerCase()
    if (allowedTypes.includes(ext)) {
      cb(null, true)
    } else {
      cb(new Error('Format file tidak didukung. Gunakan JPG, PNG, atau PDF.'))
    }
  }
})

// POST /api/beasiswa - Pendaftaran Beasiswa Baru
router.post('/', upload.fields([
  { name: 'file_sertifikat', maxCount: 1 },
  { name: 'file_sk_hafalan', maxCount: 1 },
  { name: 'file_sktm', maxCount: 1 },
  { name: 'file_rekomendasi', maxCount: 1 },
  { name: 'file_komitmen', maxCount: 1 }
]), async (req, res) => {
  try {
    const data = req.body
    const files = req.files

    const randomNum = Math.floor(1000 + Math.random() * 9000)
    const noRegistrasi = `BEA-2026-${randomNum}`

    const beasiswaData = {
      no_registrasi: noRegistrasi,
      jenis_beasiswa: data.jenis_beasiswa,
      nama_lengkap: data.nama_lengkap,
      tempat_lahir: data.tempat_lahir || null,
      tanggal_lahir: data.tanggal_lahir || null,
      email_pendaftar: data.email_pendaftar || null,
      telepon: data.telepon || null,
      asal_sekolah: data.asal_sekolah || null,
      prestasi_deskripsi: data.prestasi_deskripsi || null,
      file_sertifikat: files['file_sertifikat'] ? `/uploads/beasiswa/${files['file_sertifikat'][0].filename}` : null,
      file_sk_hafalan: files['file_sk_hafalan'] ? `/uploads/beasiswa/${files['file_sk_hafalan'][0].filename}` : null,
      file_sktm: files['file_sktm'] ? `/uploads/beasiswa/${files['file_sktm'][0].filename}` : null,
      file_rekomendasi: files['file_rekomendasi'] ? `/uploads/beasiswa/${files['file_rekomendasi'][0].filename}` : null,
      file_komitmen: files['file_komitmen'] ? `/uploads/beasiswa/${files['file_komitmen'][0].filename}` : null,
    }

    const columns = Object.keys(beasiswaData)
    columns.push('created_at', 'updated_at')
    const placeholders = columns.map(() => '?').join(', ')
    const values = Object.values(beasiswaData)
    values.push(new Date(), new Date())

    const [result] = await db.execute(
      `INSERT INTO beasiswa (${columns.join(', ')}) VALUES (${placeholders})`,
      values
    )

    res.status(201).json({
      success: true,
      message: 'Pendaftaran beasiswa berhasil terkirim!',
      data: { id: result.insertId.toString(), no_registrasi: noRegistrasi }
    })
  } catch (err) {
    console.error('Scholarship Error:', err)
    res.status(500).json({ success: false, message: err.message || 'Gagal mengirim pendaftaran beasiswa.' })
  }
})

export default router
