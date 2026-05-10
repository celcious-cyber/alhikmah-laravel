import express from 'express'
import cors from 'cors'
import dotenv from 'dotenv'
import contactRoutes from './routes/contact.js'
import registrationRoutes from './routes/registration.js'

dotenv.config()

const app = express()
const PORT = process.env.PORT || 5000

app.use(cors())
app.use(express.json())

// Routes
app.use('/api/contact', contactRoutes)
app.use('/api/registration', registrationRoutes)

app.get('/', (req, res) => {
  res.send('Al-Hikmah API is running...')
})

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`)
})
