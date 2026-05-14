<script setup>
import { computed } from 'vue'
import { useRoute, useRouter, RouterLink } from 'vue-router'
import {
  LayoutDashboard, Newspaper, Image, ClipboardList,
  MessageSquare, LogOut, Menu, X, ChevronRight, GraduationCap
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()

const navItems = [
  { path: '/admin/dashboard', label: 'Dashboard', icon: LayoutDashboard },
  { path: '/admin/news', label: 'Berita', icon: Newspaper },
  { path: '/admin/gallery', label: 'Galeri', icon: Image },
  { path: '/admin/registrations', label: 'Pendaftaran', icon: ClipboardList },
  { path: '/admin/scholarships', label: 'Beasiswa', icon: GraduationCap },
  { path: '/admin/messages', label: 'Pesan Masuk', icon: MessageSquare },
]

const currentLabel = computed(() => {
  const item = navItems.find(i => i.path === route.path)
  return item ? item.label : 'CMS'
})

const logout = () => {
  localStorage.removeItem('admin_token')
  localStorage.removeItem('admin_user')
  router.push('/admin/login')
}

const adminUser = computed(() => {
  const u = localStorage.getItem('admin_user')
  return u ? JSON.parse(u) : { name: 'Admin' }
})
</script>

<template>
  <div class="min-h-screen flex bg-[#0f172a] text-white font-sans">
    <!-- Sidebar -->
    <aside class="w-64 flex-shrink-0 bg-[#1e293b] flex flex-col border-r border-white/5">
      <!-- Logo -->
      <div class="p-6 border-b border-white/5">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center">
            <span class="text-black font-black text-lg">H</span>
          </div>
          <div>
            <p class="font-bold text-sm leading-tight">Al-Hikmah</p>
            <p class="text-xs text-white/40">CMS Panel</p>
          </div>
        </div>
      </div>

      <!-- Nav -->
      <nav class="flex-1 p-4 space-y-1">
        <RouterLink
          v-for="item in navItems"
          :key="item.path"
          :to="item.path"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200"
          :class="route.path === item.path
            ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20'
            : 'text-white/50 hover:text-white hover:bg-white/5'"
        >
          <component :is="item.icon" :size="18" />
          {{ item.label }}
          <ChevronRight v-if="route.path === item.path" :size="14" class="ml-auto" />
        </RouterLink>
      </nav>

      <!-- Admin Info + Logout -->
      <div class="p-4 border-t border-white/5">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center">
            <span class="text-amber-400 text-xs font-bold">{{ adminUser.name?.[0]?.toUpperCase() }}</span>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium truncate">{{ adminUser.name }}</p>
            <p class="text-xs text-white/40">Administrator</p>
          </div>
        </div>
        <button
          @click="logout"
          class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-red-400 hover:bg-red-500/10 transition-colors"
        >
          <LogOut :size="16" />
          Keluar
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- Topbar -->
      <header class="h-16 border-b border-white/5 bg-[#1e293b]/50 backdrop-blur flex items-center px-6">
        <h1 class="text-base font-semibold">{{ currentLabel }}</h1>
        <div class="ml-auto flex items-center gap-2">
          <a href="/" target="_blank" class="text-xs text-white/40 hover:text-amber-400 transition-colors">
            Lihat Website →
          </a>
        </div>
      </header>

      <!-- Slot Content -->
      <main class="flex-1 p-6 overflow-auto">
        <slot />
      </main>
    </div>
  </div>
</template>
