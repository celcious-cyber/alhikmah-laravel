<script setup>
import { useI18n } from 'vue-i18n'
import BaseButton from '../ui/BaseButton.vue'
import { Download } from 'lucide-vue-next'

const { t, tm } = useI18n()
</script>

<template>
  <section id="cta" class="py-24 relative overflow-hidden">
    <!-- Premium Background -->
    <div class="absolute inset-0 glassmorphism opacity-50"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent"></div>

    <div class="container-custom relative z-10 text-center text-white">
      <div class="max-w-3xl mx-auto space-y-8" data-aos="zoom-in">
        <h2 class="text-4xl md:text-5xl font-extrabold leading-tight">
          {{ t('cta.title') }} <span class="text-secondary">{{ t('cta.title_hl') }}</span>
        </h2>
        <p class="text-xl text-white/70 leading-relaxed">
          {{ t('cta.subtitle') }}
        </p>
        
        <div class="flex flex-wrap justify-center gap-4 pt-4">
          <router-link to="/spsb26">
            <BaseButton variant="primary" size="lg">
              {{ t('cta.register') }}
            </BaseButton>
          </router-link>
          <router-link to="/pbs26">
            <BaseButton variant="outline" size="lg" class="!border-white !text-white hover:!bg-white hover:!text-primary">
              {{ t('cta.scholarship') }}
            </BaseButton>
          </router-link>
          <a href="https://drive.google.com/drive/folders/118phJrfBL8MdO5vo1M8vKZzZY6LX05h6?usp=drive_link" target="_blank">
            <BaseButton variant="outline" size="lg" class="!border-white/30 !text-white hover:!bg-white/10 hover:!border-white/50 flex items-center gap-2">
              <Download :size="18" /> Download Brosur
            </BaseButton>
          </a>
        </div>
        
        <div class="pt-8 flex flex-wrap justify-center gap-8 text-sm text-white/50">
          <div v-for="(tag, index) in tm('cta.tags')" :key="index" class="flex items-center">
            <span class="w-2 h-2 bg-secondary rounded-full mr-2"></span>
            {{ tag }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
