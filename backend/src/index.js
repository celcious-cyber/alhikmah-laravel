import express from 'express'
import cors from 'cors'
import dotenv from 'dotenv'
import path from 'path'
import { fileURLToPath } from 'url'
import fs from 'fs'

// Tangkap semua error yang tidak tertangani agar server tidak crash diam-diam
process.on('uncaughtException', (err) => {
  console.error('❌ UNCAUGHT EXCEPTION:', err.message)
  console.error(err.stack)
})
process.on('unhandledRejection', (reason) => {
  console.error('❌ UNHANDLED REJECTION:', reason)
})

import contactRoutes from './routes/contact.js'
import registrationRoutes from './routes/registration.js'
import authRoutes from './routes/auth.js'
import newsRoutes from './routes/news.js'
import galleryRoutes from './routes/gallery.js'
import adminRegistrationRoutes from './routes/registrations.js'
import scholarshipRoutes from './routes/scholarship.js'
import scholarshipsAdminRoutes from './routes/scholarships_admin.js'

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

// Health check endpoint - untuk verifikasi server berjalan
app.get('/api/health', (req, res) => {
  res.json({ 
    status: 'ok', 
    message: 'Server Al-Hikmah berjalan!',
    time: new Date().toISOString(),
    env: {
      port: PORT,
      hasDB: !!process.env.DATABASE_URL,
      hasJWT: !!process.env.JWT_SECRET,
    }
  })
})

// API Routes
app.use('/api/contact', contactRoutes)
app.use('/api/pendaftaran', registrationRoutes)
app.use('/api/auth', authRoutes)
app.use('/api/news', newsRoutes)
app.use('/api/gallery', galleryRoutes)
app.use('/api/registrations', adminRegistrationRoutes)
app.use('/api/beasiswa', scholarshipRoutes)
app.use('/api/admin/beasiswa', scholarshipsAdminRoutes)

// OG Meta Tags untuk halaman berita (agar thumbnail muncul di WhatsApp/Facebook)
app.get('/berita/:slug', async (req, res) => {
  try {
    const indexPath = path.join(distPath, 'index.html')
    let html = fs.readFileSync(indexPath, 'utf8')
    
    // Import db di sini agar tidak error jika db belum siap
    const { default: db } = await import('./db.js')
    const [rows] = await db.execute('SELECT title, excerpt, thumbnail FROM News WHERE slug = ?', [req.params.slug])
    const news = rows[0]
    
    if (news) {
      const siteUrl = 'https://alhikmahutan.ponpes.id'
      const fullThumbnail = news.thumbnail 
        ? (news.thumbnail.startsWith('http') ? news.thumbnail : `${siteUrl}${news.thumbnail}`)
        : `${siteUrl}/og-image.jpg`
      const title = news.title || 'Berita Al-Hikmah'
      const description = news.excerpt || 'Baca berita terbaru dari Pondok Modern Al-Hikmah Utan'
      const pageUrl = `${siteUrl}/berita/${req.params.slug}`
      
      // Replace meta tags
      html = html.replace(/<meta property="og:title"[^>]*>/, `<meta property="og:title" content="${title}" />`)
      html = html.replace(/<meta property="og:description"[^>]*>/, `<meta property="og:description" content="${description}" />`)
      html = html.replace(/<meta property="og:image"[^>]*>/, `<meta property="og:image" content="${fullThumbnail}" />`)
      html = html.replace(/<meta property="og:url"[^>]*>/, `<meta property="og:url" content="${pageUrl}" />`)
      html = html.replace(/<meta property="twitter:title"[^>]*>/, `<meta property="twitter:title" content="${title}" />`)
      html = html.replace(/<meta property="twitter:description"[^>]*>/, `<meta property="twitter:description" content="${description}" />`)
      html = html.replace(/<meta property="twitter:image"[^>]*>/, `<meta property="twitter:image" content="${fullThumbnail}" />`)
      html = html.replace(/<meta property="twitter:url"[^>]*>/, `<meta property="twitter:url" content="${pageUrl}" />`)
      html = html.replace(/<title>[^<]*<\/title>/, `<title>${title} | Al-Hikmah</title>`)
    }
    
    res.send(html)
  } catch (err) {
    console.error('OG Meta Error:', err)
    // Fallback: kirim index.html biasa
    const indexPath = path.join(distPath, 'index.html')
    res.sendFile(indexPath)
  }
})

// Handle SPA routing - kirim index.html untuk semua rute non-API
app.get('*', (req, res) => {
  // Jika ini adalah request ke API yang tidak ada, kirim JSON 404
  if (req.path.startsWith('/api')) {
    return res.status(404).json({ message: 'API endpoint not found' })
  }
  
  // Jika bukan API, kirim index.html (SPA Fallback)
  const indexPath = path.join(distPath, 'index.html')
  res.sendFile(indexPath, (err) => {
    if (err) {
      res.status(500).json({ 
        message: 'Error loading page', 
        error: err.message,
        path: indexPath 
      })
    }
  })
})


app.listen(PORT, () => {
  console.log(`🚀 Server berjalan di port ${PORT}`)
  console.log(`📂 Serving frontend from: ${distPath}`)
  console.log(`✅ Uploads directory: ${uploadsDir}`)
})
