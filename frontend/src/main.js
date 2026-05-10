import { createApp } from 'vue'
import { createPinia } from 'pinia'
import AOS from 'aos'
import 'aos/dist/aos.css'
import './style.css'
import App from './App.vue'
import router from './router'
import i18n from './i18n'

const app = createApp(App)

// Init AOS
AOS.init({
  duration: 800,
  once: true,
  easing: 'ease-out-cubic',
})

app.use(createPinia())
app.use(router)
app.use(i18n)

app.mount('#app')
