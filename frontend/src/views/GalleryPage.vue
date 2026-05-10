<script setup>
import { ref, computed } from 'vue'
import SectionHeading from '../components/ui/SectionHeading.vue'
import { Search, X } from 'lucide-vue-next'

const activeFilter = ref('Semua')
const filters = ['Semua', 'Kegiatan', 'Prestasi', 'Wisuda', 'Fasilitas']

const images = [
  { id: 1, category: 'Kegiatan', caption: 'Pelajaran Kitab Kuning', image: 'https://picsum.photos/seed/p1/800/1200' },
  { id: 2, category: 'Prestasi', caption: 'Juara MTQ Nasional', image: 'https://picsum.photos/seed/p2/800/600' },
  { id: 3, category: 'Kegiatan', caption: 'Ekstrakurikuler Memanah', image: 'https://picsum.photos/seed/p3/800/1000' },
  { id: 4, category: 'Wisuda', caption: 'Haflah Akhirussanah 2025', image: 'https://picsum.photos/seed/p4/800/500' },
  { id: 5, category: 'Kegiatan', caption: 'Praktik Laboratorium IPA', image: 'https://picsum.photos/seed/p5/800/1400' },
  { id: 6, category: 'Prestasi', caption: 'Lomba Pidato Bahasa Arab', image: 'https://picsum.photos/seed/p6/800/700' },
  { id: 7, category: 'Wisuda', caption: 'Prosesi Wisuda Tahfidz', image: 'https://picsum.photos/seed/p7/800/1100' },
  { id: 8, category: 'Kegiatan', caption: 'Shalat Berjamaah', image: 'https://picsum.photos/seed/p8/800/900' },
  { id: 9, category: 'Fasilitas', caption: 'Asrama Putra Modern', image: 'https://picsum.photos/seed/p9/800/600' },
  { id: 10, category: 'Kegiatan', caption: 'Latihan Muhadharah', image: 'https://picsum.photos/seed/p10/800/1300' },
  { id: 11, category: 'Fasilitas', caption: 'Perpustakaan Digital', image: 'https://picsum.photos/seed/p11/800/800' },
  { id: 12, category: 'Prestasi', caption: 'Medali Emas Pencak Silat', image: 'https://picsum.photos/seed/p12/800/1000' },
  { id: 13, category: 'Kegiatan', caption: 'Kajian Subuh', image: 'https://picsum.photos/seed/p13/800/700' },
  { id: 14, category: 'Fasilitas', caption: 'Masjid Jami Al-Hikmah', image: 'https://picsum.photos/seed/p14/800/1200' },
  { id: 15, category: 'Prestasi', caption: 'Olimpiade Sains', image: 'https://picsum.photos/seed/p15/800/600' },
]

const filteredImages = computed(() => {
  if (activeFilter.value === 'Semua') return images
  return images.filter(img => img.category === activeFilter.value)
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
    <div class="container-custom">
      <SectionHeading 
        title="Galeri Lengkap Al-Hikmah" 
        subtitle="Telusuri jejak langkah, prestasi, dan aktivitas keseharian santri kami melalui dokumentasi visual yang komprehensif."
      />

      <!-- Filter Pills -->
      <div class="flex flex-wrap justify-center gap-4 mb-16" data-aos="fade-up">
        <button 
          v-for="filter in filters" 
          :key="filter"
          @click="activeFilter = filter"
          class="px-8 py-3 rounded-2xl font-bold transition-all duration-300 border-2"
          :class="activeFilter === filter ? 'bg-secondary border-secondary text-primary shadow-lg shadow-secondary/20' : 'bg-transparent border-white/10 text-white/70 hover:border-secondary'"
        >
          {{ filter }}
        </button>
      </div>

      <!-- Masonry Grid -->
      <div class="columns-1 md:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6" data-aos="fade-up">
        <div 
          v-for="img in filteredImages" 
          :key="img.id"
          @click="openLightbox(img)"
          class="relative group overflow-hidden rounded-[32px] break-inside-avoid cursor-pointer shadow-xl"
        >
          <img 
            :src="img.image" 
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
            :src="selectedImage.image" 
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
</style>
