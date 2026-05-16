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
import BaseButton from '../ui/BaseButton.vue'

const { t, tm } = useI18n()

const prev = ref(null)
const next = ref(null)

const facilities = computed(() => {
  const items = tm('facilities.items')
  return [
    { name: items[0] || 'Masjid Jami\'', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Masjid' },
    { name: items[1] || 'Asrama Putra', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Asrama+Putra' },
    { name: items[2] || 'Laboratorium', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Lab+IPA' },
    { name: items[3] || 'Perpustakaan', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Perpustakaan' },
    { name: items[4] || 'Asrama Putri', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Asrama+Putri' },
    { name: items[5] || 'Lapangan Olahraga', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Lapangan' },
    { name: items[6] || 'Ruang Makan', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Ruang+Makan' },
    { name: items[7] || 'Gedung Kesenian', image: 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Gedung+Kesenian' },
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

        <!-- Navigation & Button -->
        <div class="flex items-center gap-4">
          <div class="hidden md:flex gap-2 mr-4">
            <button ref="prev" class="p-3 glassmorphism rounded-xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 disabled:opacity-20">
              <ChevronLeft :size="20" />
            </button>
            <button ref="next" class="p-3 glassmorphism rounded-xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 disabled:opacity-20">
              <ChevronRight :size="20" />
            </button>
          </div>

          <router-link to="/facilities">
            <BaseButton variant="primary" size="md" class="!bg-secondary !text-primary px-8 py-3 !rounded-2xl font-bold">
              Jelajahi Semua Fasilitas
            </BaseButton>
          </router-link>
        </div>
      </div>

      <div data-aos="fade-up">
        <Swiper
          :modules="[Autoplay, Navigation, Pagination]"
          :slides-per-view="3"
          :space-between="12"
          :pagination="{ clickable: true }"
          :navigation="{
            prevEl: prev,
            nextEl: next,
          }"
          :autoplay="{ delay: 4000 }"
          :breakpoints="{
            '768': { slidesPerView: 3, spaceBetween: 24 },
            '1024': { slidesPerView: 4, spaceBetween: 24 }
          }"
          class="!pb-16"
        >
          <SwiperSlide v-for="(facility, index) in facilities" :key="index">
            <div class="relative group aspect-[3/4] overflow-hidden rounded-2xl md:rounded-[32px] shadow-xl">
              <img 
                :src="facility.image" 
                :alt="facility.name"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
              />
              
              <!-- Hover Overlay (Aligned with Gallery) -->
              <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent opacity-80 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-8 backdrop-blur-[1px]">
                <div class="h-1 w-12 bg-secondary mb-4 transform -translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500"></div>
                <h4 class="text-white font-bold text-2xl transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 leading-tight">
                  {{ facility.name }}
                </h4>
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
