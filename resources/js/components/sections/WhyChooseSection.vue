<script setup>
import { ref, computed, onMounted } from 'vue'
import { useI18n } from 'vue-i18n'
import axios from 'axios'
import SectionHeading from '../ui/SectionHeading.vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Pagination } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/pagination'
import * as LucideIcons from 'lucide-vue-next'

const { t, locale } = useI18n()
const API_URL = import.meta.env.VITE_API_URL || ''

const dynamicFeatures = ref([])

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/features`)
    dynamicFeatures.value = res.data
  } catch (err) {
    console.error('Failed to fetch features:', err)
  }
})

const features = computed(() => {
  return dynamicFeatures.value.map(item => ({
    title: locale.value === 'en' && item.title_en ? item.title_en : item.title_id,
    desc: locale.value === 'en' && item.desc_en ? item.desc_en : item.desc_id,
    icon: LucideIcons[item.icon] || LucideIcons.BookOpen
  }))
})
</script>

<template>
  <section id="why-choose" class="section-padding bg-transparent relative overflow-hidden">
    <!-- Decorative glow background -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary/5 rounded-full blur-[120px]"></div>

    <div class="container-custom relative z-10">
      <SectionHeading 
        :title="$t('why.title')" 
        :subtitle="$t('why.subtitle')"
        light
      />

      <div data-aos="fade-up">
        <Swiper 
          :modules="[Pagination]" 
          :slides-per-view="1.2"
          :space-between="16"
          :pagination="{ clickable: true }"
          :breakpoints="{
            640: { slidesPerView: 2.2, spaceBetween: 24 },
            1024: { slidesPerView: 3, spaceBetween: 30 }
          }"
          class="!pb-16"
        >
          <SwiperSlide v-for="(feature, index) in features" :key="index">
            <div class="glassmorphism p-8 md:p-10 rounded-3xl transition-all duration-300 hover:bg-white/15 hover:-translate-y-2 group h-full">
              <div class="w-16 h-16 bg-secondary rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-secondary/20 transition-transform duration-500 group-hover:rotate-12">
                <component :is="feature.icon" :size="32" class="text-surface-dark" />
              </div>
              <h4 class="text-2xl font-bold text-white mb-4">{{ feature.title }}</h4>
              <p class="text-white/60 leading-relaxed text-lg">
                {{ feature.desc }}
              </p>
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
