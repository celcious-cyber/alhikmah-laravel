<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useRoute } from 'vue-router'
import { Menu, X, Search, Globe, ChevronDown, ArrowLeft } from 'lucide-vue-next'
import BaseButton from '../ui/BaseButton.vue'

const { locale, t } = useI18n()
const route = useRoute()
const isScrolled = ref(false)
const isMobileMenuOpen = ref(false)
const mobileSubmenuOpen = ref(null) // Tracks which mobile submenu is open

const isSpecialPage = computed(() => ['/spsb26', '/pbs26'].includes(route.path))

const changeLanguage = (lang) => {
  locale.value = lang.toLowerCase()
}

const navLinks = computed(() => [
  { name: t('nav.home'), to: '/#hero' },
  { 
    name: t('nav.about'), 
    to: '/profil',
    submenu: [
      { name: 'Profil Pondok', to: '/profil' },
      { name: 'Fasilitas', to: '/fasilitas' },
      { name: 'IKPH / Alumni', to: '/ikph' }
    ]
  },
  { 
    name: 'Kurikulum', 
    to: '/kurikulum',
    submenu: [
      { name: 'KMI', to: '/kurikulum' },
      { name: 'SMP', to: '/kurikulum' },
      { name: 'MA', to: '/kurikulum' },
    ]
  },
  { 
    name: 'Program', 
    to: '/program',
    submenu: [
      { name: 'Kelas 6 KMI', to: '/program/kelas-6-kmi' },
      { name: 'Kelas 5 KMI', to: '/program/kelas-5-kmi' },
      { name: 'Tahfidz', to: '/program/tahfidz' },
      { name: 'Ekstrakurikuler', to: '/program/ekstrakurikuler' },
      { name: 'Pramuka', to: '/program/pramuka' },
      { name: 'OPPH', to: '/program/opph' },
    ]
  },
  { name: t('nav.news'), to: '/berita' },
  { 
    name: t('nav.activities'), 
    to: '/#news',
    submenu: [
      { name: t('nav.gallery'), to: '/galeri' },
      { name: 'Prestasi', to: '/prestasi' },
      { name: t('nav.agenda'), to: '/agenda' },
    ]
  },
  { name: t('nav.elearning'), to: '/e-learning' },
])

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

const toggleMobileSubmenu = (name) => {
  if (mobileSubmenuOpen.value === name) {
    mobileSubmenuOpen.value = null
  } else {
    mobileSubmenuOpen.value = name
  }
}
</script>

<template>
  <nav 
    class="fixed top-0 left-0 w-full z-[60] transition-all duration-500"
    :class="isScrolled ? 'glassmorphism border-b border-white/10 shadow-xl py-0' : 'border-transparent py-2'"
  >
    <div class="container-custom">
      <!-- Top Row: Logo, Search, Lang, Login -->
      <div class="flex items-center justify-between py-4">
        <!-- Brand Logo -->
        <router-link to="/#hero" class="brand flex flex-col shrink-0">
          <img src="/assets/images/logo.svg" alt="Al Hikmah" class="h-16 w-auto block" />
        </router-link>

        <!-- Search Bar (Desktop) -->
        <div class="hidden lg:flex flex-1 max-w-2xl mx-12">
          <div class="relative w-full">
            <input 
              type="text" 
              placeholder="Cari informasi..."
              class="w-full bg-white/10 text-white pl-10 pr-4 py-2.5 rounded-lg border-none focus:ring-2 focus:ring-secondary/50 outline-none placeholder:text-white/40"
            />
            <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-white/40" :size="20" />
          </div>
        </div>

        <!-- Right Side: Lang & Login -->
        <div class="hidden lg:flex items-center gap-4">
          <!-- Lang Toggle Dropdown -->
          <div class="relative group">
            <button class="p-2.5 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all flex items-center gap-2">
              <Globe :size="20" />
              <span class="text-xs font-bold uppercase">{{ locale }}</span>
            </button>
            <div class="absolute top-full right-0 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 min-w-[120px]">
              <div class="glassmorphism border border-white/10 rounded-xl shadow-2xl overflow-hidden p-2 flex flex-col gap-1">
                <button 
                  @click="changeLanguage('id')" 
                  class="text-left px-3 py-2 text-sm rounded-lg transition-all"
                  :class="locale === 'id' ? 'bg-secondary text-primary font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white'"
                >
                  Indonesia
                </button>
                <button 
                  @click="changeLanguage('en')" 
                  class="text-left px-3 py-2 text-sm rounded-lg transition-all"
                  :class="locale === 'en' ? 'bg-secondary text-primary font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white'"
                >
                  English
                </button>
                <button 
                  @click="changeLanguage('ar')" 
                  class="text-left px-3 py-2 text-sm rounded-lg transition-all cursor-not-allowed text-white/40"
                >
                  العربية
                </button>
              </div>
            </div>
          </div>

          <!-- Login Button -->
          <a href="/admin/login">
            <BaseButton variant="primary" size="sm" class="!bg-secondary !text-primary px-6 py-2.5 !rounded-lg font-bold border-none">
              {{ $t('nav.login') }}
            </BaseButton>
          </a>
        </div>

        <!-- Mobile Buttons (Back & Hamburger) -->
        <div class="lg:hidden flex items-center gap-2">
          <router-link 
            v-if="isSpecialPage && !isMobileMenuOpen" 
            to="/" 
            class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-full text-white/80 hover:text-white transition-all active:scale-95"
          >
            <ArrowLeft :size="18" />
            <span class="text-xs font-bold uppercase tracking-tight">Beranda</span>
          </router-link>

          <button 
            class="text-white p-2 hover:bg-white/5 rounded-lg transition-colors ml-1"
            @click="isMobileMenuOpen = !isMobileMenuOpen"
          >
            <Menu v-if="!isMobileMenuOpen" :size="28" />
            <X v-else :size="28" />
          </button>
        </div>
      </div>

      <!-- Bottom Row: Navigation Links (Desktop) -->
      <div class="hidden lg:block border-t border-white/10">
        <ul class="flex justify-center gap-8 py-3 m-0 list-none">
          <li v-for="link in navLinks" :key="link.name" class="relative group">
            <router-link 
              :to="link.to"
              class="flex items-center gap-1 text-white/80 hover:text-white font-medium transition-colors text-[0.95rem] tracking-wide py-2"
            >
              {{ link.name }}
              <ChevronDown v-if="link.submenu" :size="14" class="group-hover:rotate-180 transition-transform duration-300" />
            </router-link>

            <!-- Dropdown Menu -->
            <div 
              v-if="link.submenu"
              class="absolute top-full left-1/2 -translate-x-1/2 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 min-w-[220px]"
            >
              <div class="glassmorphism border border-white/10 rounded-xl shadow-2xl overflow-hidden p-2">
                <router-link 
                  v-for="sub in link.submenu" 
                  :key="sub.name"
                  :to="sub.to"
                  class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-all"
                >
                  {{ sub.name }}
                </router-link>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <Teleport to="body">
    <!-- Overlay -->
    <div 
      v-if="isMobileMenuOpen"
      class="fixed inset-0 bg-black/60 lg:hidden z-[70] backdrop-blur-sm"
      @click="isMobileMenuOpen = false"
    ></div>

    <!-- Mobile Menu Sidebar -->
    <div 
      class="fixed top-0 right-0 h-full w-72 bg-[#0a2230] shadow-2xl z-[80] transform transition-transform duration-300 lg:hidden"
      :class="isMobileMenuOpen ? 'translate-x-0' : 'translate-x-full'"
    >
      <div class="flex flex-col p-8 h-full overflow-y-auto space-y-6">
        <button class="self-end text-white" @click="isMobileMenuOpen = false">
          <X :size="28" />
        </button>
        
        <div class="relative w-full">
          <input 
            type="text" 
            placeholder="Search..."
            class="w-full bg-white/10 text-white pl-10 pr-4 py-2 rounded-lg border-none outline-none"
          />
          <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-white/50" :size="18" />
        </div>

        <nav class="flex flex-col space-y-2">
          <div v-for="link in navLinks" :key="link.name">
            <div v-if="link.submenu" class="flex flex-col">
              <button 
                @click="toggleMobileSubmenu(link.name)"
                class="flex items-center justify-between text-white/80 hover:text-white text-base font-medium py-2"
              >
                {{ link.name }}
                <ChevronDown :size="18" :class="mobileSubmenuOpen === link.name ? 'rotate-180' : ''" class="transition-transform" />
              </button>
              <div 
                v-if="mobileSubmenuOpen === link.name"
                class="flex flex-col pl-4 border-l border-white/10 space-y-2 mt-1 mb-2"
              >
                <router-link 
                  v-for="sub in link.submenu" 
                  :key="sub.name"
                  :to="sub.to"
                  class="text-white/60 hover:text-white text-sm py-1.5"
                  @click="isMobileMenuOpen = false"
                >
                  {{ sub.name }}
                </router-link>
              </div>
            </div>
            <router-link 
              v-else
              :to="link.to"
              class="block text-white/80 hover:text-white text-base font-medium py-2"
              @click="isMobileMenuOpen = false"
            >
              {{ link.name }}
            </router-link>
          </div>
        </nav>

        <hr class="border-white/10 mt-auto" />
        
        <a href="/admin/login" @click="isMobileMenuOpen = false">
          <BaseButton variant="primary" size="md" class="!bg-secondary !text-primary w-full !rounded-xl font-bold">
            {{ $t('nav.login') }}
          </BaseButton>
        </a>
      </div>
    </div>
  </Teleport>
</template>

<style scoped>
.brand img {
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}
</style>
