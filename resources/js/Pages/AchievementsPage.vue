<script setup>
import { ref, onMounted, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import SectionHeading from '../components/ui/SectionHeading.vue'
import { ArrowLeft, Trophy, Search, Award, Star, MapPin } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const achievements = ref([])
const loading = ref(true)
const searchQuery = ref('')
const activeFilter = ref('Semua')

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/achievements`)
    achievements.value = res.data
  } catch (err) {
    console.error('Failed to fetch achievements:', err)
  } finally {
    loading.value = false
  }
})

const filters = computed(() => {
  const sources = new Set(achievements.value.map(a => a.source_type?.toUpperCase() || 'Lainnya'))
  return ['Semua', ...Array.from(sources)]
})

const filteredAchievements = computed(() => {
  let filtered = achievements.value

  if (activeFilter.value !== 'Semua') {
    filtered = filtered.filter(a => (a.source_type?.toUpperCase() || 'Lainnya') === activeFilter.value)
  }

  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase()
    filtered = filtered.filter(a => 
      a.title?.toLowerCase().includes(q) || 
      a.level?.toLowerCase().includes(q) ||
      a.source?.toLowerCase().includes(q)
    )
  }

  return filtered
})
</script>

<template>
  <Head title="Prestasi Santri & Lembaga | Pondok Modern Al-Hikmah" />
  
  <main class="min-h-screen pt-24 pb-20">
    <!-- Header Banner -->
    <section class="relative py-20 mb-16 overflow-hidden">
      <div class="absolute inset-0 bg-[#081a24] -z-20"></div>
      <div class="absolute inset-0 bg-gradient-to-br from-secondary/10 to-transparent -z-10"></div>
      <div class="container-custom relative z-10">
        <router-link to="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-full text-white/80 hover:text-white transition-all mb-8 w-fit backdrop-blur-sm group" data-aos="fade-right">
          <ArrowLeft :size="20" class="group-hover:-translate-x-1 transition-transform" />
          <span class="font-medium text-sm tracking-wide">Kembali ke Beranda</span>
        </router-link>
        
        <div class="text-center">
          <div class="w-20 h-20 bg-secondary/10 rounded-3xl mx-auto flex items-center justify-center mb-6" data-aos="zoom-in">
            <Trophy class="text-secondary" :size="40" />
          </div>
          <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6" data-aos="fade-up">Prestasi & Penghargaan</h1>
          <p class="text-xl text-white/70 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Daftar raihan prestasi gemilang santri dan lembaga di tingkat Kabupaten, Provinsi, Nasional, hingga Internasional.
          </p>
        </div>
      </div>
    </section>

    <!-- Filters & Search -->
    <section class="container-custom mb-12">
      <div class="flex flex-col md:flex-row items-center justify-between gap-6" data-aos="fade-up">
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
          <button
            v-for="filter in filters"
            :key="filter"
            @click="activeFilter = filter"
            class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 whitespace-nowrap"
            :class="activeFilter === filter ? 'bg-secondary text-primary shadow-lg shadow-secondary/20' : 'bg-white/5 text-white/70 hover:bg-white/10 hover:text-white border border-white/10'"
          >
            {{ filter }}
          </button>
        </div>

        <div class="relative w-full md:w-80">
          <input 
            type="text" 
            v-model="searchQuery"
            placeholder="Cari prestasi..."
            class="w-full bg-white/5 text-white pl-12 pr-4 py-3 rounded-2xl border border-white/10 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all placeholder:text-white/40"
          />
          <Search class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40" :size="20" />
        </div>
      </div>
    </section>

    <!-- Content -->
    <section class="container-custom">
      <div v-if="loading" class="flex justify-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-secondary border-t-transparent"></div>
      </div>
      
      <div v-else-if="filteredAchievements.length === 0" class="text-center py-20 bg-white/5 rounded-3xl border border-white/10">
        <Star class="text-white/20 mx-auto mb-4" :size="64" />
        <h3 class="text-2xl font-bold text-white mb-2">Belum Ada Data</h3>
        <p class="text-white/50">Prestasi yang Anda cari belum tersedia atau belum ditambahkan.</p>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="(ach, idx) in filteredAchievements" 
          :key="idx"
          class="glassmorphism rounded-3xl p-8 border border-white/10 hover:border-secondary/40 transition-all duration-500 hover:-translate-y-2 group relative overflow-hidden flex flex-col h-full shadow-lg"
          data-aos="fade-up"
          :data-aos-delay="idx % 3 * 100"
        >
          <!-- Background Decor -->
          <div class="absolute -right-12 -top-12 w-40 h-40 bg-secondary/5 rounded-full blur-3xl group-hover:bg-secondary/20 transition-colors"></div>

          <!-- Top Row -->
          <div class="flex items-start justify-between mb-6 relative z-10">
            <div class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center border border-white/10 group-hover:bg-secondary/10 group-hover:border-secondary/30 transition-all">
              <Award class="text-secondary" :size="28" />
            </div>
            <div class="flex flex-col items-end gap-2">
              <span class="px-3 py-1 bg-white/10 text-white/80 text-xs font-bold rounded-full">
                {{ ach.year || 'Tahun?' }}
              </span>
              <span class="px-3 py-1 bg-secondary/20 text-secondary text-xs font-bold rounded-full">
                {{ ach.level || 'Tingkat?' }}
              </span>
            </div>
          </div>

          <!-- Content -->
          <div class="relative z-10 flex-grow">
            <h3 class="text-xl font-bold text-white mb-4 leading-snug group-hover:text-secondary transition-colors">{{ ach.title }}</h3>
          </div>
          
          <!-- Bottom Source -->
          <div class="relative z-10 pt-6 mt-auto border-t border-white/10 flex items-center gap-2">
            <MapPin class="text-white/40" :size="16" />
            <span class="text-sm font-medium text-white/60 group-hover:text-white/80 transition-colors">{{ ach.source }}</span>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>
