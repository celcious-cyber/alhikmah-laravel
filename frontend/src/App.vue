<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import TheNavbar from './components/layout/TheNavbar.vue'
import TheFooter from './components/layout/TheFooter.vue'

const route = useRoute()
const isAdminPage = computed(() => route.path.startsWith('/admin'))
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
      
      <!-- Simplified Static/CSS Glows (Much lighter for performance) -->
      <div class="absolute top-[-10%] left-[-5%] w-[500px] h-[500px] bg-primary/10 rounded-full blur-[100px] animate-drift"></div>
      <div class="absolute bottom-[-5%] right-[-5%] w-[400px] h-[400px] bg-secondary/5 rounded-full blur-[80px] animate-drift-slow"></div>
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
