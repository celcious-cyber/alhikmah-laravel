<script setup>
import { onMounted, ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import TheNavbar from './components/layout/TheNavbar.vue'
import TheFooter from './components/layout/TheFooter.vue'

const route = useRoute()
const isAdminPage = computed(() => route.path.startsWith('/admin'))

gsap.registerPlugin(ScrollTrigger)

const orb1 = ref(null)
const orb2 = ref(null)
const orb3 = ref(null)

onMounted(() => {
  // Animate Orbs based on Scroll - "Forward/Backward" effect
  gsap.to(orb1.value, {
    scale: 1.8,
    y: 500,
    x: 200,
    opacity: 0.3,
    filter: "blur(180px)",
    scrollTrigger: {
      trigger: "body",
      start: "top top",
      end: "bottom bottom",
      scrub: 1
    }
  })

  gsap.to(orb2.value, {
    scale: 0.5,
    y: -600,
    x: -200,
    opacity: 0.05,
    filter: "blur(80px)",
    scrollTrigger: {
      trigger: "body",
      start: "top top",
      end: "bottom bottom",
      scrub: 1.5
    }
  })

  gsap.to(orb3.value, {
    scale: 2.5,
    y: -200,
    opacity: 0.2,
    scrollTrigger: {
      trigger: "body",
      start: "top top",
      end: "bottom bottom",
      scrub: 0.8
    }
  })
})
</script>

<template>
  <div class="min-h-screen bg-[#081a24] text-white selection:bg-secondary selection:text-primary overflow-x-hidden">
    <!-- Global Background Layers -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0" style="perspective: 1000px;">
      <!-- Grid Pattern -->
      <div 
        class="absolute inset-0 opacity-[0.08]" 
        style="background-image: linear-gradient(rgba(255,255,255,0.2) 1.5px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.2) 1.5px, transparent 1px); background-size: 50px 50px;"
      ></div>

      <!-- Vignette Effect -->
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_20%,rgba(8,26,36,0.7)_100%)]"></div>
      
      <!-- Animated Floating Glow Orbs (Purely Scroll Reactive) -->
      <div ref="orb1" class="absolute top-[10%] left-[-10%] w-[800px] h-[800px] bg-primary/15 rounded-full blur-[140px]"></div>
      <div ref="orb2" class="absolute bottom-[-10%] right-[-5%] w-[700px] h-[700px] bg-secondary/10 rounded-full blur-[120px]"></div>
      <div ref="orb3" class="absolute top-[30%] right-[-10%] w-[500px] h-[500px] bg-secondary-dark/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative z-10">
      <TheNavbar v-if="!isAdminPage" />
      <router-view />
      <TheFooter v-if="!isAdminPage" />
    </div>
  </div>
</template>

<style>
/* Global Background Drift Animations */
@keyframes drift {
  0%, 100% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(40px, -40px) scale(1.1); }
}

@keyframes drift-slow {
  0%, 100% { transform: translate(0, 0) scale(1.1); }
  50% { transform: translate(-50px, 30px) scale(0.9); }
}

@keyframes drift-reverse {
  0%, 100% { transform: translate(0, 0) rotate(0deg); }
  50% { transform: translate(-30px, -50px) rotate(15deg); }
}

.animate-drift { animation: drift 20s ease-in-out infinite; }
.animate-drift-slow { animation: drift-slow 25s ease-in-out infinite; }
.animate-drift-reverse { animation: drift-reverse 22s ease-in-out infinite; }

/* Selection color */
::selection {
  background: #F7C04A; /* secondary */
  color: #154D6E; /* primary */
}
</style>
