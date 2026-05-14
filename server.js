// Entry point utama untuk Hostinger Node.js
// File ini memastikan server bisa ditemukan dari root folder

import { createRequire } from 'module'
import { fileURLToPath } from 'url'
import path from 'path'
import { execSync } from 'child_process'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

console.log('🚀 Starting Al-Hikmah server...')
console.log('📁 Working directory:', process.cwd())
console.log('📁 Script directory:', __dirname)

try {
  console.log('🔄 Menjalankan sinkronisasi database (Pendaftaran Baru)...')
  // Gunakan path langsung ke prisma binary agar lebih pasti di shared hosting
  const prismaPath = path.join(__dirname, 'backend/node_modules/.bin/prisma')
  
  console.log('📡 Menyingkronkan skema ke database...')
  execSync(`cd backend && ${prismaPath} db push --accept-data-loss`, { stdio: 'inherit' })
  
  console.log('🌱 Menjalankan seeder...')
  execSync('cd backend && node prisma/seed.js', { stdio: 'inherit' })
  
  console.log('✅ Database berhasil diperbarui ke skema pendaftaran!')
} catch (error) {
  console.error('❌ Gagal sinkronisasi database secara otomatis.')
  console.error('Detail Error:', error.message)
  console.log('💡 Tips: Pastikan DATABASE_URL di environment sudah benar.')
}

// Import dan jalankan server backend
import('./backend/src/index.js').catch(err => {
  console.error('❌ Failed to start server:', err)
  process.exit(1)
})
