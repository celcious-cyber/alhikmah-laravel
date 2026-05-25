<script setup>
import { ref, onMounted, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import { ArrowLeft, Users, Globe2, GraduationCap, MapPin, Search, Star, Award } from 'lucide-vue-next'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, EffectFade } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/effect-fade'

const props = defineProps({
  backgroundImages: {
    type: Array,
    default: () => []
  }
})

const API_URL = import.meta.env.VITE_API_URL || ''
const alumni = ref([])
const distribution = ref({})
const featured = ref([])
const totalAlumniCount = ref(0)
const totalPutra = ref(null)
const totalPutri = ref(null)
const loading = ref(true)

const searchQuery = ref('')
const activeCountryFilter = ref('Semua')

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/alumni`)
    alumni.value = res.data.alumni
    distribution.value = res.data.distribution
    featured.value = res.data.featured
    totalAlumniCount.value = res.data.total_count
    totalPutra.value = res.data.total_putra
    totalPutri.value = res.data.total_putri
  } catch (err) {
    console.error('Failed to fetch alumni data:', err)
  } finally {
    loading.value = false
  }
})

const countryFilters = computed(() => {
  return ['Semua', ...Object.keys(distribution.value)]
})

const filteredAlumni = computed(() => {
  let result = alumni.value

  if (activeCountryFilter.value !== 'Semua') {
    result = result.filter(a => a.country === activeCountryFilter.value)
  }

  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase()
    result = result.filter(a => 
      a.name.toLowerCase().includes(q) ||
      a.university.toLowerCase().includes(q) ||
      a.graduation_year.toString().includes(q)
    )
  }

  return result
})
</script>

<template>
  <Head title="IKPH & Alumni | Pondok Modern Al-Hikmah" />
  
  <main class="min-h-screen pt-24 pb-20">
    <!-- Header Banner -->
    <section class="relative py-20 mb-16 overflow-hidden">
      <div class="absolute inset-0 bg-[#081a24] -z-20"></div>
      
      <!-- Carousel Background -->
      <div v-if="backgroundImages && backgroundImages.length > 0" class="absolute inset-0 -z-10">
        <Swiper
          :modules="[Autoplay, EffectFade]"
          effect="fade"
          :autoplay="{ delay: 5000, disableOnInteraction: false }"
          :loop="true"
          class="w-full h-full"
        >
          <SwiperSlide v-for="(img, idx) in backgroundImages" :key="idx">
            <div 
              class="w-full h-full"
              :style="`background-image: url('/storage/${img}'); background-size: cover; background-position: center;`"
            ></div>
          </SwiperSlide>
        </Swiper>
      </div>
      
      <!-- Overlay yang lebih gelap agar tulisan kontras -->
      <div class="absolute inset-0 bg-gradient-to-br from-[#081a24]/95 via-[#081a24]/80 to-transparent -z-10" :class="(!backgroundImages || backgroundImages.length === 0) ? 'from-secondary/10' : ''"></div>
      
      <div class="container-custom relative z-10">
        <router-link to="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-full text-white/80 hover:text-white transition-all mb-8 w-fit backdrop-blur-sm group" data-aos="fade-right">
          <ArrowLeft :size="20" class="group-hover:-translate-x-1 transition-transform" />
          <span class="font-medium text-sm tracking-wide">Kembali ke Beranda</span>
        </router-link>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div>
            <div class="w-28 md:w-36 h-auto mb-6" data-aos="zoom-in">
              <img src="/assets/images/IKPH.svg" alt="Logo IKPH" class="w-full h-auto drop-shadow-xl" />
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight" data-aos="fade-up">
              Ikatan Keluarga<br/>Pondok Modern<br/><span class="text-secondary">Al-Hikmah (IKPH)</span>
            </h1>
            <p class="text-lg md:text-xl text-white/70 max-w-2xl" data-aos="fade-up" data-aos-delay="100">
              Mewadahi seluruh alumni yang tersebar di berbagai belahan dunia. 
              Dari Al-Hikmah, kami lahir untuk berkontribusi bagi bangsa dan agama di universitas-universitas terkemuka.
            </p>
          </div>
          
          <!-- Quick Stats Cards -->
          <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
            <div class="glassmorphism p-6 rounded-3xl border border-white/10 text-center relative overflow-hidden group">
              <div class="absolute inset-0 bg-secondary/5 group-hover:bg-secondary/10 transition-colors"></div>
              <Globe2 class="text-secondary mx-auto mb-4" :size="32" />
              <h3 class="text-4xl font-extrabold text-white mb-2">{{ Object.keys(distribution).length }}</h3>
              <p class="text-white/60 font-medium">Negara Tujuan</p>
            </div>
            <div class="glassmorphism p-6 rounded-3xl border border-white/10 text-center relative overflow-hidden group">
              <div class="absolute inset-0 bg-secondary/5 group-hover:bg-secondary/10 transition-colors"></div>
              <GraduationCap class="text-secondary mx-auto mb-4" :size="32" />
              <h3 class="text-4xl font-extrabold text-white mb-2">{{ totalAlumniCount }}</h3>
              <p class="text-white/60 font-medium mb-1">Data Alumni</p>
              <div v-if="totalPutra !== null || totalPutri !== null" class="flex justify-center gap-3 text-xs text-white/50 mt-2">
                <span v-if="totalPutra !== null">Putra: <span class="text-white/80 font-bold">{{ totalPutra }}</span></span>
                <span v-if="totalPutra !== null && totalPutri !== null">|</span>
                <span v-if="totalPutri !== null">Putri: <span class="text-white/80 font-bold">{{ totalPutri }}</span></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div v-if="loading" class="flex justify-center py-20">
      <div class="animate-spin rounded-full h-12 w-12 border-4 border-secondary border-t-transparent"></div>
    </div>

    <template v-else>
      <!-- Alumni Distribution -->
      <section class="container-custom mb-20">
        <div class="text-center mb-12" data-aos="fade-up">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Persebaran Alumni</h2>
          <p class="text-white/60 max-w-2xl mx-auto">
            Jejak langkah santri Al-Hikmah menuntut ilmu di universitas dalam dan luar negeri.
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
          <div 
            v-for="(count, country, index) in distribution" 
            :key="country"
            class="glassmorphism p-6 rounded-3xl border border-white/10 hover:border-secondary/30 transition-all hover:-translate-y-1 flex flex-col items-center justify-center text-center group cursor-default"
            data-aos="zoom-in"
            :data-aos-delay="index * 50"
          >
            <div class="w-14 h-14 bg-white/5 group-hover:bg-secondary/10 rounded-full flex items-center justify-center mb-4 transition-colors">
              <MapPin class="text-secondary" :size="24" />
            </div>
            <h3 class="text-xl font-bold text-white mb-1">{{ country }}</h3>
            <p class="text-secondary font-medium">{{ count }} Alumni</p>
          </div>
        </div>
      </section>

      <!-- Featured Alumni / Testimonials -->
      <section v-if="featured.length > 0" class="container-custom mb-20 relative">
        <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-secondary/20 to-transparent -z-10"></div>
        
        <div class="text-center mb-12" data-aos="fade-up">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Kisah Inspiratif</h2>
          <p class="text-white/60 max-w-2xl mx-auto">
            Testimoni dan pesan kesan dari perwakilan alumni IKPH.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
          <div 
            v-for="alumnus in featured" 
            :key="alumnus.id"
            class="glassmorphism rounded-3xl p-8 border border-white/10 relative mt-10 hover:-translate-y-2 transition-transform duration-300"
            data-aos="fade-up"
          >
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 rounded-2xl bg-[#0a2230] border-4 border-secondary overflow-hidden shadow-xl">
              <img v-if="alumnus.photo" :src="`/storage/${alumnus.photo}`" :alt="alumnus.name" class="w-full h-full object-cover" />
              <div v-else class="w-full h-full flex items-center justify-center bg-white/5">
                <Users class="text-secondary/50" :size="32" />
              </div>
            </div>

            <div class="pt-10 text-center">
              <h3 class="text-xl font-bold text-white mb-1">{{ alumnus.name }}</h3>
              <p class="text-secondary text-sm font-semibold mb-4 tracking-wide">{{ alumnus.profession || 'Alumni' }}</p>
              
              <div class="flex items-center justify-center gap-2 text-white/50 text-sm mb-6 bg-white/5 py-2 px-4 rounded-full w-fit mx-auto">
                <Award :size="16" />
                <span>{{ alumnus.university }} • Angkatan {{ alumnus.graduation_year }}</span>
              </div>

              <div class="relative">
                <Star class="absolute -top-3 -left-2 text-secondary/20 rotate-180" :size="24" />
                <p class="text-white/80 italic relative z-10 text-sm md:text-base leading-relaxed px-4">
                  "{{ alumnus.testimony }}"
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Complete Alumni List -->
      <section class="container-custom" id="direktori">
        <div class="glassmorphism rounded-[2.5rem] p-8 md:p-12 border border-white/10">
          <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div>
              <h2 class="text-3xl font-bold text-white mb-2">Direktori Alumni</h2>
              <p class="text-white/60">Cari dan temukan jejaring alumni Al-Hikmah.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
              <!-- Filter Select -->
              <div class="relative min-w-[160px]">
                <select 
                  v-model="activeCountryFilter"
                  class="w-full appearance-none bg-white/5 text-white px-4 py-3 rounded-2xl border border-white/10 focus:border-secondary outline-none cursor-pointer"
                >
                  <option v-for="c in countryFilters" :key="c" :value="c" class="bg-[#0a2230]">{{ c }}</option>
                </select>
                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                  <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
              </div>

              <!-- Search -->
              <div class="relative w-full sm:w-64">
                <input 
                  type="text" 
                  v-model="searchQuery"
                  placeholder="Cari nama atau angkatan..."
                  class="w-full bg-white/5 text-white pl-10 pr-4 py-3 rounded-2xl border border-white/10 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none placeholder:text-white/40"
                />
                <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-white/40" :size="18" />
              </div>
            </div>
          </div>

          <!-- Table -->
          <div class="overflow-x-auto rounded-2xl border border-white/5">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-white/5 text-white/60 text-sm">
                  <th class="py-4 px-6 font-medium whitespace-nowrap">Nama Lengkap</th>
                  <th class="py-4 px-6 font-medium whitespace-nowrap">Angkatan</th>
                  <th class="py-4 px-6 font-medium whitespace-nowrap">Universitas</th>
                  <th class="py-4 px-6 font-medium whitespace-nowrap">Negara</th>
                  <th class="py-4 px-6 font-medium whitespace-nowrap">Profesi / Jurusan</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="filteredAlumni.length === 0">
                  <td colspan="5" class="py-8 text-center text-white/40">Data tidak ditemukan.</td>
                </tr>
                <tr 
                  v-for="(alumnus, idx) in filteredAlumni" 
                  :key="alumnus.id"
                  class="border-t border-white/5 hover:bg-white/[0.02] transition-colors"
                >
                  <td class="py-4 px-6 text-white font-medium whitespace-nowrap">{{ alumnus.name }}</td>
                  <td class="py-4 px-6 text-white/70 whitespace-nowrap">
                    <span class="px-2.5 py-1 bg-white/5 rounded-md text-xs font-bold">{{ alumnus.graduation_year }}</span>
                  </td>
                  <td class="py-4 px-6 text-white/80 whitespace-nowrap">
                    {{ alumnus.university }}
                  </td>
                  <td class="py-4 px-6 whitespace-nowrap">
                    <span class="flex items-center gap-1.5 text-secondary text-sm">
                      <MapPin :size="14" /> {{ alumnus.country }}
                    </span>
                  </td>
                  <td class="py-4 px-6 text-white/60 text-sm whitespace-nowrap">
                    {{ alumnus.profession || alumnus.major || '-' }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </template>
  </main>
</template>
