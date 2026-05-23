<script setup>
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import SectionHeading from '../components/ui/SectionHeading.vue'
import { ArrowLeft, BookOpen, GraduationCap, Library, ArrowRight, Award, Users, CalendarDays } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const curricula = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/curricula`)
    curricula.value = res.data
  } catch {
    // fallback static
    curricula.value = [
      { type: 'kmi', name: "Kulliyatul Mu'allimin Al-Islamiyah (KMI)", tagline: "Mencetak Pemimpin Umat", description: "Kurikulum pondok pesantren modern yang mengintegrasikan ilmu agama dan umum secara seimbang." },
      { type: 'smp', name: 'SMP Al-Hikmah', tagline: 'Pendidikan Nasional Berwawasan Islam', description: "Mengacu pada Kurikulum Nasional diperkaya muatan lokal kepesantrenan." },
      { type: 'ma', name: 'Madrasah Aliyah (MA) Al-Hikmah', tagline: 'Mempersiapkan Generasi Unggul', description: "Kurikulum Kemenag dipadukan dengan KMI untuk mempersiapkan santri ke perguruan tinggi." },
    ]
  } finally {
    loading.value = false
  }
})

const typeConfig = {
  kmi: { icon: BookOpen, color: 'from-amber-500/20 to-transparent', badge: 'bg-amber-500/20 text-amber-300', label: 'KMI' },
  smp: { icon: Library, color: 'from-blue-500/20 to-transparent', badge: 'bg-blue-500/20 text-blue-300', label: 'SMP' },
  ma:  { icon: GraduationCap, color: 'from-green-500/20 to-transparent', badge: 'bg-green-500/20 text-green-300', label: 'MA' },
}
</script>

<template>
  <Head title="Kurikulum Pendidikan | Pondok Modern Al-Hikmah" />
  
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
          <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6" data-aos="fade-up">Kurikulum Pendidikan</h1>
          <p class="text-xl text-white/70 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Sistem pendidikan terpadu yang memadukan Kurikulum Nasional, Kementerian Agama, dan Kurikulum Pondok Modern (KMI) — mencetak generasi yang unggul di bidang ilmu agama dan dunia.
          </p>
        </div>
      </div>
    </section>

    <!-- Loading -->
    <div v-if="loading" class="flex justify-center py-20">
      <div class="animate-spin rounded-full h-12 w-12 border-4 border-secondary border-t-transparent"></div>
    </div>

    <!-- Cards Grid -->
    <section v-else class="container-custom">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <router-link
          v-for="(item, index) in curricula"
          :key="item.type"
          :to="`/kurikulum/${item.type}`"
          class="glassmorphism rounded-3xl overflow-hidden border border-white/10 hover:border-secondary/50 transition-all duration-500 hover:-translate-y-3 group flex flex-col h-full shadow-lg hover:shadow-2xl hover:shadow-secondary/10"
          data-aos="fade-up"
          :data-aos-delay="index * 150"
        >
          <!-- Card Top Gradient -->
          <div class="relative h-48 flex items-center justify-center overflow-hidden"
            :class="`bg-gradient-to-br ${typeConfig[item.type]?.color || 'from-secondary/10 to-transparent'}`"
          >
            <div
              v-if="item.thumbnail"
              class="absolute inset-0"
              :style="`background-image: url('${item.thumbnail}'); background-size: cover; background-position: center; opacity: 0.4;`"
            ></div>
            <div class="relative z-10 flex flex-col items-center gap-3">
              <div class="w-20 h-20 rounded-3xl bg-white/10 backdrop-blur flex items-center justify-center border border-white/20 group-hover:scale-110 transition-transform duration-500 p-3">
                <img :src="`/assets/images/${item.type.toUpperCase()}.png`" :alt="`Logo ${item.type.toUpperCase()}`" class="w-full h-full object-contain drop-shadow-md" />
              </div>
              <span :class="`px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest ${typeConfig[item.type]?.badge || 'bg-secondary/20 text-secondary'}`">
                {{ typeConfig[item.type]?.label || item.type.toUpperCase() }}
              </span>
            </div>
          </div>

          <!-- Card Content -->
          <div class="p-8 flex flex-col flex-grow bg-white/5">
            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-secondary transition-colors leading-snug">
              {{ item.name }}
            </h3>
            <p v-if="item.tagline" class="text-secondary text-sm font-medium mb-4">{{ item.tagline }}</p>
            <p class="text-white/65 leading-relaxed text-sm mb-6 flex-grow text-justify">{{ item.description }}</p>

            <!-- Stats mini -->
            <div class="flex gap-4 mb-6 text-xs text-white/50">
              <span v-if="item.year_established" class="flex items-center gap-1">
                <CalendarDays :size="13" /> {{ item.year_established }}
              </span>
              <span v-if="item.total_students" class="flex items-center gap-1">
                <Users :size="13" /> {{ item.total_students }}+ santri
              </span>
              <span v-if="item.accreditation" class="flex items-center gap-1">
                <Award :size="13" /> Akreditasi {{ item.accreditation }}
              </span>
            </div>

            <!-- CTA -->
            <div class="pt-5 border-t border-white/10 flex items-center gap-2 text-secondary font-semibold text-sm group-hover:gap-4 transition-all">
              Lihat Detail Kurikulum
              <ArrowRight :size="16" class="group-hover:translate-x-1 transition-transform" />
            </div>
          </div>
        </router-link>
      </div>
    </section>
  </main>
</template>
