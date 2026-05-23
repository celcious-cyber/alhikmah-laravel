<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import SectionHeading from '../components/ui/SectionHeading.vue'
import { Search, X } from 'lucide-vue-next'

import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL || ''
const activeFilter = ref('Semua')
const filters = ref(['Semua', 'Kegiatan', 'Prestasi', 'Wisuda', 'Fasilitas'])
const images = ref([])
const loading = ref(true)

const fetchGallery = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/gallery`)
    images.value = res.data
    
    // Extract unique categories dynamically based on fetched data
    const dynamicCategories = [...new Set(res.data.map(img => img.category))]
    filters.value = ['Semua', ...dynamicCategories]
  } catch (err) {
    console.error('Gagal mengambil data galeri:', err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchGallery)

const filteredImages = computed(() => {
  if (activeFilter.value === 'Semua') return images.value
  return images.value.filter(img => img.category === activeFilter.value)
})

const selectedImage = ref(null)

const openLightbox = (img) => {
  selectedImage.value = img
  document.body.style.overflow = 'hidden'
}

const closeLightbox = () => {
  selectedImage.value = null
  document.body.style.overflow = 'auto'
}
</script>

<template>
  <div class="pt-[188px] pb-20 min-h-screen">
    <Head>
      <title>Galeri | Pondok Modern Al-Hikmah</title>
      <meta name="description" content="Kumpulan momen, kegiatan, dan fasilitas di Pondok Modern Al-Hikmah dalam bentuk foto dan video.">
    </Head>
    <div class="container-custom">
      <SectionHeading 
        title="Galeri Lengkap Al-Hikmah" 
        subtitle="Telusuri jejak langkah, prestasi, dan aktivitas keseharian santri kami melalui dokumentasi visual yang komprehensif."
      />

      <!-- Filter Pills -->
      <div class="flex overflow-x-auto hide-scrollbar snap-x snap-mandatory pb-4 md:pb-0 md:flex-wrap md:justify-center gap-4 mb-16" data-aos="fade-up">
        <button 
          v-for="filter in filters" 
          :key="filter"
          @click="activeFilter = filter"
          class="shrink-0 snap-center px-8 py-3 rounded-2xl font-bold transition-all duration-300 border-2"
          :class="activeFilter === filter ? 'bg-secondary border-secondary text-primary shadow-lg shadow-secondary/20' : 'bg-transparent border-white/10 text-white/70 hover:border-secondary'"
        >
          {{ filter }}
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex flex-col items-center justify-center py-20">
        <div class="animate-spin w-12 h-12 border-4 border-secondary border-t-transparent rounded-full mb-4"></div>
        <p class="text-white/40 font-medium tracking-widest uppercase text-xs">Memuat Galeri...</p>
      </div>

      <div v-else-if="images.length === 0" class="text-center py-20 bg-white/2 rounded-[40px] border border-white/5">
        <h3 class="text-2xl font-bold text-white mb-2">Belum Ada Foto</h3>
        <p class="text-white/40">Galeri dokumentasi akan segera diperbarui.</p>
      </div>

      <!-- Masonry Grid (3 Columns on Mobile) -->
      <div v-else class="columns-3 md:columns-2 lg:columns-3 xl:columns-4 gap-2 md:gap-6 space-y-2 md:space-y-6" data-aos="fade-up">
        <div 
          v-for="img in filteredImages" 
          :key="img.id"
          @click="openLightbox(img)"
          class="relative group overflow-hidden rounded-2xl md:rounded-[32px] break-inside-avoid cursor-pointer shadow-xl"
        >
          <img 
            :src="img.imageUrl ? (img.imageUrl.startsWith('http') ? img.imageUrl : `${API_URL}${img.imageUrl}`) : 'https://placehold.co/800x800/154D6E/FFFFFF'" 
            :alt="img.caption"
            class="w-full h-auto object-cover transition-transform duration-700 group-hover:scale-110"
          />
          
          <!-- Hover Overlay -->
          <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center p-6 text-center backdrop-blur-sm">
            <div class="p-4 bg-secondary/20 rounded-full mb-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
              <Search class="text-secondary" :size="28" />
            </div>
            <h5 class="text-white font-bold text-xl mb-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 delay-75">
              {{ img.caption }}
            </h5>
            <span class="text-secondary text-sm font-bold tracking-wider transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 delay-150">
              {{ img.category }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Lightbox Modal -->
    <Transition name="fade">
      <div v-if="selectedImage" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/95 backdrop-blur-xl">
        <button @click="closeLightbox" class="absolute top-8 right-8 text-white/70 hover:text-white transition-colors p-2 bg-white/10 rounded-full">
          <X :size="32" />
        </button>
        
        <div class="max-w-5xl w-full flex flex-col items-center">
          <img 
            :src="selectedImage.imageUrl ? (selectedImage.imageUrl.startsWith('http') ? selectedImage.imageUrl : `${API_URL}${selectedImage.imageUrl}`) : 'https://placehold.co/800x800'" 
            :alt="selectedImage.caption"
            class="max-h-[80vh] w-auto object-contain rounded-2xl shadow-2xl"
          />
          <div class="mt-8 text-center">
            <span class="px-4 py-1.5 bg-secondary text-primary text-xs font-bold rounded-full mb-4 inline-block">
              {{ selectedImage.category }}
            </span>
            <h4 class="text-2xl md:text-3xl font-bold text-white">{{ selectedImage.caption }}</h4>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
