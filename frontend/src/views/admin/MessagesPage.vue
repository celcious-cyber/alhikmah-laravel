<script setup>
import { ref, onMounted } from 'vue'
import AdminLayout from '../../components/admin/AdminLayout.vue'
import axios from 'axios'
import { MessageSquare, Mail, Phone, X } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const token = localStorage.getItem('admin_token')
const headers = { Authorization: `Bearer ${token}` }

const messages = ref([])
const loading = ref(true)
const selected = ref(null)

const fetchMessages = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/contact`, { headers })
    messages.value = res.data
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
}

const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })

onMounted(fetchMessages)
</script>

<template>
  <AdminLayout>
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-lg font-bold">Pesan Masuk</h2>
        <p class="text-sm text-white/40">{{ messages.length }} pesan dari form kontak</p>
      </div>
    </div>

    <div class="bg-[#1e293b] rounded-xl border border-white/5 overflow-hidden">
      <div v-if="loading" class="p-10 text-center text-white/30">Memuat pesan...</div>
      <div v-else-if="messages.length === 0" class="p-10 text-center">
        <MessageSquare :size="48" class="mx-auto text-white/10 mb-3" />
        <p class="text-white/30">Belum ada pesan masuk.</p>
      </div>
      <div v-else class="divide-y divide-white/5">
        <div
          v-for="msg in messages"
          :key="msg.id"
          @click="selected = msg"
          class="px-6 py-4 hover:bg-white/2 cursor-pointer transition-colors flex items-start gap-4"
        >
          <!-- Avatar -->
          <div class="w-10 h-10 rounded-full bg-amber-500/10 flex-shrink-0 flex items-center justify-center">
            <span class="text-amber-400 font-bold text-sm">{{ msg.name?.[0]?.toUpperCase() }}</span>
          </div>
          <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between gap-2">
              <p class="font-medium text-sm">{{ msg.name }}</p>
              <p class="text-xs text-white/30 whitespace-nowrap flex-shrink-0">{{ formatDate(msg.createdAt) }}</p>
            </div>
            <p class="text-xs text-white/50">{{ msg.email }}</p>
            <p class="text-sm text-white/40 mt-1 line-clamp-1">{{ msg.message }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <Teleport to="body">
      <div v-if="selected" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-[#1e293b] rounded-2xl border border-white/10 w-full max-w-lg shadow-2xl">
          <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <h3 class="font-semibold">Detail Pesan</h3>
            <button @click="selected = null" class="text-white/40 hover:text-white"><X :size="20" /></button>
          </div>
          <div class="p-6 space-y-4 text-sm">
            <div class="flex items-center gap-4">
              <div class="w-14 h-14 rounded-full bg-amber-500/10 flex items-center justify-center">
                <span class="text-amber-400 font-bold text-xl">{{ selected.name?.[0]?.toUpperCase() }}</span>
              </div>
              <div>
                <p class="font-bold text-base">{{ selected.name }}</p>
                <p class="text-white/40 text-xs">{{ formatDate(selected.createdAt) }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-3 bg-white/3 rounded-xl p-4">
              <div class="flex items-center gap-2 text-white/60">
                <Mail :size="14" class="text-amber-400" />
                <span class="text-xs">{{ selected.email }}</span>
              </div>
              <div class="flex items-center gap-2 text-white/60">
                <Phone :size="14" class="text-amber-400" />
                <span class="text-xs">{{ selected.phone }}</span>
              </div>
            </div>
            <div class="bg-white/3 rounded-xl p-4">
              <p class="text-xs text-white/40 mb-2 uppercase tracking-wider">Pesan:</p>
              <p class="text-white/80 leading-relaxed">{{ selected.message }}</p>
            </div>
            <a
              :href="`mailto:${selected.email}`"
              class="block w-full text-center py-2.5 bg-amber-500 hover:bg-amber-400 text-black font-semibold rounded-xl text-sm transition-colors"
            >
              Balas via Email
            </a>
          </div>
        </div>
      </div>
    </Teleport>
  </AdminLayout>
</template>
