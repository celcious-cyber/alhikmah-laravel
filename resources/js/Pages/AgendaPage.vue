<script setup>
import { ref, onMounted, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import { ArrowLeft, Calendar, CalendarDays, Clock, CheckCircle2 } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const agendasGrouped = ref({})
const loading = ref(true)
const activeTab = ref('harian')

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/agendas`)
    agendasGrouped.value = res.data
  } catch (err) {
    console.error('Failed to fetch agendas:', err)
  } finally {
    loading.value = false
  }
})

const tabs = [
  { id: 'harian', label: 'Harian' },
  { id: 'mingguan', label: 'Mingguan' },
  { id: 'bulanan', label: 'Bulanan' },
  { id: 'tahunan', label: 'Tahunan' },
]

const currentAgendas = computed(() => {
  return agendasGrouped.value[activeTab.value] || []
})
</script>

<template>
  <Head title="Agenda Santri | Pondok Modern Al-Hikmah" />
  
  <main class="min-h-screen pt-24 pb-20">
    <!-- Header Banner -->
    <section class="relative py-20 mb-12 overflow-hidden">
      <div class="absolute inset-0 bg-[#081a24] -z-20"></div>
      <div class="absolute inset-0 bg-gradient-to-br from-secondary/10 to-transparent -z-10"></div>
      <div class="container-custom relative z-10">
        <router-link to="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-full text-white/80 hover:text-white transition-all mb-8 w-fit backdrop-blur-sm group" data-aos="fade-right">
          <ArrowLeft :size="20" class="group-hover:-translate-x-1 transition-transform" />
          <span class="font-medium text-sm tracking-wide">Kembali ke Beranda</span>
        </router-link>
        
        <div class="text-center">
          <div class="w-20 h-20 bg-secondary/10 rounded-3xl mx-auto flex items-center justify-center mb-6" data-aos="zoom-in">
            <Calendar class="text-secondary" :size="40" />
          </div>
          <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6" data-aos="fade-up">Agenda Santri</h1>
          <p class="text-xl text-white/70 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Jadwal kegiatan terpadu yang membina kedisiplinan dan karakter santri 24 jam penuh di Pondok Modern Al-Hikmah.
          </p>
        </div>
      </div>
    </section>

    <section class="container-custom max-w-5xl mx-auto">
      <!-- Tabs -->
      <div class="flex overflow-x-auto md:flex-wrap md:justify-center gap-2 md:gap-4 mb-12 pb-4 pt-2 px-2 hide-scrollbar snap-x" data-aos="fade-up">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          class="px-6 py-3 rounded-full text-sm md:text-base font-bold transition-all duration-300 flex items-center gap-2 shrink-0 snap-center"
          :class="activeTab === tab.id ? 'bg-secondary text-primary shadow-lg shadow-secondary/20 scale-105' : 'bg-white/5 text-white/70 hover:bg-white/10 hover:text-white border border-white/10'"
        >
          <CalendarDays :size="18" v-if="activeTab !== tab.id" />
          <CheckCircle2 :size="18" v-else />
          Agenda {{ tab.label }}
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-secondary border-t-transparent"></div>
      </div>

      <!-- Empty State -->
      <div v-else-if="currentAgendas.length === 0" class="text-center py-20 bg-white/5 rounded-3xl border border-white/10">
        <Clock class="text-white/20 mx-auto mb-4" :size="64" />
        <h3 class="text-2xl font-bold text-white mb-2">Belum Ada Agenda</h3>
        <p class="text-white/50">Agenda untuk kategori ini belum ditambahkan.</p>
      </div>

      <!-- Timeline/List Layout -->
      <div v-else class="relative">
        <!-- Vertical Line -->
        <div class="absolute left-8 md:left-1/2 top-0 bottom-0 w-px bg-white/20 md:-translate-x-1/2"></div>
        
        <div class="space-y-6 md:space-y-12">
          <div 
            v-for="(agenda, index) in currentAgendas" 
            :key="agenda.id"
            class="relative flex flex-col md:flex-row items-center gap-6 md:gap-0"
            data-aos="fade-up"
          >
            <!-- Timeline Dot -->
            <div class="flex absolute left-8 md:left-1/2 -translate-x-1/2 w-10 h-10 rounded-full bg-[#0a2230] border-4 border-secondary items-center justify-center z-10 shadow-lg shadow-secondary/20">
              <span class="text-white font-bold text-sm">{{ index + 1 }}</span>
            </div>

            <!-- Left side content (Even index) -->
            <div class="w-full pl-20 md:pl-0 md:w-1/2 md:pr-12" :class="index % 2 === 0 ? 'md:text-right md:order-1' : 'md:text-left md:order-3 md:ml-auto md:pl-12'">
              <div class="glassmorphism rounded-3xl p-6 border border-white/10 hover:border-secondary/40 transition-colors group">
                <div class="flex items-center gap-3 mb-3" :class="index % 2 === 0 ? 'md:justify-end' : ''">
                  <span class="px-3 py-1 bg-secondary/10 text-secondary text-xs font-bold rounded-full flex items-center gap-1.5 border border-secondary/20">
                    <Clock :size="14" /> {{ agenda.time || 'Waktu tidak ditentukan' }}
                  </span>
                </div>
                <h3 class="text-xl font-bold text-white mb-3 group-hover:text-secondary transition-colors leading-snug">
                  {{ agenda.title }}
                </h3>
                <p class="text-white/60 leading-relaxed text-sm">
                  {{ agenda.description }}
                </p>
              </div>
            </div>
            
            <!-- Spacer for order trick (Desktop only) -->
            <div class="hidden md:block w-full md:w-1/2 md:order-2"></div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
</style>
