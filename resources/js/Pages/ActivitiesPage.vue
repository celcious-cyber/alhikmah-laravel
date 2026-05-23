<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import SectionHeading from '../components/ui/SectionHeading.vue'
import { Clock, Sun, Moon, Coffee, BookOpen, Users, Calendar, Star, Flag, Map } from 'lucide-vue-next'

const activeTab = ref('Harian')
const tabs = ['Harian', 'Mingguan', 'Bulanan', 'Tahunan']

const schedules = {
  'Harian': [
    { time: '04:00 - 05:00', title: 'Bangun & Tahajud', icon: Moon },
    { time: '05:00 - 06:30', title: 'Halaqah Al-Quran', icon: BookOpen },
    { time: '07:15 - 12:45', title: 'KMI (Sekolah Formal)', icon: Users },
    { time: '13:00 - 15:00', title: 'Makan Siang & Istirahat', icon: Coffee },
    { time: '15:30 - 17:30', title: 'Ekstrakurikuler', icon: Sun },
    { time: '18:30 - 21:00', title: 'Kajian & Belajar', icon: Clock }
  ],
  'Mingguan': [
    { time: 'Kamis Sore', title: 'Latihan Pidato (Muhadharah)', icon: Users },
    { time: 'Jumat Pagi', title: 'Olahraga & Kebersihan Umum', icon: Sun },
    { time: 'Jumat Siang', title: 'Shalat Jumat Berjamaah', icon: Users },
    { time: 'Sabtu Malam', title: 'Pentas Seni & Kreasi', icon: Star }
  ],
  'Bulanan': [
    { time: 'Minggu Pertama', title: 'Lari Pagi Jarak Jauh', icon: Flag },
    { time: 'Minggu Kedua', title: 'Lomba Antar Kamar', icon: Star },
    { time: 'Minggu Ketiga', title: 'Kajian Umum & Muhasabah', icon: BookOpen },
    { time: 'Minggu Keempat', title: 'Bakti Sosial Masyarakat', icon: Users }
  ],
  'Tahunan': [
    { time: 'Muharram', title: 'Pekan Perkenalan (Khutbatul Arsy)', icon: Map },
    { time: 'Safar', title: 'Lomba Perkemahan (LP3)', icon: Flag },
    { time: 'Ramadhan', title: 'Safari Dakwah & I\'tikaf', icon: Moon },
    { time: 'Syawwal', title: 'Ujian Akhir Tahun KMI', icon: BookOpen }
  ]
}
</script>

<template>
  <div class="pt-[188px] pb-20 min-h-screen">
    <Head>
      <title>Agenda Kegiatan | Pondok Modern Al-Hikmah</title>
      <meta name="description" content="Agenda dan jadwal kegiatan santri Pondok Modern Al-Hikmah secara harian, mingguan, bulanan, dan tahunan.">
    </Head>
    <div class="container-custom">
      <SectionHeading 
        title="Agenda & Jadwal Santri" 
        subtitle="Sistem pendidikan terpadu 24 jam yang membentuk disiplin dan karakter unggul."
      />

      <!-- Tabs -->
      <div class="flex flex-wrap justify-center gap-4 mb-16" data-aos="fade-up">
        <button 
          v-for="tab in tabs" 
          :key="tab"
          @click="activeTab = tab"
          class="px-8 py-3 rounded-2xl font-bold transition-all duration-300"
          :class="activeTab === tab ? 'bg-secondary text-primary shadow-lg shadow-secondary/20' : 'bg-white/5 text-white/70 hover:bg-white/10'"
        >
          {{ tab }}
        </button>
      </div>

      <!-- Timeline Content -->
      <div class="relative max-w-4xl mx-auto">
        <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-secondary/20 hidden md:block"></div>

        <TransitionGroup name="list" tag="div" class="space-y-8">
          <div 
            v-for="(item, index) in schedules[activeTab]" 
            :key="item.title"
            class="relative flex flex-col md:flex-row items-center group"
            :class="index % 2 === 0 ? 'md:flex-row-reverse' : ''"
          >
            <div class="w-full md:w-1/2 px-4 md:px-12">
              <div class="glassmorphism p-6 rounded-[24px] border-secondary/10 hover:border-secondary/40 transition-all duration-500 hover:-translate-y-1">
                <div class="flex items-center gap-4 mb-3" :class="index % 2 === 0 ? 'md:flex-row-reverse' : ''">
                  <div class="p-2.5 bg-secondary/10 rounded-xl text-secondary">
                    <component :is="item.icon" :size="20" />
                  </div>
                  <span class="text-secondary font-bold text-sm tracking-wider">{{ item.time }}</span>
                </div>
                <h4 class="text-xl font-bold text-white mb-2" :class="index % 2 === 0 ? 'md:text-right' : ''">{{ item.title }}</h4>
              </div>
            </div>
            <div class="absolute left-4 md:left-1/2 w-3 h-3 bg-secondary rounded-full -translate-x-1/2 border-2 border-primary z-10 hidden md:block"></div>
            <div class="hidden md:block md:w-1/2"></div>
          </div>
        </TransitionGroup>
      </div>
    </div>
  </div>
</template>

<style scoped>
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateY(30px);
}
</style>
