import express from 'express'
import { PrismaClient } from '@prisma/client'
import multer from 'multer'
import path from 'path'
import fs from 'fs'

const router = express.Router()
const prisma = new PrismaClient()

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
  limits: { fileSize: 5 * 1024 * 1024 }, // Max 5MB
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

// Helper untuk menangani BigInt saat JSON serialization
const serialize = (data) => {
  return JSON.parse(JSON.stringify(data, (key, value) =>
    typeof value === 'bigint' ? value.toString() : value
  ))
}

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

    // Generate No Registrasi Beasiswa (BEA-2026-XXXX)
    const randomNum = Math.floor(1000 + Math.random() * 9000)
    const noRegistrasi = `BEA-2026-${randomNum}`

    const beasiswaData = {
      no_registrasi: noRegistrasi,
      jenis_beasiswa: data.jenis_beasiswa,
      nama_lengkap: data.nama_lengkap,
      tempat_lahir: data.tempat_lahir,
      tanggal_lahir: data.tanggal_lahir,
      email_pendaftar: data.email_pendaftar,
      telepon: data.telepon,
      asal_sekolah: data.asal_sekolah,
      prestasi_deskripsi: data.prestasi_deskripsi,
      file_sertifikat: files['file_sertifikat'] ? `/uploads/beasiswa/${files['file_sertifikat'][0].filename}` : null,
      file_sk_hafalan: files['file_sk_hafalan'] ? `/uploads/beasiswa/${files['file_sk_hafalan'][0].filename}` : null,
      file_sktm: files['file_sktm'] ? `/uploads/beasiswa/${files['file_sktm'][0].filename}` : null,
      file_rekomendasi: files['file_rekomendasi'] ? `/uploads/beasiswa/${files['file_rekomendasi'][0].filename}` : null,
      file_komitmen: files['file_komitmen'] ? `/uploads/beasiswa/${files['file_komitmen'][0].filename}` : null,
    }

    const beasiswa = await prisma.beasiswa.create({
      data: beasiswaData
    })

    res.status(201).json({
      success: true,
      message: 'Pendaftaran beasiswa berhasil terkirim!',
      data: serialize(beasiswa)
    })
  } catch (err) {
    console.error('Scholarship Error:', err)
    res.status(500).json({ success: false, message: err.message || 'Gagal mengirim pendaftaran beasiswa.' })
  }
})

export default router
