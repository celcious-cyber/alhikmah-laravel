<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import SectionHeading from '../ui/SectionHeading.vue'
import { Calendar, User, ArrowRight, Newspaper } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const news = ref([])
const loading = ref(true)

const fetchNews = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/news`)
    // Ambil maksimal 3 berita terbaru untuk beranda
    news.value = res.data.slice(0, 3)
  } catch (err) {
    console.error('Gagal mengambil berita:', err)
  } finally {
    loading.value = false
  }
}

const formatDate = (d) => {
  return new Date(d).toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  })
}

onMounted(fetchNews)
</script>

<template>
  <section id="news" class="section-padding bg-transparent">
    <div class="container-custom">
      <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 gap-6">
        <SectionHeading 
          :title="$t('news.title')" 
          :subtitle="$t('news.subtitle')"
          class="!mb-0 !text-center md:!text-left"
        />
        
        <router-link 
          to="/berita" 
          class="px-8 py-3 glassmorphism rounded-2xl text-secondary font-bold hover:bg-secondary hover:text-primary transition-all duration-300"
        >
          {{ $t('news.load_more') }}
        </router-link>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="i in 3" :key="i" class="glassmorphism rounded-[32px] h-[450px] animate-pulse overflow-hidden border border-white/5">
          <div class="aspect-[16/10] bg-white/5"></div>
          <div class="p-8 space-y-4">
            <div class="w-1/3 h-3 bg-white/5 rounded"></div>
            <div class="w-full h-6 bg-white/5 rounded"></div>
            <div class="w-2/3 h-6 bg-white/5 rounded"></div>
            <div class="w-full h-20 bg-white/5 rounded"></div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else-if="news.length === 0" class="text-center py-20 glassmorphism rounded-[40px] border border-white/5">
        <Newspaper :size="48" class="mx-auto mb-4 text-white/10" />
        <p class="text-white/30">Belum ada berita terbaru saat ini.</p>
      </div>

      <!-- Content -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div 
          v-for="(item, index) in news" 
          :key="item.id"
          class="glassmorphism rounded-[32px] overflow-hidden group shadow-xl hover:-translate-y-3 transition-all duration-500 border border-white/5 hover:border-secondary/30"
          data-aos="fade-up"
          :data-aos-delay="index * 100"
        >
          <!-- Image -->
          <div class="relative aspect-[16/10] overflow-hidden">
            <img 
              :src="item.thumbnail ? (item.thumbnail.startsWith('http') ? item.thumbnail : `${API_URL}${item.thumbnail}`) : 'https://picsum.photos/seed/alhikmah/800/500'" 
              :alt="item.title"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            <div class="absolute top-4 left-4">
              <span class="px-4 py-1.5 bg-secondary text-primary text-[10px] font-bold rounded-full shadow-lg uppercase tracking-wider">
                Berita Terbaru
              </span>
            </div>
          </div>

          <!-- Content -->
          <div class="p-8">
            <div class="flex items-center gap-4 text-white/50 text-[10px] font-bold uppercase tracking-widest mb-4">
              <div class="flex items-center gap-1.5">
                <Calendar :size="14" class="text-secondary" />
                <span>{{ formatDate(item.createdAt) }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <User :size="14" class="text-secondary" />
                <span>ADMIN PONDOK</span>
              </div>
            </div>

            <h4 class="text-xl font-bold text-white mb-4 line-clamp-2 group-hover:text-secondary transition-colors duration-300 leading-snug">
              {{ item.title }}
            </h4>
            
            <p class="text-white/50 text-sm leading-relaxed line-clamp-3 mb-6">
              {{ item.excerpt }}
            </p>

            <router-link 
              :to="`/berita/${item.slug}`" 
              class="inline-flex items-center gap-2 text-secondary font-bold hover:gap-4 transition-all text-sm uppercase tracking-widest"
            >
              {{ $t('news.read_more') }} <ArrowRight :size="18" />
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
