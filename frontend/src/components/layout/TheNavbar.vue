<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { Menu, X, Search, Globe, Sun, Moon, ChevronDown } from 'lucide-vue-next'
import BaseButton from '../ui/BaseButton.vue'

const { locale, t } = useI18n()
const isScrolled = ref(false)
const isMobileMenuOpen = ref(false)
const mobileSubmenuOpen = ref(null) // Tracks which mobile submenu is open
const isDark = ref(true) // Default dark as per current design

const changeLanguage = (lang) => {
  locale.value = lang.toLowerCase()
}

const toggleTheme = () => {
  isDark.value = !isDark.value
  if (isDark.value) {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }
}

const navLinks = computed(() => [
  { name: t('nav.home'), to: '/#hero' },
  { name: t('nav.about'), to: '/#about' },
  { 
    name: t('nav.programs'), 
    to: '/#program',
    submenu: [
      { name: t('nav.kmi'), to: '/#program' },
      { name: t('nav.smp'), to: '/#program' },
      { name: t('nav.ma'), to: '/#program' },
    ]
  },
  { name: t('nav.facilities'), to: '/#fasilitas' },
  { 
    name: t('nav.activities'), 
    to: '/#news',
    submenu: [
      { name: t('nav.news'), to: '/#news' },
      { name: t('nav.agenda'), to: '/agenda' },
    ]
  },
  { name: t('nav.gallery'), to: '/#galeri' },
  { name: t('nav.contact'), to: '/#cta' },
])

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
  if (isDark.value) {
    document.documentElement.classList.add('dark')
  }
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
          <!-- Theme Toggle -->
          <button 
            @click="toggleTheme"
            class="p-2.5 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all"
            title="Toggle Theme"
          >
            <Sun v-if="isDark" :size="20" />
            <Moon v-else :size="20" />
          </button>

          <!-- Lang Toggle -->
          <div class="flex bg-white/10 rounded-lg p-1">
            <button 
              @click="changeLanguage('id')"
              class="px-3 py-1 text-xs font-bold rounded-md transition-all"
              :class="locale === 'id' ? 'bg-secondary text-primary shadow-sm' : 'text-white/60 hover:text-white'"
            >
              ID
            </button>
            <button 
              @click="changeLanguage('en')"
              class="px-3 py-1 text-xs font-bold rounded-md transition-all"
              :class="locale === 'en' ? 'bg-secondary text-primary shadow-sm' : 'text-white/60 hover:text-white'"
            >
              EN
            </button>
            <button 
              @click="changeLanguage('ar')"
              class="px-3 py-1 text-xs font-bold rounded-md transition-all cursor-not-allowed"
              :class="locale === 'ar' ? 'bg-secondary text-primary shadow-sm' : 'text-white/60 hover:text-white'"
            >
              AR
            </button>
          </div>

          <!-- Login Button -->
          <BaseButton variant="primary" size="sm" class="!bg-secondary !text-primary px-6 py-2.5 !rounded-lg font-bold border-none">
            {{ $t('nav.login') }}
          </BaseButton>
        </div>

        <!-- Mobile Hamburger -->
        <button 
          class="lg:hidden text-white p-2"
          @click="isMobileMenuOpen = !isMobileMenuOpen"
        >
          <Menu v-if="!isMobileMenuOpen" :size="28" />
          <X v-else :size="28" />
        </button>
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

    <!-- Mobile Menu Sidebar -->
    <div 
      class="fixed top-0 right-0 h-full w-72 bg-[#0a2230] shadow-2xl z-50 transform transition-transform duration-300 lg:hidden"
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
        
        <BaseButton variant="primary" size="md" class="!bg-secondary !text-primary w-full !rounded-xl font-bold" @click="isMobileMenuOpen = false">
          {{ $t('nav.login') }}
        </BaseButton>
      </div>
    </div>
    
    <!-- Overlay -->
    <div 
      v-if="isMobileMenuOpen"
      class="fixed inset-0 bg-black/60 lg:hidden z-40 backdrop-blur-sm"
      @click="isMobileMenuOpen = false"
    ></div>
  </nav>
</template>

<style scoped>
.brand img {
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}
</style>
