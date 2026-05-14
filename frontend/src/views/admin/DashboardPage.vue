<script setup>
import { ref, onMounted, computed } from 'vue'
import AdminLayout from '../../components/admin/AdminLayout.vue'
import axios from 'axios'
import { Newspaper, Image, ClipboardList, MessageSquare, UserCheck, Clock } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:5000'
const token = localStorage.getItem('admin_token')
const headers = { Authorization: `Bearer ${token}` }

const stats = ref({ news: 0, gallery: 0, registrations: 0, messages: 0 })
const recentRegistrations = ref([])
const recentMessages = ref([])
const loading = ref(true)

const fetchData = async () => {
  try {
    const [newsRes, galleryRes, regRes, msgRes] = await Promise.all([
      axios.get(`${API_URL}/api/news/all`, { headers }),
      axios.get(`${API_URL}/api/gallery`),
      axios.get(`${API_URL}/api/registrations`, { headers }),
      axios.get(`${API_URL}/api/contact`, { headers }),
    ])
    stats.value.news = newsRes.data.length
    stats.value.gallery = galleryRes.data.length
    stats.value.registrations = regRes.data.length
    stats.value.messages = msgRes.data.length
    recentRegistrations.value = regRes.data.slice(0, 5)
    recentMessages.value = msgRes.data.slice(0, 5)
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchData)

const statCards = computed(() => [
  { label: 'Total Berita', value: stats.value.news, icon: Newspaper, color: 'blue' },
  { label: 'Foto Galeri', value: stats.value.gallery, icon: Image, color: 'purple' },
  { label: 'Pendaftar', value: stats.value.registrations, icon: ClipboardList, color: 'green' },
  { label: 'Pesan Masuk', value: stats.value.messages, icon: MessageSquare, color: 'amber' },
])

const colorMap = {
  blue: 'bg-blue-500/10 text-blue-400 border-blue-500/20',
  purple: 'bg-purple-500/10 text-purple-400 border-purple-500/20',
  green: 'bg-green-500/10 text-green-400 border-green-500/20',
  amber: 'bg-amber-500/10 text-amber-400 border-amber-500/20',
}

const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
</script>

<template>
  <AdminLayout>
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      <div
        v-for="card in statCards"
        :key="card.label"
        class="bg-[#1e293b] rounded-xl p-5 border border-white/5"
      >
        <div class="flex items-center justify-between mb-3">
          <div :class="['p-2 rounded-lg border', colorMap[card.color]]">
            <component :is="card.icon" :size="18" />
          </div>
        </div>
        <p class="text-2xl font-bold">
          <span v-if="loading" class="animate-pulse text-white/20">--</span>
          <span v-else>{{ card.value }}</span>
        </p>
        <p class="text-xs text-white/40 mt-0.5">{{ card.label }}</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Pendaftar Terbaru -->
      <div class="bg-[#1e293b] rounded-xl border border-white/5 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <UserCheck :size="16" class="text-green-400" />
            <h2 class="font-semibold text-sm">Pendaftar Terbaru</h2>
          </div>
          <router-link to="/admin/registrations" class="text-xs text-amber-400 hover:underline">
            Lihat Semua
          </router-link>
        </div>
        <div class="divide-y divide-white/5">
          <div v-if="loading" class="p-5 text-center text-white/30 text-sm">Memuat...</div>
          <div v-else-if="recentRegistrations.length === 0" class="p-5 text-center text-white/30 text-sm">Belum ada pendaftar.</div>
          <div
            v-for="reg in recentRegistrations"
            :key="reg.id"
            class="px-5 py-3 flex items-center justify-between hover:bg-white/2"
          >
            <div>
              <p class="text-sm font-medium">{{ reg.childName }}</p>
              <p class="text-xs text-white/40">{{ reg.grade }} · {{ reg.phone }}</p>
            </div>
            <span class="text-xs" :class="reg.status === 'pending' ? 'text-amber-400' : 'text-green-400'">
              {{ reg.status }}
            </span>
          </div>
        </div>
      </div>

      <!-- Pesan Terbaru -->
      <div class="bg-[#1e293b] rounded-xl border border-white/5 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <Clock :size="16" class="text-amber-400" />
            <h2 class="font-semibold text-sm">Pesan Terbaru</h2>
          </div>
          <router-link to="/admin/messages" class="text-xs text-amber-400 hover:underline">
            Lihat Semua
          </router-link>
        </div>
        <div class="divide-y divide-white/5">
          <div v-if="loading" class="p-5 text-center text-white/30 text-sm">Memuat...</div>
          <div v-else-if="recentMessages.length === 0" class="p-5 text-center text-white/30 text-sm">Belum ada pesan.</div>
          <div
            v-for="msg in recentMessages"
            :key="msg.id"
            class="px-5 py-3 hover:bg-white/2"
          >
            <p class="text-sm font-medium">{{ msg.name }}</p>
            <p class="text-xs text-white/40 truncate">{{ msg.message }}</p>
            <p class="text-xs text-white/25 mt-1">{{ formatDate(msg.createdAt) }}</p>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
