<script setup>
import NewsNavbar from './NewsNavbar.vue'
import TheFooter from './TheFooter.vue'
</script>

<template>
  <div class="min-h-screen bg-[#FDFDFD] text-slate-900 selection:bg-primary selection:text-white overflow-x-hidden font-sans">
    <div class="relative z-10 flex flex-col min-h-screen">
      <NewsNavbar />
      <!-- pt-10 to account for NewsNavbar space -->
      <main class="flex-grow pt-4 md:pt-8">
        <slot />
      </main>
      <TheFooter class="mt-20 border-t border-slate-200 pt-10" />
    </div>
  </div>
</template>

<style>
/* Selection color */
::selection {
  background: #154D6E; /* primary */
  color: #FFFFFF;
}

/* Ensure serif is imported globally if needed, fallback works */
.font-serif {
  font-family: 'Playfair Display', 'Merriweather', 'Georgia', serif;
}
</style>
