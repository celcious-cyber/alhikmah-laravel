<script setup>
import { useI18n } from 'vue-i18n'
import SectionHeading from '../ui/SectionHeading.vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Pagination } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/pagination'
import { GraduationCap, Target, BookOpen, Activity, Tent, Users, ArrowRight } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
import * as LucideIcons from 'lucide-vue-next'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const { t } = useI18n()

const dynamicPrograms = ref([])

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/programs`)
    dynamicPrograms.value = res.data.map(p => {
      // Provide a slug fallback
      const generatedSlug = p.title.toLowerCase().replace(/[^a-z0-9]+/g, '-')
      return {
        title: p.title,
        slug: p.slug || generatedSlug,
        icon: LucideIcons[p.category] || LucideIcons.GraduationCap,
        desc: p.description
      }
    })
  } catch (err) {
    console.error('Failed to fetch programs:', err)
  }
})
</script>

<template>
  <section id="program" class="section-padding bg-transparent">
    <div class="container-custom">
      <div class="text-center mb-16">
        <SectionHeading 
          title="Program Pendidikan" 
          subtitle="Jelajahi Berbagai Kegiatan Kami"
          class="!mb-0"
        />
      </div>

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
          <SwiperSlide v-for="(program, index) in dynamicPrograms" :key="program.slug">
            <router-link 
              :to="`/program/${program.slug}`"
              class="glassmorphism rounded-3xl p-8 border border-white/10 hover:border-secondary/50 hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden flex flex-col h-full shadow-lg hover:shadow-2xl hover:shadow-secondary/20 block"
            >
              <!-- Background Decoration -->
              <div class="absolute -right-8 -top-8 w-32 h-32 bg-secondary/5 rounded-full blur-2xl group-hover:bg-secondary/20 transition-colors"></div>
              
              <!-- Icon -->
              <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-6 border border-white/10 group-hover:bg-secondary/10 group-hover:border-secondary/30 transition-all duration-300 z-10">
                <component :is="program.icon" class="text-secondary group-hover:scale-110 transition-transform duration-300" :size="32" />
              </div>
              
              <!-- Content -->
              <div class="z-10 flex-grow">
                <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-secondary transition-colors">{{ program.title }}</h3>
                <p class="text-white/70 leading-relaxed text-justify mb-6">
                  {{ program.desc }}
                </p>
              </div>
              
              <!-- Action -->
              <div class="pt-6 border-t border-white/10 mt-auto flex items-center text-secondary font-semibold z-10 group-hover:text-white transition-colors">
                Lihat Detail
                <ArrowRight :size="18" class="ml-2 group-hover:translate-x-2 transition-transform duration-300" />
              </div>
            </router-link>
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
