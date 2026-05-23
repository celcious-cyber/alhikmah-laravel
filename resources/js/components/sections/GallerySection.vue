<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
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
const API_URL = import.meta.env.VITE_API_URL || ''

const prev = ref(null)
const next = ref(null)
const images = ref([])
const loading = ref(true)

const fetchGallery = async () => {
  try {
    const res = await axios.get(`${API_URL}/api/gallery`)
    // Filter out facilities to show only activities/general in gallery section
    images.value = res.data.filter(img => img.category?.toLowerCase() !== 'fasilitas').slice(0, 10)
  } catch (err) {
    console.error('Error fetching gallery:', err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchGallery)
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

          <router-link to="/galeri">
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
            <div class="relative group aspect-[3/4] overflow-hidden rounded-2xl md:rounded-[32px] shadow-xl bg-white/5">
              <img 
                :src="img.imageUrl" 
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

