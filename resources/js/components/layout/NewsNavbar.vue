<script setup>
import { ref, onMounted, computed } from 'vue'
import { ArrowLeft, Search, Menu, X } from 'lucide-vue-next'
import axios from 'axios'

const isScrolled = ref(false)
const isMobileMenuOpen = ref(false)
const categories = ref([])

const fetchCategories = async () => {
  try {
    const API_URL = import.meta.env.VITE_API_URL || ''
    const res = await axios.get(`${API_URL}/api/categories`)
    categories.value = res.data
  } catch (err) {
    console.error('Failed to fetch categories', err)
  }
}

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
  fetchCategories()
})

const todayDate = computed(() => {
  return new Date().toLocaleDateString('id-ID', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
})

</script>

<template>
  <nav class="w-full z-[60] bg-[#FDFDFD] text-slate-900">
    <!-- Top Bar -->
    <div class="border-b border-slate-200 text-xs font-medium text-slate-500 tracking-wider">
      <div class="container-custom flex justify-between items-center py-2">
        <div class="hidden md:block">{{ todayDate }}</div>
        
        <!-- Mobile Date -->
        <div class="md:hidden text-center w-full">
          <div class="font-medium">{{ todayDate }}</div>
        </div>
        
        <router-link to="/" class="hidden md:flex items-center gap-2 hover:text-slate-900 transition-colors uppercase">
          <ArrowLeft :size="14" />
          Beranda Utama
        </router-link>
      </div>
    </div>

    <!-- Main Header -->
    <div class="container-custom py-6 md:py-8 flex items-center justify-between">
      <!-- Mobile Menu Button -->
      <div class="flex items-center md:w-1/3">
        <button class="md:hidden hover:text-primary transition-colors" @click="isMobileMenuOpen = true">
          <Menu :size="28" />
        </button>
      </div>

      <!-- Title -->
      <div class="flex-grow md:w-1/3 text-center">
        <router-link to="/berita" class="inline-block">
          <h1 class="text-3xl md:text-5xl lg:text-6xl font-black uppercase tracking-tighter font-serif hover:text-primary transition-colors leading-none">
            Khobar<br class="md:hidden" /> Al-Hikmah
          </h1>
        </router-link>
      </div>

      <!-- Search & Subscribe (Placeholder) -->
      <div class="hidden md:flex items-center justify-end gap-6 md:w-1/3">
        <button class="hover:text-primary transition-colors">
          <Search :size="22" />
        </button>
      </div>
    </div>

    <!-- Categories Nav (Sticky) -->
    <div 
      class="border-y border-slate-200 transition-all duration-300"
      :class="isScrolled ? 'fixed top-0 left-0 w-full bg-[#FDFDFD]/95 backdrop-blur-md shadow-xl' : 'relative bg-transparent'"
    >
      <div class="container-custom">
        <ul class="hidden md:flex justify-center items-center gap-8 py-4">
          <li v-for="cat in categories" :key="cat.slug">
            <a 
              href="#" 
              class="text-sm font-bold uppercase tracking-widest text-slate-600 hover:text-primary transition-colors"
            >
              {{ cat.name }}
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div v-if="isMobileMenuOpen" class="fixed inset-0 bg-slate-900/80 z-[70] backdrop-blur-sm md:hidden" @click="isMobileMenuOpen = false"></div>
    
    <!-- Mobile Menu Sidebar -->
    <div 
      class="fixed top-0 left-0 h-full w-72 bg-[#FDFDFD] text-slate-900 shadow-2xl z-[80] transform transition-transform duration-300 md:hidden flex flex-col"
      :class="isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <span class="font-serif font-black text-xl tracking-tight">KHOBAR AL-HIKMAH</span>
        <button @click="isMobileMenuOpen = false" class="hover:text-primary transition-colors">
          <X :size="24" />
        </button>
      </div>
      <div class="p-6 flex-grow overflow-y-auto">
        <div class="relative w-full mb-8">
          <input 
            type="text" 
            placeholder="Cari berita..."
            class="w-full bg-slate-100 text-slate-900 pl-10 pr-4 py-2.5 rounded border border-slate-200 outline-none placeholder:text-slate-400"
          />
          <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" :size="18" />
        </div>

        <ul class="flex flex-col gap-6">
          <li v-for="cat in categories" :key="cat.slug + '-mobile'">
            <a href="#" class="text-lg font-bold uppercase tracking-wider text-slate-700 hover:text-primary">
              {{ cat.name }}
            </a>
          </li>
        </ul>
      </div>
      <div class="p-6 border-t border-slate-200">
        <router-link to="/" class="flex items-center justify-center gap-2 w-full py-3 bg-primary text-white font-bold rounded-lg uppercase tracking-wider" @click="isMobileMenuOpen = false">
          <ArrowLeft :size="18" /> Beranda Utama
        </router-link>
      </div>
    </div>
  </nav>
</template>

<style scoped>
/* Adds classic newspaper aesthetic details */
.font-serif {
  font-family: 'Playfair Display', 'Merriweather', 'Georgia', serif;
}
</style>
