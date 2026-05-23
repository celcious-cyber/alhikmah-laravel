<script setup>
import TheNavbar from './TheNavbar.vue'
import TheFooter from './TheFooter.vue'
</script>

<template>
  <div class="min-h-screen bg-[#081a24] text-white selection:bg-secondary selection:text-primary overflow-x-hidden">


    <div class="relative z-10 flex flex-col min-h-screen">
      <TheNavbar />
      <main class="flex-grow">
        <slot />
      </main>
      <TheFooter />
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
