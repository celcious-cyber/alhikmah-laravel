<script setup>
import SectionHeading from '../ui/SectionHeading.vue'
import { Clock, Sun, Moon, Coffee, BookOpen, Users } from 'lucide-vue-next'

const activities = [
  {
    time: '04:00 - 05:00',
    title: 'Bangun & Tahajud',
    desc: 'Memulai hari dengan ibadah qiyamul lail dan persiapan shalat subuh.',
    icon: Moon,
    color: 'text-blue-400'
  },
  {
    time: '05:00 - 06:30',
    title: 'Halaqah Al-Quran',
    desc: 'Zikir pagi dan setoran hafalan Al-Quran (Tahfidz) bersama pembimbing.',
    icon: BookOpen,
    color: 'text-emerald-400'
  },
  {
    time: '07:15 - 12:45',
    title: 'KMI (Sekolah Formal)',
    desc: 'Kegiatan belajar mengajar kurikulum KMI dan Nasional di kelas.',
    icon: Users,
    color: 'text-amber-400'
  },
  {
    time: '13:00 - 15:00',
    title: 'Makan Siang & Istirahat',
    desc: 'Waktu jeda untuk makan siang, istirahat sejenak, dan shalat zuhur.',
    icon: Coffee,
    color: 'text-orange-400'
  },
  {
    time: '15:30 - 17:30',
    title: 'Ekstrakurikuler',
    desc: 'Olahraga, kursus bahasa, pramuka, dan berbagai minat bakat santri.',
    icon: Sun,
    color: 'text-rose-400'
  },
  {
    time: '18:30 - 21:00',
    title: 'Kajian & Belajar',
    desc: 'Kajian kitab turats pasca Maghrib dan belajar malam terbimbing.',
    icon: Clock,
    color: 'text-indigo-400'
  }
]
</script>

<template>
  <section id="activities" class="section-padding bg-transparent">
    <div class="container-custom">
      <SectionHeading 
        title="Agenda Harian Santri" 
        subtitle="Kedisiplinan adalah kunci kesuksesan. Inilah gambaran rutinitas produktif santri Al-Hikmah setiap harinya."
      />

      <div class="relative max-w-4xl mx-auto mt-16">
        <!-- Timeline Line -->
        <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-secondary/0 via-secondary/30 to-secondary/0 hidden md:block"></div>

        <div class="space-y-12">
          <div 
            v-for="(item, index) in activities" 
            :key="index"
            class="relative flex flex-col md:flex-row items-center group"
            :class="index % 2 === 0 ? 'md:flex-row-reverse' : ''"
            data-aos="fade-up"
            :data-aos-delay="index * 100"
          >
            <!-- Content -->
            <div class="w-full md:w-1/2 px-8 md:px-12">
              <div class="glassmorphism p-8 rounded-[32px] border-secondary/10 hover:border-secondary/40 transition-all duration-500 hover:-translate-y-2 group/card shadow-xl">
                <div class="flex items-center gap-4 mb-4" :class="index % 2 === 0 ? 'md:flex-row-reverse' : ''">
                  <div class="p-3 bg-secondary/10 rounded-2xl group-hover/card:bg-secondary/20 transition-colors">
                    <component :is="item.icon" :size="24" class="text-secondary" />
                  </div>
                  <span class="text-secondary font-bold tracking-wider">{{ item.time }}</span>
                </div>
                <h4 class="text-2xl font-bold text-white mb-3" :class="index % 2 === 0 ? 'md:text-right' : ''">{{ item.title }}</h4>
                <p class="text-white/70 leading-relaxed" :class="index % 2 === 0 ? 'md:text-right text-justify md:text-justify-reverse' : 'text-justify'">
                  {{ item.desc }}
                </p>
              </div>
            </div>

            <!-- Dot on line -->
            <div class="absolute left-4 md:left-1/2 w-4 h-4 bg-secondary rounded-full -translate-x-1/2 border-4 border-primary shadow-[0_0_15px_rgba(240,173,29,0.5)] z-10 hidden md:block group-hover:scale-150 transition-transform duration-500"></div>

            <!-- Empty space for layout balance -->
            <div class="hidden md:block md:w-1/2"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.text-justify-reverse {
  text-align-last: right;
}
</style>
