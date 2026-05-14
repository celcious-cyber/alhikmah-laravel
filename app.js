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

// Import dan jalankan server backend
import('./backend/src/index.js').catch(err => {
  console.error('❌ Failed to start server:', err)
  process.exit(1)
})
