<script setup>
import { ref, onMounted, computed } from 'vue'
import AdminLayout from '../../components/admin/AdminLayout.vue'
import axios from 'axios'
import { GraduationCap, CheckCircle, Clock, Trash2, Search, ExternalLink, X } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const token = localStorage.getItem('admin_token')
const headers = { Authorization: `Bearer ${token}` }

const scholarships = ref([])
const loading = ref(true)
const searchQuery = ref('')
const selectedReg = ref(null)

const fetchScholarships = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/admin/beasiswa`, { headers })
    scholarships.value = res.data
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
}

const filtered = computed(() => {
  if (!searchQuery.value) return scholarships.value
  const q = searchQuery.value.toLowerCase()
  return scholarships.value.filter(r => 
    r.nama_lengkap.toLowerCase().includes(q) || 
    r.jenis_beasiswa.toLowerCase().includes(q) ||
    (r.no_registrasi && r.no_registrasi.toLowerCase().includes(q))
  )
})

const toggleVerify = async (id, status) => {
  try {
    await axios.put(`${API_URL}/api/admin/beasiswa/${id}/verify`, { verified: status }, { headers })
    fetchScholarships()
    if (selectedReg.value && selectedReg.value.id === id) {
      selectedReg.value.verified = status
    }
  } catch (err) {
    console.error(err)
  }
}

const deleteScholarship = async (id) => {
  if (!confirm('Apakah Anda yakin ingin menghapus data beasiswa ini?')) return
  try {
    await axios.delete(`${API_URL}/api/admin/beasiswa/${id}`, { headers })
    fetchScholarships()
    selectedReg.value = null
  } catch (err) {
    console.error(err)
  }
}

const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })

onMounted(fetchScholarships)
</script>

<template>
  <AdminLayout>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
      <div>
        <h2 class="text-2xl font-bold text-white">Data Beasiswa (PBS26)</h2>
        <p class="text-sm text-white/40">{{ filtered.length }} pendaftar beasiswa</p>
      </div>
      <div class="relative">
        <input 
          v-model="searchQuery"
          type="text" 
          placeholder="Cari nama / jalur / no reg..."
          class="bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2 text-sm text-white focus:outline-none focus:border-secondary/50 w-64"
        >
        <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-white/40" :size="16" />
      </div>
    </div>

    <div class="bg-[#1e293b] rounded-2xl border border-white/5 overflow-hidden shadow-xl">
      <div v-if="loading" class="p-20 text-center text-white/30">Memuat data...</div>
      <div v-else-if="filtered.length === 0" class="p-20 text-center text-white/30">Belum ada pendaftar beasiswa.</div>
      <div v-else class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-white/5 border-b border-white/5">
            <tr class="text-white/40 text-xs uppercase tracking-wider">
              <th class="text-left px-6 py-4">No. Reg</th>
              <th class="text-left px-6 py-4">Nama Lengkap</th>
              <th class="text-left px-6 py-4">Jenis Beasiswa</th>
              <th class="text-left px-6 py-4">Sekolah Asal</th>
              <th class="text-left px-6 py-4">Status</th>
              <th class="text-right px-6 py-4">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="reg in filtered" :key="reg.id" class="hover:bg-white/2 transition-colors">
              <td class="px-6 py-4 font-mono text-secondary text-xs">{{ reg.no_registrasi }}</td>
              <td class="px-6 py-4 font-bold text-white">{{ reg.nama_lengkap }}</td>
              <td class="px-6 py-4">
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border border-secondary/30 text-secondary bg-secondary/5 uppercase">
                  {{ reg.jenis_beasiswa }}
                </span>
              </td>
              <td class="px-6 py-4 text-white/60">{{ reg.asal_sekolah }}</td>
              <td class="px-6 py-4">
                <span v-if="reg.verified" class="text-green-400 flex items-center gap-1.5"><CheckCircle :size="14" /> Terverifikasi</span>
                <span v-else class="text-amber-400 flex items-center gap-1.5"><Clock :size="14" /> Pending</span>
              </td>
              <td class="px-6 py-4 text-right space-x-2">
                <button @click="selectedReg = reg" class="p-2 text-white/40 hover:text-secondary"><ExternalLink :size="18" /></button>
                <button @click="deleteScholarship(reg.id)" class="p-2 text-white/40 hover:text-red-500"><Trash2 :size="18" /></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Detail -->
    <Teleport to="body">
      <div v-if="selectedReg" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
        <div class="bg-[#1e293b] rounded-3xl border border-white/10 w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl">
          <div class="flex items-center justify-between px-8 py-6 border-b border-white/5">
            <div>
              <h3 class="text-xl font-bold text-white">Detail Pendaftar Beasiswa</h3>
              <p class="text-xs text-secondary font-mono">{{ selectedReg.no_registrasi }}</p>
            </div>
            <button @click="selectedReg = null" class="p-2 hover:bg-white/5 rounded-full text-white/40"><X :size="24" /></button>
          </div>

              <div class="space-y-4">
                <h4 class="text-[10px] font-bold text-white/30 uppercase tracking-widest border-b border-white/5 pb-1">Data Personal</h4>
                <div class="grid grid-cols-2 gap-4">
                  <div><p class="text-[10px] text-white/40 uppercase">Nama Lengkap</p><p class="text-sm font-bold text-white">{{ selectedReg.nama_lengkap }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">TTL</p><p class="text-sm text-white/80">{{ selectedReg.tempat_lahir }}, {{ selectedReg.tanggal_lahir }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">Email</p><p class="text-sm text-white/80">{{ selectedReg.email_pendaftar }}</p></div>
                  <div><p class="text-[10px] text-white/40 uppercase">Telepon</p><p class="text-sm text-white/80">{{ selectedReg.telepon }}</p></div>
                  <div class="col-span-2"><p class="text-[10px] text-white/40 uppercase">Asal Sekolah</p><p class="text-sm text-white/80">{{ selectedReg.asal_sekolah }}</p></div>
                  <div class="col-span-2"><p class="text-[10px] text-white/40 uppercase">Deskripsi Prestasi</p><p class="text-sm text-white/80 leading-relaxed">{{ selectedReg.prestasi_deskripsi || '-' }}</p></div>
                </div>
              </div>

            <div class="pt-6 border-t border-white/5">
              <h4 class="text-xs font-bold text-white/30 uppercase mb-4 tracking-widest">Dokumen Persyaratan</h4>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a v-if="selectedReg.file_sertifikat" :href="`${API_URL}${selectedReg.file_sertifikat}`" target="_blank" class="p-3 bg-white/5 rounded-xl text-xs hover:bg-white/10 flex items-center gap-2"><ExternalLink :size="14" /> Sertifikat Prestasi</a>
                <a v-if="selectedReg.file_sk_hafalan" :href="`${API_URL}${selectedReg.file_sk_hafalan}`" target="_blank" class="p-3 bg-white/5 rounded-xl text-xs hover:bg-white/10 flex items-center gap-2"><ExternalLink :size="14" /> Sertifikat Tahfidz</a>
                <a v-if="selectedReg.file_sktm" :href="`${API_URL}${selectedReg.file_sktm}`" target="_blank" class="p-3 bg-white/5 rounded-xl text-xs hover:bg-white/10 flex items-center gap-2"><ExternalLink :size="14" /> File SKTM / DTKS</a>
                <a v-if="selectedReg.file_rekomendasi" :href="`${API_URL}${selectedReg.file_rekomendasi}`" target="_blank" class="p-3 bg-white/5 rounded-xl text-xs hover:bg-white/10 flex items-center gap-2"><ExternalLink :size="14" /> Surat Rekomendasi</a>
                <a v-if="selectedReg.file_komitmen" :href="`${API_URL}${selectedReg.file_komitmen}`" target="_blank" class="p-3 bg-white/5 rounded-xl text-xs hover:bg-white/10 flex items-center gap-2"><ExternalLink :size="14" /> Surat Komitmen</a>
              </div>
            </div>
          </div>

          <div class="px-8 py-6 border-t border-white/5 flex justify-end gap-3">
            <button v-if="!selectedReg.verified" @click="toggleVerify(selectedReg.id, true)" class="px-6 py-2 bg-green-600 text-white rounded-xl text-xs font-bold">Verifikasi Sekarang</button>
            <button v-else @click="toggleVerify(selectedReg.id, false)" class="px-6 py-2 bg-white/5 text-amber-400 border border-amber-600/30 rounded-xl text-xs font-bold">Batalkan Verifikasi</button>
          </div>
        </div>
      </div>
    </Teleport>
  </AdminLayout>
</template>
