import mysql from 'mysql2/promise'
import dotenv from 'dotenv'

dotenv.config()

// Parse DATABASE_URL: mysql://user:password@host:port/database
function parseDatabaseUrl(url) {
  const regex = /mysql:\/\/([^:]+):([^@]+)@([^:]+):(\d+)\/(.+)/
  const match = url.match(regex)
  if (!match) {
    throw new Error('DATABASE_URL format tidak valid. Gunakan: mysql://user:password@host:port/database')
  }
  return {
    user: match[1],
    password: match[2],
    host: match[3],
    port: parseInt(match[4]),
    database: match[5]
  }
}

const dbConfig = parseDatabaseUrl(process.env.DATABASE_URL)

const pool = mysql.createPool({
  host: dbConfig.host,
  port: dbConfig.port,
  user: dbConfig.user,
  password: dbConfig.password,
  database: dbConfig.database,
  waitForConnections: true,
  connectionLimit: 5,
  queueLimit: 0,
  enableKeepAlive: true
})

export default pool
