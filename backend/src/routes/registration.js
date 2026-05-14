import express from 'express'
import { PrismaClient } from '@prisma/client'
import multer from 'multer'
import path from 'path'
import fs from 'fs'
import { fileURLToPath } from 'url'

const router = express.Router()
const prisma = new PrismaClient()

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

// Konfigurasi Multer untuk penyimpanan file
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    const dir = path.join(__dirname, '../../uploads/pendaftaran')
    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir, { recursive: true })
    }
    cb(null, dir)
  },
  filename: (req, file, cb) => {
    const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9)
    cb(null, file.fieldname + '-' + uniqueSuffix + path.extname(file.originalname))
  }
})

const upload = multer({ 
  storage: storage,
  limits: { fileSize: 5 * 1024 * 1024 }, // Limit 5MB
  fileFilter: (req, file, cb) => {
    const allowedTypes = /jpeg|jpg|png|pdf/
    const extname = allowedTypes.test(path.extname(file.originalname).toLowerCase())
    if (extname) {
      return cb(null, true)
    }
    cb(new Error('Hanya file gambar (JPG/PNG) atau PDF yang diperbolehkan!'))
  }
})

// Definisikan semua field file yang diizinkan
const uploadFields = upload.fields([
  { name: 'foto_3x4', maxCount: 1 },
  { name: 'file_ijazah', maxCount: 1 },
  { name: 'file_surat_lulus', maxCount: 1 },
  { name: 'file_akte_lahir', maxCount: 1 },
  { name: 'file_kk', maxCount: 1 },
  { name: 'file_kartu_nisn', maxCount: 1 },
  { name: 'file_kartu_kip', maxCount: 1 },
  { name: 'file_kartu_pkh', maxCount: 1 },
  { name: 'file_kartu_kks', maxCount: 1 },
  { name: 'file_foto_rapot', maxCount: 1 }
])

// Helper untuk menangani BigInt saat JSON serialization
const serialize = (data) => {
  return JSON.parse(JSON.stringify(data, (key, value) =>
    typeof value === 'bigint' ? value.toString() : value
  ))
}

router.post('/', uploadFields, async (req, res) => {
  try {
    const data = { ...req.body }
    
    // Tambahkan path file yang diunggah ke objek data
    if (req.files) {
      Object.keys(req.files).forEach(field => {
        data[field] = `/uploads/pendaftaran/${req.files[field][0].filename}`
      })
    }

    // Generate Nomor Registrasi sederhana (ALH-TAHUN-RANDOM)
    const year = new Date().getFullYear()
    const random = Math.floor(1000 + Math.random() * 9000)
    data.no_registrasi = `ALH-${year}-${random}`

    // Simpan ke database
    const pendaftaran = await prisma.pendaftaran.create({
      data: data
    })
    
    res.status(201).json({ 
      success: true, 
      message: 'Pendaftaran berhasil disimpan',
      data: serialize(pendaftaran)
    })
  } catch (error) {
    console.error('Pendaftaran Error:', error)
    res.status(500).json({ 
      success: false, 
      message: 'Terjadi kesalahan saat menyimpan pendaftaran',
      error: error.message 
    })
  }
})

export default router
