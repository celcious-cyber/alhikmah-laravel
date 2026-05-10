<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  subtitle: {
    type: String,
    default: ''
  },
  light: {
    type: Boolean,
    default: false
  }
})
</script>

<template>
  <div class="text-center space-y-4 mb-16" data-aos="fade-up">
    <h2 class="text-3xl md:text-4xl font-bold text-white">
      {{ title }}
    </h2>
    <div class="w-10 h-1 bg-secondary mx-auto rounded-full"></div>
    <p 
      v-if="subtitle"
      class="max-w-2xl mx-auto text-lg text-white/70"
    >
      {{ subtitle }}
    </p>
  </div>
</template>
