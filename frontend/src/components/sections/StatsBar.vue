<script setup>
import StatCounter from '../ui/StatCounter.vue'

const stats = [
  { value: 200, suffix: '+', label: 'Students', icon: 'Users' },
  { value: 150, suffix: '+', label: 'Staff', icon: 'UserCheck' },
  { value: 20, suffix: '+', label: 'Facilities', icon: 'Building' },
  { value: 20, suffix: '+', label: 'Programs', icon: 'BookOpen' },
  { value: 50, suffix: '+', label: 'Awards', icon: 'Trophy' },
]
</script>

<template>
  <section class="relative z-20 container-custom">
    <div 
      class="glassmorphism rounded-[40px] shadow-2xl pt-6 pb-10 md:pt-8 md:pb-14 -mt-32 md:-mt-32 grid grid-cols-2 lg:grid-cols-5 gap-6"
      data-aos="fade-up"
    >
      <div v-for="(stat, index) in stats" :key="index" class="relative">
        <StatCounter 
          :endValue="stat.value" 
          :suffix="stat.suffix" 
          :label="stat.label" 
          :icon="stat.icon" 
        />
        <!-- Vertical Divider -->
        <div 
          v-if="index < stats.length - 1" 
          class="hidden lg:block absolute top-1/2 right-0 h-16 w-px bg-white/10 -translate-y-1/2"
        ></div>
      </div>
    </div>
  </section>
</template>
