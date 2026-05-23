<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import { useI18n } from 'vue-i18n'
import SectionHeading from '../components/ui/SectionHeading.vue'
import BaseButton from '../components/ui/BaseButton.vue'
import { ArrowLeft } from 'lucide-vue-next'

const { t } = useI18n()
const API_URL = import.meta.env.VITE_API_URL || ''

const dynamicPrograms = ref([])
const loading = ref(true)

const fetchPrograms = async () => {
  try {
    const res = await axios.get(`${API_URL}/api/programs`)
    dynamicPrograms.value = res.data
  } catch (err) {
    console.error('Error fetching programs:', err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchPrograms)

const ALL_TAB = 'Semua'

const tabs = computed(() => {
  if (dynamicPrograms.value.length === 0) return [ALL_TAB]
  const categories = [...new Set(dynamicPrograms.value.map(p => p.category).filter(Boolean))]
  return [ALL_TAB, ...categories]
})

const activeTab = ref(ALL_TAB)

const programs = computed(() => {
  return dynamicPrograms.value.map(p => ({
    id: p.id,
    title: p.title,
    category: p.category,
    desc: p.description,
    image: p.imageUrl || null
  }))
})

const filteredPrograms = computed(() => {
  if (activeTab.value === ALL_TAB) return programs.value
  return programs.value.filter(p => p.category === activeTab.value)
})
</script>

<template>
  <Head title="Program Unggulan | Pondok Modern Al-Hikmah" />
  
  <main class="min-h-screen pt-24 pb-20">
    <!-- Header Banner -->
    <section class="relative py-20 mb-16 overflow-hidden">
      <div class="absolute inset-0 bg-[#081a24] -z-20"></div>
      <div class="absolute inset-0 bg-gradient-to-br from-secondary/10 to-transparent -z-10"></div>
      <div class="container-custom relative z-10">
        <!-- Back Button -->
        <router-link to="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-full text-white/80 hover:text-white transition-all mb-8 w-fit backdrop-blur-sm group" data-aos="fade-right">
          <ArrowLeft :size="20" class="group-hover:-translate-x-1 transition-transform" />
          <span class="font-medium text-sm tracking-wide">Kembali ke Beranda</span>
        </router-link>
        
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6" data-aos="fade-up">Program Unggulan</h1>
          <p class="text-xl text-white/70 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Daftar lengkap program unggulan, ekstrakurikuler, dan kegiatan santri Pondok Modern Al-Hikmah.
          </p>
        </div>
      </div>
    </section>

    <!-- Grid Section -->
    <section class="container-custom">
      <!-- Tabs -->
      <div class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up">
        <button 
          v-for="tab in tabs" 
          :key="tab"
          @click="activeTab = tab"
          class="px-8 py-3 rounded-full font-bold transition-all duration-300"
          :class="activeTab === tab ? 'bg-secondary text-primary shadow-lg shadow-secondary/20' : 'bg-white/5 text-white/70 hover:bg-white/10 hover:text-white border border-white/10'"
        >
          {{ tab }}
        </button>
      </div>

      <!-- Grid -->
      <div v-if="loading" class="flex justify-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-secondary border-t-transparent"></div>
      </div>
      
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div 
          v-for="(program, index) in filteredPrograms" 
          :key="program.id"
          class="glassmorphism rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 group h-full flex flex-col border border-white/10 hover:border-secondary/30"
          data-aos="fade-up"
          :data-aos-delay="index % 3 * 100"
        >
          <!-- Image -->
          <div class="relative overflow-hidden aspect-video bg-white/5">
            <img 
              :src="program.image || `https://placehold.co/600x400/0d2535/F7C04A?text=${encodeURIComponent(program.title)}`" 
              :alt="program.title"
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
              loading="lazy"
            />
            <div class="absolute top-4 left-4">
              <span class="px-4 py-1.5 bg-secondary text-primary text-xs font-bold rounded-full shadow-lg">
                {{ program.category }}
              </span>
            </div>
          </div>

          <!-- Content -->
          <div class="p-8 space-y-4 flex-grow bg-white/5">
            <h4 class="text-2xl font-bold text-white">{{ program.title }}</h4>
            <p class="text-white/70 leading-relaxed text-justify">
              {{ program.desc }}
            </p>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>
