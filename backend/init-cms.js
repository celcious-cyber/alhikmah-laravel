import db from './src/db.js'

async function initCmsTables() {
  try {
    console.log('--- Initializing CMS Tables ---')
    
    // 1. Create Settings Table
    await db.execute(`
      CREATE TABLE IF NOT EXISTS Settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        \`key\` VARCHAR(255) UNIQUE NOT NULL,
        \`value\` TEXT,
        \`group\` VARCHAR(50) DEFAULT 'general',
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )
    `)
    console.log('✔ Settings table ready')

    // 2. Create Programs Table
    await db.execute(`
      CREATE TABLE IF NOT EXISTS Programs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        category VARCHAR(100),
        description TEXT,
        imageUrl VARCHAR(255),
        \`order\` INT DEFAULT 0,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )
    `)
    console.log('✔ Programs table ready')

    // 3. Insert Default Settings (Only if not exists)
    const defaultSettings = [
      ['about_title', 'Tentang Kami', 'about'],
      ['about_subtitle', 'Mengenal Lebih Dekat Al-Hikmah', 'about'],
      ['about_p1', 'Pondok Pesantren Modern Al-Hikmah didirikan dengan visi untuk mencetak generasi yang tidak hanya unggul dalam ilmu agama, tetapi juga kompeten dalam ilmu pengetahuan umum.', 'about'],
      ['about_p2', 'Berlokasi di lingkungan yang asri, kami menyediakan fasilitas pendidikan terlengkap untuk menunjang tumbuh kembang santri.', 'about'],
      ['founder_name', 'KH. Syihabuddin Muhammad', 'about'],
      ['founder_title', 'Pimpinan Pondok', 'about'],
      ['about_image', 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Pimpinan', 'about'],
      ['quote_text', 'Dia (Allah) menganugerahkan HIKMAH kepada siapa yang Dia kehendaki...', 'about'],
      ['quote_source', '(Q.S. Al-Baqarah : 269)', 'about']
    ]

    for (const [key, value, group] of defaultSettings) {
      await db.execute(
        'INSERT IGNORE INTO Settings (\`key\`, \`value\`, \`group\`) VALUES (?, ?, ?)',
        [key, value, group]
      )
    }
    console.log('✔ Default settings populated')

    console.log('--- CMS Tables Ready ---')
    process.exit(0)
  } catch (err) {
    console.error('✘ Error initializing tables:', err)
    process.exit(1)
  }
}

initCmsTables()
