<script setup>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Navigation, Pagination } from 'swiper/modules'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import SectionHeading from '../ui/SectionHeading.vue'

const { t, tm } = useI18n()

const prev = ref(null)
const next = ref(null)

const facilities = computed(() => {
  const items = tm('facilities.items')
  return [
    { name: items[0] || 'Masjid Jami\'', image: 'https://picsum.photos/seed/mosque/800/1000' },
    { name: items[1] || 'Asrama Putra', image: 'https://picsum.photos/seed/dormitory1/800/1000' },
    { name: items[2] || 'Asrama Putri', image: 'https://picsum.photos/seed/dormitory2/800/1000' },
    { name: items[3] || 'Laboratorium', image: 'https://picsum.photos/seed/lab/800/1000' },
    { name: items[4] || 'Perpustakaan', image: 'https://picsum.photos/seed/library/800/1000' },
    { name: items[5] || 'Lapangan Olahraga', image: 'https://picsum.photos/seed/sports/800/1000' },
    { name: items[6] || 'Ruang Makan', image: 'https://picsum.photos/seed/dining/800/1000' },
    { name: items[7] || 'Gedung Kesenian', image: 'https://picsum.photos/seed/art-hall/800/1000' },
  ]
})
</script>

<template>
  <section id="fasilitas" class="section-padding bg-transparent overflow-hidden">
    <div class="container-custom">
      <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 gap-6">
        <SectionHeading 
          :title="$t('facilities.title')" 
          :subtitle="$t('facilities.subtitle')"
          class="!mb-0 !text-center md:!text-left"
        />

        <!-- Navigation Buttons -->
        <div class="flex gap-4">
          <button ref="prev" class="p-4 glassmorphism rounded-2xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 shadow-lg cursor-pointer disabled:opacity-30">
            <ChevronLeft :size="24" />
          </button>
          <button ref="next" class="p-4 glassmorphism rounded-2xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 shadow-lg cursor-pointer disabled:opacity-30">
            <ChevronRight :size="24" />
          </button>
        </div>
      </div>

      <div data-aos="fade-up">
        <Swiper
          :modules="[Autoplay, Navigation, Pagination]"
          :slides-per-view="1"
          :space-between="24"
          :pagination="{ clickable: true }"
          :navigation="{
            prevEl: prev,
            nextEl: next,
          }"
          :autoplay="{ delay: 4000 }"
          :breakpoints="{
            '640': { slidesPerView: 2 },
            '1024': { slidesPerView: 3 },
            '1280': { slidesPerView: 4 }
          }"
          class="!pb-16 !overflow-visible"
        >
          <SwiperSlide v-for="(facility, index) in facilities" :key="index">
            <div class="relative group aspect-[3/4] overflow-hidden rounded-[32px] cursor-pointer shadow-xl">
              <!-- Image -->
              <img 
                :src="facility.image" 
                :alt="facility.name"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
              />
              
              <!-- Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 group-hover:from-primary/90 transition-all duration-500"></div>
              
              <!-- Label -->
              <div class="absolute bottom-0 left-0 p-8 w-full z-10">
                <h4 class="text-2xl font-bold text-white transform transition-transform duration-500 group-hover:-translate-y-2">
                  {{ facility.name }}
                </h4>
                <div class="h-1 w-0 bg-secondary transition-all duration-500 group-hover:w-16"></div>
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
