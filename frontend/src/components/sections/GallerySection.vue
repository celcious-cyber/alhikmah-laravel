<script setup>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Navigation, Pagination } from 'swiper/modules'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import SectionHeading from '../ui/SectionHeading.vue'
import BaseButton from '../ui/BaseButton.vue'

const { t } = useI18n()

const prev = ref(null)
const next = ref(null)

const images = [
  { id: 1, category: 'Kegiatan', caption: 'Pelajaran Kitab Kuning', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Kegiatan+1' },
  { id: 2, category: 'Prestasi', caption: 'Juara MTQ Nasional', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Prestasi+1' },
  { id: 3, category: 'Kegiatan', caption: 'Ekstrakurikuler Memanah', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Kegiatan+2' },
  { id: 4, category: 'Wisuda', caption: 'Haflah Akhirussanah 2025', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Wisuda+1' },
  { id: 5, category: 'Kegiatan', caption: 'Praktik Laboratorium IPA', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Kegiatan+3' },
  { id: 6, category: 'Prestasi', caption: 'Lomba Pidato Bahasa Arab', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Prestasi+2' },
  { id: 7, category: 'Wisuda', caption: 'Prosesi Wisuda Tahfidz', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Wisuda+2' },
  { id: 8, category: 'Kegiatan', caption: 'Shalat Berjamaah', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Kegiatan+4' },
]
</script>

<template>
  <section id="galeri" class="section-padding bg-transparent overflow-hidden">
    <div class="container-custom">
      <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 gap-6">
        <SectionHeading 
          :title="$t('gallery.title')" 
          :subtitle="$t('gallery.subtitle')"
          class="!mb-0 !text-center md:!text-left"
        />
        
        <div class="flex items-center gap-4">
          <!-- Navigation -->
          <div class="hidden md:flex gap-2 mr-4">
            <button ref="prev" class="p-3 glassmorphism rounded-xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 disabled:opacity-20">
              <ChevronLeft :size="20" />
            </button>
            <button ref="next" class="p-3 glassmorphism rounded-xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 disabled:opacity-20">
              <ChevronRight :size="20" />
            </button>
          </div>

          <router-link to="/gallery">
            <BaseButton variant="primary" size="md" class="!bg-secondary !text-primary px-8 py-3 !rounded-2xl font-bold">
              {{ $t('gallery.explore') }}
            </BaseButton>
          </router-link>
        </div>
      </div>

      <!-- Swiper Carousel -->
      <div data-aos="fade-up">
        <Swiper 
          :modules="[Autoplay, Navigation, Pagination]" 
          :slides-per-view="1.5"
          :space-between="16"
          :navigation="{ prevEl: prev, nextEl: next }"
          :pagination="{ clickable: true }"
          :autoplay="{ delay: 5000 }"
          :lazy="true"
          :breakpoints="{
            640: { slidesPerView: 2.2, spaceBetween: 24 },
            1024: { slidesPerView: 3.2, spaceBetween: 30 },
            1280: { slidesPerView: 4.2, spaceBetween: 40 }
          }"
          class="!pb-16"
        >
          <SwiperSlide v-for="img in images" :key="img.id">
            <div class="relative group aspect-[3/4] overflow-hidden rounded-2xl md:rounded-[32px] shadow-xl">
              <img 
                :src="img.image" 
                :alt="img.caption"
                loading="lazy"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
              />
              
              <!-- Hover Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-8 backdrop-blur-[2px]">
                <span class="px-4 py-1 bg-secondary text-primary w-fit rounded-full text-[10px] font-extrabold uppercase tracking-wider mb-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                  {{ img.category }}
                </span>
                <h5 class="text-white font-bold text-xl transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 delay-75 leading-tight">
                  {{ img.caption }}
                </h5>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </div>
  </section>
</template>

<style scoped>
:deep(.swiper-pagination-bullet) {
  background: white;
  opacity: 0.2;
}
:deep(.swiper-pagination-bullet-active) {
  background: var(--color-secondary, #F7C04A);
  opacity: 1;
}
</style>

