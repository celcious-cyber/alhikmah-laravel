<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { Calendar, ArrowLeft, Share2, Facebook, Twitter, MessageCircle } from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()
const API_URL = import.meta.env.VITE_API_URL || ''

const item = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchDetail = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/news/${route.params.slug}`)
    item.value = res.data
  } catch (err) {
    console.error('Gagal mengambil detail berita:', err)
    error.value = err.response?.data?.message || 'Gagal mengambil detail berita.'
  } finally {
    loading.value = false
  }
}

const formatDate = (d) => {
  return new Date(d).toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
}

const formattedContent = computed(() => {
  if (!item.value?.content) return ''
  // Mengonversi baris baru menjadi <br> atau membungkus dengan <p> jika belum ada HTML
  if (!item.value.content.includes('<p>')) {
    return item.value.content.split('\n').filter(p => p.trim() !== '').map(p => `<p class="mb-6">${p}</p>`).join('')
  }
  return item.value.content
})

const shareUrl = window.location.href

onMounted(fetchDetail)
</script>

<template>
  <div class="pt-[188px] pb-20 min-h-screen">
    <div class="container-custom">
      <!-- Back Button -->
      <button 
        @click="router.back()"
        class="flex items-center gap-2 text-secondary font-bold mb-12 hover:-translate-x-2 transition-transform"
      >
        <ArrowLeft :size="20" />
        KEMBALI KE DAFTAR BERITA
      </button>

      <div v-if="loading" class="flex flex-col items-center justify-center py-20">
        <div class="animate-spin w-12 h-12 border-4 border-secondary border-t-transparent rounded-full mb-4"></div>
        <p class="text-white/40 font-medium tracking-widest uppercase text-xs">Memuat Artikel...</p>
      </div>

      <div v-else-if="error" class="text-center py-20 bg-white/2 rounded-[40px] border border-white/5">
        <h3 class="text-2xl font-bold text-white mb-2">Oops!</h3>
        <p class="text-white/40">{{ error }}</p>
        <router-link to="/berita" class="mt-8 inline-block px-8 py-3 bg-secondary text-primary font-bold rounded-2xl">
          Kembali ke Daftar Berita
        </router-link>
      </div>

      <article v-else class="max-w-4xl mx-auto">
        <!-- Header -->
        <header class="mb-12">
          <div class="flex items-center gap-3 text-secondary text-xs font-bold tracking-widest uppercase mb-6" data-aos="fade-up">
            <Calendar :size="16" />
            <span>{{ formatDate(item.createdAt) }}</span>
            <span class="text-white/10 mx-1">|</span>
            <span>ADMIN PONDOK</span>
          </div>
          
          <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-10 leading-[1.1]" data-aos="fade-up" data-aos-delay="100">
            {{ item.title }}
          </h1>

          <!-- Featured Image -->
          <div class="aspect-[16/9] rounded-[40px] overflow-hidden border border-white/10 shadow-2xl" data-aos="zoom-in" data-aos-delay="200">
            <img 
              :src="item.thumbnail ? (item.thumbnail.startsWith('http') ? item.thumbnail : `${API_URL}${item.thumbnail}`) : 'https://picsum.photos/seed/alhikmah/1200/800'" 
              :alt="item.title"
              class="w-full h-full object-cover"
            />
          </div>
        </header>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
          <!-- Main Content -->
          <div class="lg:col-span-8">
            <div 
              class="prose prose-invert prose-amber max-w-none text-white/70 text-lg leading-relaxed article-content"
              v-html="formattedContent"
              data-aos="fade-up"
            ></div>
          </div>

          <!-- Sidebar / Sharing -->
          <div class="lg:col-span-4 space-y-10">
            <div class="glassmorphism p-8 rounded-[32px] border border-white/5 sticky top-32">
              <h5 class="text-white font-bold mb-6 flex items-center gap-2">
                <Share2 :size="18" class="text-secondary" />
                BAGIKAN ARTIKEL
              </h5>
              <div class="flex flex-col gap-3">
                <a :href="`https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`" target="_blank" class="flex items-center gap-3 p-4 bg-white/5 hover:bg-[#1877F2]/20 hover:text-[#1877F2] rounded-2xl transition-all font-bold text-sm">
                  <Facebook :size="20" /> Facebook
                </a>
                <a :href="`https://twitter.com/intent/tweet?url=${shareUrl}&text=${item.title}`" target="_blank" class="flex items-center gap-3 p-4 bg-white/5 hover:bg-[#1DA1F2]/20 hover:text-[#1DA1F2] rounded-2xl transition-all font-bold text-sm">
                  <Twitter :size="20" /> Twitter
                </a>
                <a :href="`https://wa.me/?text=${item.title}%20${shareUrl}`" target="_blank" class="flex items-center gap-3 p-4 bg-white/5 hover:bg-[#25D366]/20 hover:text-[#25D366] rounded-2xl transition-all font-bold text-sm">
                  <MessageCircle :size="20" /> WhatsApp
                </a>
              </div>

              <div class="mt-10 pt-10 border-t border-white/5">
                <p class="text-xs text-white/30 font-medium leading-relaxed italic">
                  "Sampaikanlah walau satu ayat." Mari sebarkan kebaikan melalui informasi yang bermanfaat.
                </p>
              </div>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</template>

<style>
.article-content p {
  margin-bottom: 1.5rem;
}
.article-content strong {
  color: white;
}
.glassmorphism {
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}
</style>
