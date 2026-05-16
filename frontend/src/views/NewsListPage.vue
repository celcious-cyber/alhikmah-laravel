<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import SectionHeading from '../components/ui/SectionHeading.vue'
import { Calendar, ArrowRight, Newspaper } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const news = ref([])
const loading = ref(true)

const fetchNews = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/news`)
    news.value = res.data
  } catch (err) {
    console.error('Gagal mengambil berita:', err)
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

onMounted(fetchNews)
</script>

<template>
  <div class="pt-[188px] pb-20 min-h-screen">
    <div class="container-custom">
      <SectionHeading 
        title="Warta & Kabar Al-Hikmah" 
        subtitle="Informasi terbaru, pengumuman, dan prestasi santri di lingkungan Pondok Modern Al-Hikmah."
      />

      <div v-if="loading" class="flex flex-col items-center justify-center py-20">
        <div class="animate-spin w-12 h-12 border-4 border-secondary border-t-transparent rounded-full mb-4"></div>
        <p class="text-white/40 font-medium tracking-widest uppercase text-xs">Memuat Berita...</p>
      </div>

      <div v-else-if="news.length === 0" class="flex flex-col items-center justify-center py-20 bg-white/2 rounded-[40px] border border-white/5">
        <Newspaper :size="64" class="text-white/10 mb-6" />
        <h3 class="text-2xl font-bold text-white mb-2">Belum Ada Berita</h3>
        <p class="text-white/40">Nantikan informasi menarik dari kami segera.</p>
        <router-link to="/" class="mt-8 px-8 py-3 bg-secondary text-primary font-bold rounded-2xl hover:scale-105 transition-transform">
          Kembali ke Beranda
        </router-link>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
        <div 
          v-for="(item, index) in news" 
          :key="item.id"
          class="glassmorphism rounded-[40px] overflow-hidden group hover:-translate-y-4 transition-all duration-500 border border-white/5 hover:border-secondary/30 flex flex-col h-full"
          data-aos="fade-up"
          :data-aos-delay="index * 100"
        >
          <!-- Thumbnail -->
          <div class="relative aspect-[16/10] overflow-hidden">
            <img 
              :src="item.thumbnail ? (item.thumbnail.startsWith('http') ? item.thumbnail : `${API_URL}${item.thumbnail}`) : 'https://picsum.photos/seed/alhikmah/800/500'" 
              :alt="item.title"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          </div>

          <!-- Content -->
          <div class="p-8 md:p-10 flex flex-col flex-1">
            <div class="flex items-center gap-3 text-secondary text-xs font-bold tracking-widest uppercase mb-4">
              <Calendar :size="14" />
              <span>{{ formatDate(item.createdAt) }}</span>
            </div>

            <h4 class="text-xl md:text-2xl font-bold text-white mb-4 line-clamp-2 group-hover:text-secondary transition-colors duration-300 leading-tight">
              {{ item.title }}
            </h4>
            
            <p class="text-white/50 text-sm leading-relaxed line-clamp-3 mb-8 flex-1">
              {{ item.excerpt }}
            </p>

            <router-link 
              :to="`/berita/${item.slug}`" 
              class="inline-flex items-center gap-3 text-secondary font-bold hover:gap-5 transition-all text-sm group/link"
            >
              BACA SELENGKAPNYA 
              <ArrowRight :size="18" class="group-hover/link:translate-x-1 transition-transform" />
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.glassmorphism {
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}
</style>
