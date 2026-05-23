<script setup>
import { ref, onMounted, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import SectionHeading from '../components/ui/SectionHeading.vue'
import { Search, X } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const images = ref([])

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/facilities`)
    images.value = res.data.map(f => ({
      id: f.id,
      category: 'Fasilitas',
      caption: f.name,
      desc: f.description || '',
      image: f.imageUrl
    }))
  } catch (err) {
    console.error('Failed to fetch facilities:', err)
  }
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
      <title>Fasilitas | Pondok Modern Al-Hikmah</title>
      <meta name="description" content="Fasilitas penunjang pendidikan dan kehidupan santri di Pondok Modern Al-Hikmah.">
    </Head>
    <div class="container-custom">
      <SectionHeading 
        title="Fasilitas Modern Al-Hikmah" 
        subtitle="Kami berkomitmen menyediakan sarana dan prasarana terbaik untuk menunjang kenyamanan serta kualitas belajar mengajar para santri."
      />

      <!-- Card Grid Layout -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12" data-aos="fade-up">
        <div 
          v-for="img in images" 
          :key="img.id"
          @click="openLightbox(img)"
          class="glassmorphism rounded-3xl overflow-hidden shadow-xl hover:-translate-y-3 transition-all duration-500 group border border-white/10 hover:border-secondary/30 flex flex-col h-full cursor-pointer bg-white/5"
        >
          <!-- Image Section -->
          <div class="relative overflow-hidden aspect-video">
            <img 
              :src="img.image" 
              :alt="img.caption"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            <div class="absolute top-4 left-4">
              <span class="px-4 py-1.5 bg-secondary text-primary text-xs font-bold rounded-full shadow-lg">
                {{ img.category }}
              </span>
            </div>
            
            <!-- Hover Zoom Icon -->
            <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
              <div class="w-12 h-12 bg-secondary/90 rounded-full flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-500 delay-100">
                <Search class="text-primary" :size="24" />
              </div>
            </div>
          </div>
          
          <!-- Content Section -->
          <div class="p-8 flex-grow flex flex-col">
            <h4 class="text-2xl font-bold text-white mb-4 group-hover:text-secondary transition-colors">{{ img.caption }}</h4>
            <p class="text-white/70 leading-relaxed text-justify mb-2">
              {{ img.desc }}
            </p>
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
          <div class="mt-8 text-center max-w-3xl">
            <span class="px-4 py-1.5 bg-secondary text-primary text-xs font-bold rounded-full mb-4 inline-block">
              {{ selectedImage.category }}
            </span>
            <h4 class="text-2xl md:text-3xl font-bold text-white mb-4">{{ selectedImage.caption }}</h4>
            <p class="text-white/80 text-lg leading-relaxed">{{ selectedImage.desc }}</p>
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
