import express from 'express'
import cors from 'cors'
import dotenv from 'dotenv'
import path from 'path'
import { fileURLToPath } from 'url'
import fs from 'fs'

import contactRoutes from './routes/contact.js'
import registrationRoutes from './routes/registration.js'
import authRoutes from './routes/auth.js'
import newsRoutes from './routes/news.js'
import galleryRoutes from './routes/gallery.js'
import adminRegistrationRoutes from './routes/registrations.js'

dotenv.config()

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

const app = express()
const PORT = process.env.PORT || 5000

// Buat folder uploads jika belum ada
const uploadsDir = path.join(__dirname, '../uploads/gallery')
if (!fs.existsSync(uploadsDir)) {
  fs.mkdirSync(uploadsDir, { recursive: true })
}

// Middleware
app.use(cors({
  origin: process.env.FRONTEND_URL || '*',
  credentials: true
}))
app.use(express.json())
app.use(express.urlencoded({ extended: true }))

// Static files untuk frontend (dist) & uploads
let distPath = path.join(__dirname, '../dist')
if (!fs.existsSync(distPath)) {
  distPath = path.join(__dirname, '../../dist') // Coba di root repo
}
app.use(express.static(distPath))
app.use('/uploads', express.static(path.join(__dirname, '../uploads')))

// API Routes
app.use('/api/contact', contactRoutes)
app.use('/api/registration', registrationRoutes)
app.use('/api/auth', authRoutes)
app.use('/api/news', newsRoutes)
app.use('/api/gallery', galleryRoutes)
app.use('/api/registrations', adminRegistrationRoutes)

// Handle SPA routing - kirim index.html untuk semua route non-API
app.get('*', (req, res) => {
  if (req.path.startsWith('/api')) {
    return res.status(404).json({ message: 'API endpoint not found' })
  }
  const indexPath = path.join(distPath, 'index.html')
  if (fs.existsSync(indexPath)) {
    res.sendFile(indexPath)
  } else {
    res.json({ message: 'Al-Hikmah API is running...', note: 'Frontend build not found. Please run build script.' })
  }
})

app.listen(PORT, () => {
  console.log(`🚀 Server berjalan di port ${PORT}`)
  console.log(`📂 Serving frontend from: ${distPath}`)
  console.log(`✅ Uploads directory: ${uploadsDir}`)
})
