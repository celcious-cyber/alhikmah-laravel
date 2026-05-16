import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    tailwindcss(),
  ],
  server: {
    port: 3000
  },
  build: {
    rollupOptions: {
      output: {
        manualChunks: {
          'vendor-vue': ['vue', 'vue-router', 'pinia', 'vue-i18n'],
          'vendor-swiper': ['swiper'],
          'vendor-utils': ['axios', 'aos'],
          'vendor-icons': ['lucide-vue-next']
        }
      }
    },
    chunkSizeWarningLimit: 1000
  }
})
