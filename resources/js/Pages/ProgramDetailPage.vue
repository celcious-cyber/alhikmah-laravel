<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import { ArrowLeft, BookOpen, GraduationCap, Target, Users, Star, Tent, Activity, Heart, Bookmark } from 'lucide-vue-next'
import axios from 'axios'

const props = defineProps({
  slug: {
    type: String,
    required: true
  }
})

const API_URL = import.meta.env.VITE_API_URL || ''
const dbProgram = ref(null)
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/programs`)
    // Match by generated slug (same logic as controller: Str::slug)
    const match = res.data.find(p => p.slug === props.slug)
    if (match) dbProgram.value = match
  } catch (err) {
    console.error('Failed to fetch program:', err)
  } finally {
    loading.value = false
  }
})

// Static fallback data for features/details not stored in DB yet
const staticData = {
  'kelas-6-kmi': {
    subtitle: 'Masa Bimbingan Akhir & Persiapan Pengabdian',
    icon: GraduationCap,
    features: [
      'Amaliyah Tadris (Praktek Mengajar)',
      'Penulisan Karya Tulis Ilmiah (Paper)',
      'Pembekalan Khutbatul Wada (Pesan Perpisahan)',
      'Fathul Mu\'jam (Bimbingan Kamus Arab-Inggris)',
      'Persiapan Penempatan Pengabdian'
    ]
  },
  'kelas-5-kmi': {
    subtitle: 'Estafet Kepemimpinan & Organisasi',
    icon: Target,
    features: [
      'Pengurus OPPH & Koordinator Pramuka',
      'Kepanitiaan Acara Besar Pondok',
      'Bimbingan Pidato 3 Bahasa Ekstensif',
      'Pendalaman Kitab Kuning Lanjutan',
      'Kajian Fiqih Kontemporer'
    ]
  },
  'tahfidz-al-quran': {
    subtitle: 'Menjaga Kalam Ilahi',
    icon: BookOpen,
    features: [
      'Hafalan Mandiri & Setoran Harian',
      'Tasmi\' (Ujian Dengar Hafalan) Berkala',
      'Pembinaan Tahsin & Tajwid Bersanad',
      'Karantina Tahfidz Khusus (Liburan)',
      'Sertifikasi Hafalan (Syahadah)'
    ]
  },
  'ekstrakurikuler-umum': {
    subtitle: 'Pengembangan Minat & Bakat Santri',
    icon: Activity,
    features: [
      'Klub Olahraga (Futsal, Voli, Basket, Beladiri)',
      'Klub Bahasa (Arabic & English Club)',
      'Kesenian (Kaligrafi, Nasyid, Hadroh, Marching Band)',
      'Jurnalistik & Jami\'yatul Khutoba (Pidato)',
      'Keterampilan (Menjahit, Komputer, Multimedia)'
    ]
  },
  'pramuka': {
    subtitle: 'Membentuk Karakter Mandiri & Disiplin',
    icon: Tent,
    features: [
      'Latihan Rutin Mingguan',
      'Perkemahan Khutbatul Arsy (Perkasha)',
      'Lomba Perkemahan Penggalang & Penegak (LP3)',
      'Penjelajahan Alam & Outbound',
      'Keterampilan Sandi, Tali-temali, & P3K'
    ]
  },
  'opph': {
    subtitle: 'Laboratorium Kepemimpinan Santri',
    icon: Users,
    features: [
      'Manajemen Keuangan & Koperasi Santri',
      'Pengawasan Disiplin Bahasa & Ibadah',
      'Penyelenggaraan Event (Muhadharah, Class Meeting)',
      'Bagian Keamanan & Kebersihan',
      'Pengembangan Skill Problem Solving & Resolusi Konflik'
    ]
  }
}

const currentProgram = computed(() => {
  const st = staticData[props.slug] || {}
  const db = dbProgram.value

  if (db) {
    return {
      title: db.title,
      subtitle: st.subtitle || db.category || '',
      icon: st.icon || GraduationCap,
      desc: db.description,
      // Use real uploaded image; fallback to colored placeholder
      image: db.imageUrl || `https://placehold.co/800x500/0d2535/F7C04A?text=${encodeURIComponent(db.title)}`,
      features: st.features || []
    }
  }

  // No DB match - show not found
  return {
    title: 'Program Tidak Ditemukan',
    subtitle: 'Halaman yang Anda cari tidak tersedia',
    icon: Heart,
    desc: 'Mohon maaf, program yang Anda cari mungkin telah dipindahkan atau belum tersedia. Silakan kembali ke halaman utama Program.',
    image: `https://placehold.co/800x500/0d2535/F7C04A?text=Not+Found`,
    features: []
  }
})
</script>

<template>
  <Head :title="`${currentProgram.title} | Pondok Modern Al-Hikmah`" />
  
  <main class="min-h-screen pt-24 pb-20">
    <!-- Header Banner -->
    <section class="relative py-20 mb-16 overflow-hidden">
      <div class="absolute inset-0 bg-[#081a24] -z-20"></div>
      <div class="absolute inset-0 bg-gradient-to-br from-secondary/10 to-transparent -z-10"></div>
      <div class="container-custom relative z-10">
        <!-- Back Button -->
        <router-link to="/program" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-full text-white/80 hover:text-white transition-all mb-8 w-fit backdrop-blur-sm group" data-aos="fade-right">
          <ArrowLeft :size="20" class="group-hover:-translate-x-1 transition-transform" />
          <span class="font-medium text-sm tracking-wide">Semua Program</span>
        </router-link>
        
        <div class="text-center">
          <div class="w-20 h-20 bg-secondary/10 rounded-3xl mx-auto flex items-center justify-center mb-6" data-aos="zoom-in">
            <component :is="currentProgram.icon" class="text-secondary" :size="40" />
          </div>
          <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6" data-aos="fade-up">{{ currentProgram.title }}</h1>
          <p class="text-xl text-secondary font-medium max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            {{ currentProgram.subtitle }}
          </p>
        </div>
      </div>
    </section>

    <!-- Detail Content -->
    <section class="container-custom mb-20">
      <div class="glassmorphism rounded-[40px] shadow-2xl p-8 md:p-12 border border-white/10 overflow-hidden relative">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <!-- Text -->
          <div class="space-y-8" data-aos="fade-right">
            <div class="text-white/80 text-lg leading-relaxed text-justify">
              <p>{{ currentProgram.desc }}</p>
            </div>
            
            <div v-if="currentProgram.features.length > 0">
              <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <Bookmark class="text-secondary" :size="24" />
                Fokus Kegiatan & Fitur
              </h3>
              <ul class="space-y-4">
                <li v-for="(feat, idx) in currentProgram.features" :key="idx" class="flex items-start gap-4 p-4 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition-colors">
                  <div class="w-8 h-8 rounded-full bg-secondary/20 flex items-center justify-center shrink-0">
                    <Star class="text-secondary" :size="16" />
                  </div>
                  <span class="text-white/90 pt-1 font-medium">{{ feat }}</span>
                </li>
              </ul>
            </div>
          </div>

          <!-- Image -->
          <div class="relative" data-aos="fade-left">
            <div class="absolute -inset-4 bg-gradient-to-tr from-secondary/20 to-transparent rounded-[40px] -z-10 blur-xl"></div>
            <img 
              :src="currentProgram.image" 
              :alt="currentProgram.title" 
              class="w-full h-auto rounded-3xl shadow-2xl object-cover aspect-video border border-white/10"
            />
          </div>
        </div>
      </div>
    </section>
  </main>
</template>
