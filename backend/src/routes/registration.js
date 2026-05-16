import express from 'express'
import db from '../db.js'
import multer from 'multer'
import path from 'path'
import fs from 'fs'
import { fileURLToPath } from 'url'

const router = express.Router()

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

// Konfigurasi Multer untuk penyimpanan file
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    const rootDir = process.env.UPLOAD_PATH || path.join(__dirname, '../../uploads')
    const dir = path.join(rootDir, 'pendaftaran')
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
  limits: { fileSize: 5 * 1024 * 1024 },
  fileFilter: (req, file, cb) => {
    const allowedTypes = /jpeg|jpg|png|pdf/
    const extname = allowedTypes.test(path.extname(file.originalname).toLowerCase())
    if (extname) {
      return cb(null, true)
    }
    cb(new Error('Hanya file gambar (JPG/PNG) atau PDF yang diperbolehkan!'))
  }
})

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

router.post('/', uploadFields, async (req, res) => {
  try {
    const data = { ...req.body }
    
    if (req.files) {
      Object.keys(req.files).forEach(field => {
        data[field] = `/uploads/pendaftaran/${req.files[field][0].filename}`
      })
    }

    const year = new Date().getFullYear()
    const random = Math.floor(1000 + Math.random() * 9000)
    data.no_registrasi = `ALH-${year}-${random}`

    // Build dynamic INSERT
    const columns = Object.keys(data)
    columns.push('created_at', 'updated_at')
    const placeholders = columns.map(() => '?').join(', ')
    const values = Object.values(data)
    values.push(new Date(), new Date())

    const [result] = await db.execute(
      `INSERT INTO pendaftaran (${columns.join(', ')}) VALUES (${placeholders})`,
      values
    )
    
    res.status(201).json({ 
      success: true, 
      message: 'Pendaftaran berhasil disimpan',
      data: { id: result.insertId.toString(), no_registrasi: data.no_registrasi }
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
