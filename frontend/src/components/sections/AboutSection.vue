<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import SectionHeading from '../ui/SectionHeading.vue'
import { Quote } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const settings = ref({})
const loading = ref(true)

const fetchSettings = async () => {
  try {
    const res = await axios.get(`${API_URL}/api/settings`)
    settings.value = res.data
  } catch (err) {
    console.error('Error fetching settings:', err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchSettings)
</script>

<template>
  <section id="about" class="section-padding bg-transparent">
    <div class="container-custom">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <!-- Image Side -->
        <div class="relative" data-aos="fade-right">
          <!-- Decorative Frame -->
          <div class="absolute -top-4 -left-4 w-full h-full border-2 border-secondary rounded-2xl translate-x-4 translate-y-4 -z-10"></div>
          <img 
            :src="settings.about_image || 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Pimpinan'" 
            :alt="settings.founder_name || 'Pimpinan Pondok'" 
            class="w-full h-auto rounded-2xl shadow-2xl object-cover aspect-[4/5]"
          />
          <!-- Badge overlay -->
          <div class="absolute bottom-8 right-8 glassmorphism p-6 rounded-xl shadow-xl max-w-xs">
            <Quote class="text-secondary mb-2" :size="32" />
            <p class="text-white font-medium italic text-justify">
              {{ settings.quote_text || $t('about.quote') }}
              <br />
              <span class="text-secondary text-sm font-bold not-italic mt-2 block">{{ settings.quote_source || '(Q.S. Al-Baqarah : 269)' }}</span>
            </p>
          </div>
        </div>

        <!-- Text Side -->
        <div class="space-y-8" data-aos="fade-left">
          <SectionHeading 
            :title="settings.about_title || $t('about.title')" 
            :subtitle="settings.about_subtitle || $t('about.subtitle')"
            class="!text-left !mb-8"
          />
          
          <div class="space-y-6 text-white/70 text-lg leading-relaxed text-justify">
            <p v-html="settings.about_p1 || $t('about.p1')"></p>
            <p>{{ settings.about_p2 || $t('about.p2') }}</p>
          </div>

          <div class="pt-6 border-t border-white/10">
            <h4 class="text-white font-bold text-xl">{{ settings.founder_name || 'KH. Syihabuddin Muhammad' }}</h4>
            <p class="text-secondary font-medium">{{ settings.founder_title || $t('about.founder_title') }}</p>
            <!-- Signature Placeholder -->
            <div class="mt-4 font-serif text-3xl text-white/20 italic">{{ settings.founder_name || 'Syihabuddin M.' }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
:deep(.section-heading) {
  text-align: left !important;
}
:deep(.section-heading div) {
  margin-left: 0 !important;
}
</style>
