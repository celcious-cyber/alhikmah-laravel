<script setup>
import { computed, ref, onMounted } from 'vue'
import { useI18n } from 'vue-i18n'
import axios from 'axios'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Pagination } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/pagination'
import SectionHeading from '../ui/SectionHeading.vue'
import { Quote } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''

const { t, tm } = useI18n()

// Base data for avatars and names since they usually don't need translation
const testimonialBase = [
  { name: 'H. Sujarwo', avatar: 'https://i.pravatar.cc/150?u=1' },
  { name: 'Fatimah Az-Zahra', avatar: 'https://i.pravatar.cc/150?u=2' },
  { name: 'Muhammad Rifqi', avatar: 'https://i.pravatar.cc/150?u=3' }
]

const apiTestimonials = ref([])

onMounted(async () => {
  try {
    const res = await axios.get(`${API_URL}/api/testimonials`)
    if (res.data && res.data.length > 0) {
      apiTestimonials.value = res.data.map(t => ({
        name: t.name,
        role: t.role,
        text: t.text,
        avatar: t.avatar ? (t.avatar.startsWith('http') ? t.avatar : `/storage/${t.avatar}`) : `https://ui-avatars.com/api/?name=${encodeURIComponent(t.name)}&background=154D6E&color=fff`
      }))
    }
  } catch (err) {
    console.error('Failed to fetch testimonials', err)
  }
})

const testimonials = computed(() => {
  if (apiTestimonials.value.length > 0) {
    return apiTestimonials.value
  }

  const roles = tm('testimonial.roles')
  const texts = tm('testimonial.texts')
  
  return testimonialBase.map((base, index) => ({
    ...base,
    role: roles[index] || '',
    text: texts[index] || ''
  }))
})
</script>

<template>
  <section id="testimonial" class="section-padding bg-transparent relative overflow-hidden">
    <div class="container-custom relative z-10">
      <SectionHeading 
        :title="$t('testimonial.title')" 
        :subtitle="$t('testimonial.subtitle')"
        light
      />

      <div data-aos="fade-up" data-aos-delay="200" class="max-w-4xl mx-auto">
        <Swiper
          :modules="[Autoplay, Pagination]"
          :slides-per-view="1"
          :loop="true"
          :autoplay="{ delay: 5000 }"
          :pagination="{ clickable: true }"
          class="pb-16"
        >
          <SwiperSlide v-for="(testi, index) in testimonials" :key="index">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 p-12 rounded-[40px] text-center relative overflow-hidden group">
              <!-- Decorative Large Quote Icon -->
              <Quote class="absolute -top-4 -left-4 text-secondary opacity-10 group-hover:opacity-20 transition-opacity duration-500" :size="200" />
              
              <div class="relative z-10 space-y-8">
                <p class="text-lg md:text-2xl text-white font-medium italic leading-relaxed">
                  "{{ testi.text }}"
                </p>
                
                <div class="flex flex-col items-center space-y-4">
                  <img 
                    :src="testi.avatar" 
                    :alt="testi.name"
                    class="w-20 h-20 rounded-full border-4 border-secondary/30 shadow-lg object-cover"
                  />
                  <div>
                    <h5 class="text-xl font-bold text-white">{{ testi.name }}</h5>
                    <p class="text-secondary font-medium">{{ testi.role }}</p>
                  </div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </div>
  </section>
</template>

<!-- Style moved to style.css to avoid build errors -->
