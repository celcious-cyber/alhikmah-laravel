<script setup>
import { ref, onMounted, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import {
  ArrowLeft, BookOpen, GraduationCap, Library, Building,
  Award, Users, CalendarDays, FileCheck, FileText, CheckCircle,
  Trophy, Star, ChevronDown, ChevronUp
} from 'lucide-vue-next'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, EffectFade } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/effect-fade'

const props = defineProps({
  type: { type: String, required: true }
})

const API_URL = import.meta.env.VITE_API_URL || ''
const curriculum = ref(null)
const loading = ref(true)
const openAccordion = ref(null)

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/curricula/${props.type}`)
    curriculum.value = res.data
  } catch (err) {
    console.error('Failed to fetch curriculum:', err)
  } finally {
    loading.value = false
  }
})

const typeLabel = computed(() => {
  const labels = { kmi: 'KMI', smp: 'SMP', ma: 'MA' }
  return labels[props.type] || props.type.toUpperCase()
})

const typeColor = computed(() => {
  const colors = { kmi: 'from-amber-500/20', smp: 'from-blue-500/20', ma: 'from-green-500/20' }
  return colors[props.type] || 'from-secondary/20'
})

const typeIcon = computed(() => {
  const icons = { kmi: BookOpen, smp: Library, ma: GraduationCap }
  return icons[props.type] || BookOpen
})

const subjectGroups = computed(() => {
  if (!curriculum.value?.subjects) return {}
  const groups = {}
  curriculum.value.subjects.forEach(s => {
    const g = s.type || 'umum'
    if (!groups[g]) groups[g] = []
    groups[g].push(s.name)
  })
  return groups
})

const subjectGroupLabels = {
  agama: 'Dirasah Islamiyah / Agama',
  bahasa: 'Bahasa',
  sains: 'Sains & Teknologi',
  umum: 'Umum / Nasional'
}

const subjectGroupColors = {
  agama: 'border-amber-500/30 bg-amber-500/5',
  bahasa: 'border-blue-500/30 bg-blue-500/5',
  sains: 'border-green-500/30 bg-green-500/5',
  umum: 'border-purple-500/30 bg-purple-500/5'
}


function toggleAccordion(key) {
  openAccordion.value = openAccordion.value === key ? null : key
}
</script>

<template>
  <Head :title="`Kurikulum ${typeLabel} | Pondok Modern Al-Hikmah`" />

  <main class="min-h-screen pt-24 pb-20">
    <!-- ─── Loading ─────────────────────────────────── -->
    <div v-if="loading" class="flex items-center justify-center min-h-[60vh]">
      <div class="animate-spin rounded-full h-16 w-16 border-4 border-secondary border-t-transparent"></div>
    </div>

    <template v-else-if="curriculum">
      <!-- ─── Hero Banner ────────────────────────────── -->
      <section class="relative overflow-hidden mb-16">
        <!-- Background image / gradient -->
        <div class="absolute inset-0 -z-20 bg-[#081a24]"></div>
        
        <div v-if="Array.isArray(curriculum.background_image) && curriculum.background_image.length > 0" class="absolute inset-0 -z-10">
          <Swiper
            :modules="[Autoplay, EffectFade]"
            effect="fade"
            :autoplay="{ delay: 5000, disableOnInteraction: false }"
            :loop="true"
            class="w-full h-full"
          >
            <SwiperSlide v-for="(img, idx) in curriculum.background_image" :key="idx">
              <div 
                class="w-full h-full"
                :style="`background-image: url('/storage/${img}'); background-size: cover; background-position: center;`"
              ></div>
            </SwiperSlide>
          </Swiper>
        </div>
        <div
          v-else-if="curriculum.thumbnail || (typeof curriculum.background_image === 'string' && curriculum.background_image)"
          class="absolute inset-0 -z-10"
          :style="`background-image: url('${typeof curriculum.background_image === 'string' ? '/storage/' + curriculum.background_image : curriculum.thumbnail}'); background-size: cover; background-position: center;`"
        ></div>
        
        <!-- Overlay yang lebih gelap agar tulisan kontras -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#081a24]/95 via-[#081a24]/80 to-[#081a24]"></div>

        <div class="container-custom relative z-10 py-24">
          <!-- Back -->
          <router-link
            to="/kurikulum"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-full text-white/80 hover:text-white transition-all mb-10 w-fit backdrop-blur-sm group"
            data-aos="fade-right"
          >
            <ArrowLeft :size="18" class="group-hover:-translate-x-1 transition-transform" />
            <span class="text-sm font-medium">Semua Kurikulum</span>
          </router-link>

          <div class="flex flex-col md:flex-row gap-8 items-start md:items-center">
            <!-- Logo -->
            <div class="w-24 h-auto md:w-32 shrink-0" data-aos="zoom-in" data-aos-delay="100">
              <img :src="`/assets/images/${curriculum.type.toUpperCase()}.png`" :alt="`Logo ${curriculum.type.toUpperCase()}`" class="w-full h-auto drop-shadow-xl" />
            </div>

            <div data-aos="fade-up">
              <span class="px-3 py-1 bg-secondary/20 text-secondary text-xs font-bold rounded-full mb-3 inline-block uppercase tracking-widest">
                {{ typeLabel }}
              </span>
              <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-3 leading-tight">
                {{ curriculum.name }}
              </h1>
              <p v-if="curriculum.tagline" class="text-lg text-secondary font-medium">
                {{ curriculum.tagline }}
              </p>
            </div>
          </div>

          <!-- Stats bar -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12" data-aos="fade-up" data-aos-delay="100">
            <div v-if="curriculum.year_established" class="glassmorphism rounded-2xl p-4 text-center border border-white/10">
              <CalendarDays class="text-secondary mx-auto mb-2" :size="20" />
              <p class="text-2xl font-bold text-white">{{ curriculum.year_established }}</p>
              <p class="text-xs text-white/50">Tahun Berdiri</p>
            </div>
            <div v-if="curriculum.total_students" class="glassmorphism rounded-2xl p-4 text-center border border-white/10">
              <Users class="text-secondary mx-auto mb-2" :size="20" />
              <p class="text-2xl font-bold text-white">{{ curriculum.total_students }}+</p>
              <p class="text-xs text-white/50">Santri / Siswa</p>
            </div>
            <div v-if="curriculum.total_teachers" class="glassmorphism rounded-2xl p-4 text-center border border-white/10">
              <GraduationCap class="text-secondary mx-auto mb-2" :size="20" />
              <p class="text-2xl font-bold text-white">{{ curriculum.total_teachers }}</p>
              <p class="text-xs text-white/50">Pengajar</p>
            </div>

          </div>
        </div>
      </section>

      <div class="container-custom space-y-12">
        <!-- ─── Deskripsi & Sejarah ────────────────────── -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
          <!-- Deskripsi + Sejarah -->
          <div class="lg:col-span-3 space-y-8">
            <div v-if="curriculum.description" class="glassmorphism rounded-3xl p-8 border border-white/10" data-aos="fade-up">
              <h2 class="text-2xl font-bold text-white mb-5 flex items-center gap-3">
                <Building class="text-secondary" :size="24" />
                Tentang Lembaga
              </h2>
              <p class="text-white/75 leading-relaxed text-lg text-justify">{{ curriculum.description }}</p>
            </div>

            <div v-if="curriculum.history" class="glassmorphism rounded-3xl p-8 border border-white/10" data-aos="fade-up">
              <h2 class="text-2xl font-bold text-white mb-5 flex items-center gap-3">
                <CalendarDays class="text-secondary" :size="24" />
                Sejarah Lembaga
              </h2>
              <p class="text-white/75 leading-relaxed text-lg text-justify">{{ curriculum.history }}</p>
            </div>
          </div>

          <!-- Kepala Lembaga + Legalitas -->
          <div class="lg:col-span-2 space-y-6">
            <!-- Kepala Lembaga -->
            <div v-if="curriculum.head_name" class="glassmorphism rounded-3xl p-8 border border-white/10 text-center" data-aos="fade-left">
              <img
                v-if="curriculum.head_photo"
                :src="curriculum.head_photo"
                :alt="curriculum.head_name"
                class="w-28 h-28 rounded-full object-cover mx-auto mb-4 border-2 border-secondary shadow-xl"
              />
              <div v-else class="w-28 h-28 rounded-full bg-secondary/10 border-2 border-secondary/30 mx-auto mb-4 flex items-center justify-center">
                <Users class="text-secondary" :size="40" />
              </div>
              <h3 class="text-xl font-bold text-white">{{ curriculum.head_name }}</h3>
              <p v-if="curriculum.head_title" class="text-secondary text-sm mt-1">{{ curriculum.head_title }}</p>
            </div>

            <!-- Legalitas -->
            <div v-if="curriculum.legalities?.length" class="glassmorphism rounded-3xl p-8 border border-white/10" data-aos="fade-left" data-aos-delay="100">
              <h2 class="text-xl font-bold text-white mb-5 flex items-center gap-3">
                <FileCheck class="text-secondary" :size="22" />
                Data & Legalitas
              </h2>
              <div class="space-y-4">
                <div v-for="(legality, idx) in curriculum.legalities" :key="idx" class="flex items-start gap-3 p-3 bg-white/5 rounded-xl">
                  <FileText class="text-secondary shrink-0 mt-0.5" :size="16" />
                  <div>
                    <p class="text-xs text-white/50 uppercase tracking-wider">{{ legality.name }}</p>
                    <p class="text-white font-semibold">{{ legality.value }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ─── Keunggulan ────────────────────────────── -->
        <div v-if="curriculum.features?.length" data-aos="fade-up">
          <h2 class="text-3xl font-bold text-white mb-8 flex items-center gap-3">
            <Star class="text-secondary" :size="28" />
            Keunggulan Program
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
              v-for="(feat, i) in curriculum.features"
              :key="i"
              class="glassmorphism rounded-2xl p-5 border border-white/10 hover:border-secondary/40 transition-all duration-300 hover:-translate-y-1 flex items-start gap-4 group"
              data-aos="fade-up"
              :data-aos-delay="i % 3 * 80"
            >
              <CheckCircle class="text-secondary shrink-0 mt-0.5 group-hover:scale-110 transition-transform" :size="20" />
              <span class="text-white/85 font-medium leading-snug">{{ feat.item || feat }}</span>
            </div>
          </div>
        </div>

        <!-- ─── Mata Pelajaran ─────────────────────────── -->
        <div v-if="Object.keys(subjectGroups).length" data-aos="fade-up">
          <h2 class="text-3xl font-bold text-white mb-8 flex items-center gap-3">
            <BookOpen class="text-secondary" :size="28" />
            Mata Pelajaran
          </h2>
          <div class="space-y-4">
            <div
              v-for="(subjects, groupKey) in subjectGroups"
              :key="groupKey"
              class="glassmorphism rounded-2xl border overflow-hidden"
              :class="subjectGroupColors[groupKey] || 'border-white/10'"
            >
              <!-- Accordion header -->
              <button
                @click="toggleAccordion(groupKey)"
                class="w-full flex items-center justify-between p-5 hover:bg-white/5 transition-colors"
              >
                <span class="font-bold text-white text-lg">{{ subjectGroupLabels[groupKey] || groupKey }}</span>
                <component :is="openAccordion === groupKey ? ChevronUp : ChevronDown" class="text-secondary" :size="20" />
              </button>
              <!-- Accordion body -->
              <div v-show="openAccordion === groupKey" class="px-5 pb-5 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div v-for="(s, i) in subjects" :key="i" class="flex items-center gap-3 p-3 bg-white/5 rounded-xl">
                  <div class="w-2 h-2 rounded-full bg-secondary shrink-0"></div>
                  <span class="text-white/80 text-sm">{{ s }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ─── Prestasi ────────────────────────────────── -->
        <div v-if="curriculum.achievements?.length" data-aos="fade-up">
          <h2 class="text-3xl font-bold text-white mb-8 flex items-center gap-3">
            <Trophy class="text-secondary" :size="28" />
            Prestasi & Penghargaan
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <div
              v-for="(ach, i) in curriculum.achievements"
              :key="i"
              class="glassmorphism rounded-2xl p-6 border border-white/10 hover:border-secondary/40 transition-all hover:-translate-y-1 group"
            >
              <div class="flex items-center justify-between mb-3">
                <span class="px-3 py-1 bg-secondary/15 text-secondary text-xs font-bold rounded-full">{{ ach.level }}</span>
                <span class="text-white/40 text-sm font-medium">{{ ach.year }}</span>
              </div>
              <p class="text-white font-semibold leading-snug">{{ ach.title }}</p>
            </div>
          </div>
        </div>
      </div>
    </template>

    <!-- Not found -->
    <div v-else class="container-custom text-center py-32">
      <p class="text-white/50 text-xl">Data kurikulum tidak ditemukan.</p>
      <router-link to="/kurikulum" class="mt-6 inline-flex items-center gap-2 text-secondary hover:underline">
        <ArrowLeft :size="18" /> Kembali ke Kurikulum
      </router-link>
    </div>
  </main>
</template>
