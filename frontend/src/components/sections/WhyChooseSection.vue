<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import SectionHeading from '../ui/SectionHeading.vue'
import { BookOpen, BookMarked, Building, Users, Moon, Trophy } from 'lucide-vue-next'

const { t, tm } = useI18n()

// Base icon mapping for features
const featureIcons = [BookOpen, BookMarked, Building, Users, Moon, Trophy]

const features = computed(() => {
  const items = tm('why.items')
  return items.map((item, index) => ({
    title: item.title,
    desc: item.desc,
    icon: featureIcons[index]
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

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div 
          v-for="(feature, index) in features" 
          :key="index"
          class="glassmorphism p-10 rounded-3xl transition-all duration-300 hover:bg-white/15 hover:-translate-y-2 group"
          data-aos="fade-up"
          :data-aos-delay="index * 100"
        >
          <div class="w-16 h-16 bg-secondary rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-secondary/20 transition-transform duration-500 group-hover:rotate-12">
            <component :is="feature.icon" :size="32" class="text-surface-dark" />
          </div>
          <h4 class="text-2xl font-bold text-white mb-4">{{ feature.title }}</h4>
          <p class="text-white/60 leading-relaxed text-lg">
            {{ feature.desc }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>
