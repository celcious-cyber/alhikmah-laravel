import jwt from 'jsonwebtoken'

const JWT_SECRET = process.env.JWT_SECRET || 'alhikmah-secret-key-2024'

export const authenticate = (req, res, next) => {
  const authHeader = req.headers['authorization']
  const token = authHeader && authHeader.split(' ')[1] // Bearer TOKEN

  if (!token) {
    return res.status(401).json({ message: 'Token tidak ditemukan. Silakan login.' })
  }

  try {
    const decoded = jwt.verify(token, JWT_SECRET)
    req.admin = decoded
    next()
  } catch (err) {
    return res.status(403).json({ message: 'Token tidak valid atau kadaluarsa.' })
  }
}
