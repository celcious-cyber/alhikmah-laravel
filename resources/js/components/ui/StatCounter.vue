<script setup>
import { ref, onMounted } from 'vue'
import * as icons from 'lucide-vue-next'

const props = defineProps({
  endValue: {
    type: Number,
    required: true
  },
  suffix: {
    type: String,
    default: '+'
  },
  label: {
    type: String,
    required: true
  },
  icon: {
    type: String,
    required: true
  }
})

const count = ref(0)
const counterRef = ref(null)
const iconComponent = icons[props.icon]

const animateValue = (start, end, duration) => {
  let startTimestamp = null
  const step = (timestamp) => {
    if (!startTimestamp) startTimestamp = timestamp
    const progress = Math.min((timestamp - startTimestamp) / duration, 1)
    count.value = Math.floor(progress * (end - start) + start)
    if (progress < 1) {
      window.requestAnimationFrame(step)
    }
  }
  window.requestAnimationFrame(step)
}

onMounted(() => {
  const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
      animateValue(0, props.endValue, 2000)
      observer.disconnect()
    }
  }, { threshold: 0.5 })

  if (counterRef.value) {
    observer.observe(counterRef.value)
  }
})
</script>

<template>
  <div ref="counterRef" class="flex flex-col items-center p-3 sm:p-6 space-y-2 sm:space-y-3" data-aos="zoom-in">
    <div class="p-2 sm:p-3 bg-secondary/10 rounded-xl sm:rounded-2xl text-secondary">
      <component :is="iconComponent" class="w-6 h-6 sm:w-8 sm:h-8" />
    </div>
    <div class="text-2xl sm:text-4xl font-extrabold text-secondary">
      {{ count }}{{ suffix }}
    </div>
    <div class="text-xs sm:text-base text-white/70 font-medium text-center leading-tight">
      {{ label }}
    </div>
  </div>
</template>
