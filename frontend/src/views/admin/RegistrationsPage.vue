<script setup>
import { ref, onMounted, computed } from 'vue'
import AdminLayout from '../../components/admin/AdminLayout.vue'
import axios from 'axios'
import { Download, ChevronDown, X } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const token = localStorage.getItem('admin_token')
const headers = { Authorization: `Bearer ${token}` }

const registrations = ref([])
const loading = ref(true)
const filterGrade = ref('semua')
const selectedReg = ref(null)

const grades = ['semua', 'KMI', 'SMP', 'MA']

const statusColors = {
  pending: 'bg-amber-500/10 text-amber-400 border-amber-500/20',
  diterima: 'bg-green-500/10 text-green-400 border-green-500/20',
  ditolak: 'bg-red-500/10 text-red-400 border-red-500/20',
}

const fetchRegistrations = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/registrations`, { headers })
    registrations.value = res.data
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
}

const filtered = computed(() => {
  if (filterGrade.value === 'semua') return registrations.value
  return registrations.value.filter(r => r.grade === filterGrade.value)
})

const exportCSV = () => {
  window.open(`${API_URL}/api/registrations/export?token=${token}`, '_blank')
}

const updateStatus = async (id, status) => {
  try {
    await axios.put(`${API_URL}/api/registrations/${id}/status`, { status }, { headers })
    fetchRegistrations()
    selectedReg.value = null
  } catch (err) {
    console.error(err)
  }
}

const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })

onMounted(fetchRegistrations)
</script>

<template>
  <AdminLayout>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-lg font-bold">Data Pendaftaran</h2>
        <p class="text-sm text-white/40">{{ filtered.length }} pendaftar ditemukan</p>
      </div>
      <div class="flex items-center gap-3">
        <!-- Filter -->
        <select v-model="filterGrade" class="bg-white/5 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500/50">
          <option v-for="g in grades" :key="g" :value="g" class="bg-[#1e293b]">
            {{ g.charAt(0).toUpperCase() + g.slice(1) }}
          </option>
        </select>
        <!-- Export -->
        <button @click="exportCSV" class="flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-sm rounded-xl transition-colors">
          <Download :size="15" />
          Export CSV
        </button>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-[#1e293b] rounded-xl border border-white/5 overflow-hidden">
      <div v-if="loading" class="p-10 text-center text-white/30">Memuat data...</div>
      <div v-else-if="filtered.length === 0" class="p-10 text-center text-white/30">Belum ada data pendaftaran.</div>
      <div v-else class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="border-b border-white/5">
            <tr class="text-white/40 text-xs uppercase">
              <th class="text-left px-5 py-3">Nama Santri</th>
              <th class="text-left px-5 py-3">Orang Tua</th>
              <th class="text-left px-5 py-3">Jenjang</th>
              <th class="text-left px-5 py-3">Telepon</th>
              <th class="text-left px-5 py-3">Tanggal</th>
              <th class="text-left px-5 py-3">Status</th>
              <th class="text-right px-5 py-3">Detail</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="reg in filtered" :key="reg.id" class="hover:bg-white/2 transition-colors">
              <td class="px-5 py-3 font-medium">{{ reg.childName }}</td>
              <td class="px-5 py-3 text-white/60">{{ reg.parentName }}</td>
              <td class="px-5 py-3">
                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-0.5 rounded-full text-xs">{{ reg.grade }}</span>
              </td>
              <td class="px-5 py-3 text-white/60">{{ reg.phone }}</td>
              <td class="px-5 py-3 text-white/50 whitespace-nowrap">{{ formatDate(reg.createdAt) }}</td>
              <td class="px-5 py-3">
                <span :class="['px-2 py-0.5 rounded-full text-xs border', statusColors[reg.status] || statusColors.pending]">
                  {{ reg.status }}
                </span>
              </td>
              <td class="px-5 py-3 text-right">
                <button @click="selectedReg = reg" class="text-xs text-amber-400 hover:underline">Detail</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Detail Modal -->
    <Teleport to="body">
      <div v-if="selectedReg" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-[#1e293b] rounded-2xl border border-white/10 w-full max-w-md shadow-2xl">
          <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <h3 class="font-semibold">Detail Pendaftar</h3>
            <button @click="selectedReg = null" class="text-white/40 hover:text-white"><X :size="20" /></button>
          </div>
          <div class="p-6 space-y-3 text-sm">
            <div class="grid grid-cols-2 gap-3">
              <div><p class="text-xs text-white/40 mb-0.5">Nama Santri</p><p class="font-medium">{{ selectedReg.childName }}</p></div>
              <div><p class="text-xs text-white/40 mb-0.5">Nama Orang Tua</p><p>{{ selectedReg.parentName }}</p></div>
              <div><p class="text-xs text-white/40 mb-0.5">Email</p><p>{{ selectedReg.email }}</p></div>
              <div><p class="text-xs text-white/40 mb-0.5">Telepon</p><p>{{ selectedReg.phone }}</p></div>
              <div><p class="text-xs text-white/40 mb-0.5">Jenjang</p><p>{{ selectedReg.grade }}</p></div>
              <div><p class="text-xs text-white/40 mb-0.5">Tanggal Daftar</p><p>{{ formatDate(selectedReg.createdAt) }}</p></div>
            </div>
            <div><p class="text-xs text-white/40 mb-0.5">Alamat</p><p>{{ selectedReg.address }}</p></div>
            <!-- Update Status -->
            <div class="pt-3 border-t border-white/5">
              <p class="text-xs text-white/40 mb-2">Update Status:</p>
              <div class="flex gap-2">
                <button @click="updateStatus(selectedReg.id, 'diterima')" class="flex-1 py-2 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-xs font-medium hover:bg-green-500/20 transition-colors">✓ Terima</button>
                <button @click="updateStatus(selectedReg.id, 'pending')" class="flex-1 py-2 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-xl text-xs font-medium hover:bg-amber-500/20 transition-colors">Pending</button>
                <button @click="updateStatus(selectedReg.id, 'ditolak')" class="flex-1 py-2 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-xs font-medium hover:bg-red-500/20 transition-colors">✗ Tolak</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Teleport>
  </AdminLayout>
</template>
