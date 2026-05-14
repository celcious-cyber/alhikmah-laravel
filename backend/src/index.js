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

// Static files untuk uploads
app.use('/uploads', express.static(path.join(__dirname, '../uploads')))

// API Routes
app.use('/api/contact', contactRoutes)
app.use('/api/registration', registrationRoutes)
app.use('/api/auth', authRoutes)
app.use('/api/news', newsRoutes)
app.use('/api/gallery', galleryRoutes)
app.use('/api/registrations', adminRegistrationRoutes)

// Root route
app.get('/', (req, res) => {
  res.json({ message: 'Al-Hikmah API is running...', version: '2.0.0' })
})

app.listen(PORT, () => {
  console.log(`🚀 Server berjalan di port ${PORT}`)
})
