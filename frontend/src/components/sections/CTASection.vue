<script setup>
import { useI18n } from 'vue-i18n'
import BaseButton from '../ui/BaseButton.vue'

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
          <BaseButton variant="outline" size="lg" href="#" class="!border-white !text-white hover:!bg-white hover:!text-primary">
            {{ t('cta.contact') }}
          </BaseButton>
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
