<script setup>
import { ref, computed } from 'vue'
import SectionHeading from '../components/ui/SectionHeading.vue'
import { Search, X } from 'lucide-vue-next'

const images = [
  { id: 1, category: 'Fasilitas', caption: 'Masjid Jami Al-Hikmah', image: 'https://picsum.photos/seed/fac1/800/1200' },
  { id: 2, category: 'Fasilitas', caption: 'Asrama Putra Modern', image: 'https://picsum.photos/seed/fac2/800/600' },
  { id: 3, category: 'Fasilitas', caption: 'Perpustakaan Digital', image: 'https://picsum.photos/seed/fac3/800/1000' },
  { id: 4, category: 'Fasilitas', caption: 'Laboratorium IPA', image: 'https://picsum.photos/seed/fac4/800/800' },
  { id: 5, category: 'Fasilitas', caption: 'Lapangan Olahraga Utama', image: 'https://picsum.photos/seed/fac5/800/600' },
  { id: 6, category: 'Fasilitas', caption: 'Asrama Putri Sakinah', image: 'https://picsum.photos/seed/fac6/800/1000' },
  { id: 7, category: 'Fasilitas', caption: 'Ruang Makan Bersama', image: 'https://picsum.photos/seed/fac7/800/700' },
  { id: 8, category: 'Fasilitas', caption: 'Gedung Kesenian', image: 'https://picsum.photos/seed/fac8/800/900' },
  { id: 9, category: 'Fasilitas', caption: 'Area Parkir Luas', image: 'https://picsum.photos/seed/fac9/800/600' },
  { id: 10, category: 'Fasilitas', caption: 'Kantin Sehat', image: 'https://picsum.photos/seed/fac10/800/800' },
]

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
        title="Fasilitas Modern Al-Hikmah" 
        subtitle="Kami berkomitmen menyediakan sarana dan prasarana terbaik untuk menunjang kenyamanan serta kualitas belajar mengajar para santri."
      />

      <!-- Grid -->
      <div class="columns-1 md:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6 mt-12" data-aos="fade-up">
        <div 
          v-for="img in images" 
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
