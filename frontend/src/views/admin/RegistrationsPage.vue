<script setup>
import { ref, onMounted, computed } from 'vue'
import AdminLayout from '../../components/admin/AdminLayout.vue'
import axios from 'axios'
import { Download, ChevronDown, X, CheckCircle, Clock, Trash2, Search, ExternalLink } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const token = localStorage.getItem('admin_token')
const headers = { Authorization: `Bearer ${token}` }

const registrations = ref([])
const loading = ref(true)
const searchQuery = ref('')
const selectedReg = ref(null)

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
  if (!searchQuery.value) return registrations.value
  const q = searchQuery.value.toLowerCase()
  return registrations.value.filter(r => 
    r.nama_lengkap.toLowerCase().includes(q) || 
    (r.no_registrasi && r.no_registrasi.toLowerCase().includes(q)) ||
    (r.nisn && r.nisn.includes(q))
  )
})

const exportCSV = () => {
  window.open(`${API_URL}/api/registrations/export?token=${token}`, '_blank')
}

const toggleVerify = async (id, status) => {
  try {
    await axios.put(`${API_URL}/api/registrations/${id}/verify`, { verified: status }, { headers })
    fetchRegistrations()
    if (selectedReg.value && selectedReg.value.id === id) {
      selectedReg.value.verified = status
    }
  } catch (err) {
    console.error(err)
  }
}

const deleteRegistration = async (id) => {
  if (!confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini?')) return
  try {
    await axios.delete(`${API_URL}/api/registrations/${id}`, { headers })
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
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
      <div>
        <h2 class="text-2xl font-bold text-white">Data Pendaftaran Santri</h2>
        <p class="text-sm text-white/40">{{ filtered.length }} pendaftar ditemukan</p>
      </div>
      <div class="flex items-center gap-3">
        <!-- Search -->
        <div class="relative">
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Cari nama / no reg / NISN..."
            class="bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2 text-sm text-white focus:outline-none focus:border-secondary/50 w-64"
          >
          <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-white/40" :size="16" />
        </div>
        <!-- Export -->
        <button @click="exportCSV" class="flex items-center gap-2 px-4 py-2 bg-secondary text-primary font-bold text-sm rounded-xl hover:bg-secondary/80 transition-colors">
          <Download :size="15" />
          Export CSV
        </button>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-[#1e293b] rounded-2xl border border-white/5 overflow-hidden shadow-xl">
      <div v-if="loading" class="p-20 text-center">
        <div class="inline-block animate-spin w-8 h-8 border-4 border-secondary border-t-transparent rounded-full mb-4"></div>
        <p class="text-white/30">Memuat data pendaftar...</p>
      </div>
      <div v-else-if="filtered.length === 0" class="p-20 text-center text-white/30">
        Belum ada data pendaftaran yang sesuai.
      </div>
      <div v-else class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-white/5 border-b border-white/5">
            <tr class="text-white/40 text-xs uppercase tracking-wider">
              <th class="text-left px-6 py-4 font-semibold">No. Reg</th>
              <th class="text-left px-6 py-4 font-semibold">Nama Lengkap</th>
              <th class="text-left px-6 py-4 font-semibold">NISN / NIK</th>
              <th class="text-left px-6 py-4 font-semibold">Asal Sekolah</th>
              <th class="text-left px-6 py-4 font-semibold">Tanggal</th>
              <th class="text-left px-6 py-4 font-semibold">Status</th>
              <th class="text-right px-6 py-4 font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="reg in filtered" :key="reg.id" class="hover:bg-white/2 transition-colors group">
              <td class="px-6 py-4 font-mono text-secondary text-xs">{{ reg.no_registrasi }}</td>
              <td class="px-6 py-4">
                <div class="font-bold text-white">{{ reg.nama_lengkap }}</div>
                <div class="text-xs text-white/40">{{ reg.email_pendaftar }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="text-white/70">{{ reg.nisn || '-' }}</div>
                <div class="text-[10px] text-white/30">{{ reg.nik || '-' }}</div>
              </td>
              <td class="px-6 py-4 text-white/60">{{ reg.asal_sekolah || '-' }}</td>
              <td class="px-6 py-4 text-white/50 whitespace-nowrap">{{ formatDate(reg.created_at) }}</td>
              <td class="px-6 py-4">
                <span v-if="reg.verified" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-500/10 text-green-400 border border-green-500/20 uppercase tracking-tighter">
                  <CheckCircle :size="10" /> Terverifikasi
                </span>
                <span v-else class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 uppercase tracking-tighter">
                  <Clock :size="10" /> Pending
                </span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button @click="selectedReg = reg" class="p-2 text-white/40 hover:text-secondary transition-colors" title="Detail">
                    <ExternalLink :size="18" />
                  </button>
                  <button @click="deleteRegistration(reg.id)" class="p-2 text-white/40 hover:text-red-500 transition-colors" title="Hapus">
                    <Trash2 :size="18" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Detail Modal (Bigger & More Detailed) -->
    <Teleport to="body">
      <div v-if="selectedReg" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
        <div class="bg-[#1e293b] rounded-3xl border border-white/10 w-full max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col animate-in zoom-in duration-300">
          <!-- Modal Header -->
          <div class="flex items-center justify-between px-8 py-6 border-b border-white/5 bg-white/2">
            <div>
              <h3 class="text-xl font-bold text-white">Detail Calon Santri</h3>
              <p class="text-xs text-secondary font-mono">{{ selectedReg.no_registrasi }}</p>
            </div>
            <button @click="selectedReg = null" class="p-2 bg-white/5 hover:bg-white/10 rounded-full text-white/40 hover:text-white transition-all">
              <X :size="24" />
            </button>
          </div>

          <!-- Modal Body -->
          <div class="p-8 overflow-y-auto space-y-8 flex-1 custom-scrollbar">
            <!-- Grid 1: Data Diri -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <div class="space-y-4">
                <h4 class="text-xs font-bold text-white/30 uppercase tracking-widest border-b border-white/5 pb-2">Identitas Diri</h4>
                <div class="space-y-3">
                  <div><p class="text-[10px] text-white/40 uppercase">Nama Lengkap</p><p class="text-sm font-bold text-white">{{ selectedReg.nama_lengkap }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">TTL</p><p class="text-sm text-white/80">{{ selectedReg.tempat_lahir }}, {{ selectedReg.tanggal_lahir }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">NISN / NIK</p><p class="text-sm text-white/80">{{ selectedReg.nisn }} / {{ selectedReg.nik }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">Jenis Kelamin</p><p class="text-sm text-white/80">{{ selectedReg.jenis_kelamin }}</p></div>
                </div>
              </div>

              <div class="space-y-4">
                <h4 class="text-xs font-bold text-white/30 uppercase tracking-widest border-b border-white/5 pb-2">Alamat & Kontak</h4>
                <div class="space-y-3">
                  <div><p class="text-[10px] text-white/40 uppercase">Email</p><p class="text-sm text-white/80">{{ selectedReg.email_pendaftar }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">Alamat</p><p class="text-sm text-white/80 leading-relaxed">{{ selectedReg.alamat }}, RT {{ selectedReg.rt_rw }}, {{ selectedReg.desa }}, {{ selectedReg.kecamatan }}</p></div>
                </div>
              </div>

              <div class="space-y-4">
                <h4 class="text-xs font-bold text-white/30 uppercase tracking-widest border-b border-white/5 pb-2">Asal Sekolah</h4>
                <div class="space-y-3">
                  <div><p class="text-[10px] text-white/40 uppercase">Nama Sekolah</p><p class="text-sm text-white/80 font-bold">{{ selectedReg.asal_sekolah }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">NPSN</p><p class="text-sm text-white/80">{{ selectedReg.npsn_sekolah }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">Alamat Sekolah</p><p class="text-sm text-white/80 leading-relaxed">{{ selectedReg.alamat_sekolah }}</p></div>
                </div>
              </div>
            </div>

            <!-- Grid 2: Orang Tua -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-white/5">
              <div class="space-y-4">
                <h4 class="text-xs font-bold text-white/30 uppercase tracking-widest border-b border-white/5 pb-2">Data Orang Tua</h4>
                <div class="grid grid-cols-2 gap-4">
                  <div><p class="text-[10px] text-white/40 uppercase">Nama Ayah</p><p class="text-sm text-white/80 font-bold">{{ selectedReg.nama_ayah_kandung }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">Pekerjaan Ayah</p><p class="text-sm text-white/80">{{ selectedReg.pekerjaan_ayah }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">Nama Ibu</p><p class="text-sm text-white/80 font-bold">{{ selectedReg.nama_ibu_kandung }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">Pekerjaan Ibu</p><p class="text-sm text-white/80">{{ selectedReg.pekerjaan_ibu }}</p></div>
                </div>
              </div>
              <div class="space-y-4">
                <h4 class="text-xs font-bold text-white/30 uppercase tracking-widest border-b border-white/5 pb-2">Dokumen Pendukung</h4>
                <div class="grid grid-cols-2 gap-3">
                  <a v-if="selectedReg.foto_3x4" :href="`${API_URL}${selectedReg.foto_3x4}`" target="_blank" class="flex items-center gap-2 p-2 bg-white/5 rounded-lg text-[10px] hover:bg-white/10 transition-all"><ExternalLink :size="12" /> Pas Foto 3x4</a>
                  <a v-if="selectedReg.file_ijazah" :href="`${API_URL}${selectedReg.file_ijazah}`" target="_blank" class="flex items-center gap-2 p-2 bg-white/5 rounded-lg text-[10px] hover:bg-white/10 transition-all"><ExternalLink :size="12" /> Ijazah</a>
                  <a v-if="selectedReg.file_kk" :href="`${API_URL}${selectedReg.file_kk}`" target="_blank" class="flex items-center gap-2 p-2 bg-white/5 rounded-lg text-[10px] hover:bg-white/10 transition-all"><ExternalLink :size="12" /> Kartu Keluarga</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="px-8 py-6 border-t border-white/5 bg-white/2 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <span class="text-xs text-white/40 italic">Mendaftar pada {{ formatDate(selectedReg.created_at) }}</span>
            </div>
            <div class="flex gap-4">
              <button 
                v-if="!selectedReg.verified"
                @click="toggleVerify(selectedReg.id, true)" 
                class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-green-600/20 flex items-center gap-2"
              >
                <CheckCircle :size="16" /> Verifikasi Pendaftar
              </button>
              <button 
                v-else
                @click="toggleVerify(selectedReg.id, false)" 
                class="px-6 py-2.5 bg-amber-600/20 hover:bg-amber-600/40 text-amber-400 border border-amber-600/30 rounded-xl text-xs font-bold transition-all"
              >
                Batalkan Verifikasi
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>
  </AdminLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.02);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.2);
}

.animate-in {
  animation: animate-in 0.3s ease-out;
}

@keyframes animate-in {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
