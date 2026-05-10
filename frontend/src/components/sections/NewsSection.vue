<script setup>
import SectionHeading from '../ui/SectionHeading.vue'
import { Calendar, User, ArrowRight } from 'lucide-vue-next'

const news = [
  {
    id: 1,
    title: 'Penerimaan Santri Baru Tahun Ajaran 2024/2025 Telah Dibuka',
    date: '10 Mei 2024',
    author: 'Admin Pondok',
    category: 'Pendaftaran',
    desc: 'Al-Hikmah membuka kesempatan bagi putra-putri terbaik bangsa untuk bergabung dan menjadi kader pemimpin ummat.',
    image: 'https://picsum.photos/seed/pendaftaran/800/500'
  },
  {
    id: 2,
    title: 'Prestasi Santri: Juara 1 Pidato Bahasa Arab Tingkat Nasional',
    date: '05 Mei 2024',
    author: 'Ustadz Ahmad',
    category: 'Prestasi',
    desc: 'Kebanggaan bagi pondok, santri kami berhasil meraih prestasi gemilang di kancah nasional dalam lomba pidato.',
    image: 'https://picsum.photos/seed/prestasi/800/500'
  },
  {
    id: 3,
    title: 'Kunjungan Edukasi Santri Kelas VI ke Industri Kreatif',
    date: '01 Mei 2024',
    author: 'Panitia Tour',
    category: 'Kegiatan',
    desc: 'Membekali santri dengan wawasan kewirausahaan melalui kunjungan langsung ke pusat industri kreatif.',
    image: 'https://picsum.photos/seed/tour-kreatif/800/500'
  }
]
</script>

<template>
  <section id="news" class="section-padding bg-transparent">
    <div class="container-custom">
      <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 gap-6">
        <SectionHeading 
          :title="$t('news.title')" 
          :subtitle="$t('news.subtitle')"
          class="!mb-0 !text-center md:!text-left"
        />
        
        <router-link 
          to="/berita" 
          class="px-8 py-3 glassmorphism rounded-2xl text-secondary font-bold hover:bg-secondary hover:text-primary transition-all duration-300"
        >
          {{ $t('news.load_more') }}
        </router-link>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div 
          v-for="(item, index) in news" 
          :key="item.id"
          class="glassmorphism rounded-[32px] overflow-hidden group shadow-xl hover:-translate-y-3 transition-all duration-500"
          data-aos="fade-up"
          :data-aos-delay="index * 100"
        >
          <!-- Image -->
          <div class="relative aspect-[16/10] overflow-hidden">
            <img 
              :src="item.image" 
              :alt="item.title"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            <div class="absolute top-4 left-4">
              <span class="px-4 py-1.5 bg-secondary text-primary text-xs font-bold rounded-full shadow-lg">
                {{ item.category }}
              </span>
            </div>
          </div>

          <!-- Content -->
          <div class="p-8">
            <div class="flex items-center gap-4 text-white/50 text-xs mb-4">
              <div class="flex items-center gap-1.5">
                <Calendar :size="14" class="text-secondary" />
                <span>{{ item.date }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <User :size="14" class="text-secondary" />
                <span>{{ item.author }}</span>
              </div>
            </div>

            <h4 class="text-xl font-bold text-white mb-4 line-clamp-2 group-hover:text-secondary transition-colors duration-300">
              {{ item.title }}
            </h4>
            
            <p class="text-white/60 text-sm leading-relaxed line-clamp-3 mb-6">
              {{ item.desc }}
            </p>

            <a href="#" class="inline-flex items-center gap-2 text-secondary font-bold hover:gap-4 transition-all">
              {{ $t('news.read_more') }} <ArrowRight :size="18" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
