<script setup>
import { ref, onMounted } from 'vue'
import AdminLayout from '../../components/admin/AdminLayout.vue'
import axios from 'axios'
import { Plus, Pencil, Trash2, Eye, EyeOff, X, Upload, Image as ImageIcon } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const token = localStorage.getItem('admin_token')
const headers = { Authorization: `Bearer ${token}` }

const news = ref([])
const loading = ref(true)
const showModal = ref(false)
const isEdit = ref(false)
const submitting = ref(false)

const form = ref({ id: null, title: '', excerpt: '', content: '', thumbnail: '', isPublished: false })
const selectedFile = ref(null)
const previewUrl = ref('')
const fileInput = ref(null)

const fetchNews = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/news/all`, { headers })
    news.value = res.data
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
}

const onFileChange = (e) => {
  const file = e.target.files[0]
  if (!file) return
  selectedFile.value = file
  previewUrl.value = URL.createObjectURL(file)
}

const openCreate = () => {
  form.value = { id: null, title: '', excerpt: '', content: '', thumbnail: '', isPublished: false }
  selectedFile.value = null
  previewUrl.value = ''
  isEdit.value = false
  showModal.value = true
}

const openEdit = (item) => {
  form.value = { ...item }
  selectedFile.value = null
  previewUrl.value = item.thumbnail ? (item.thumbnail.startsWith('http') ? item.thumbnail : `${API_URL}${item.thumbnail}`) : ''
  isEdit.value = true
  showModal.value = true
}

const closeModal = () => { 
  showModal.value = false 
  if (previewUrl.value && previewUrl.value.startsWith('blob:')) {
    URL.revokeObjectURL(previewUrl.value)
  }
}

const submit = async () => {
  if (!form.value.title || !form.value.excerpt || !form.value.content) {
    alert('Harap isi semua kolom wajib (*)')
    return
  }
  
  submitting.value = true
  try {
    const fd = new FormData()
    fd.append('title', form.value.title)
    fd.append('excerpt', form.value.excerpt)
    fd.append('content', form.value.content)
    fd.append('isPublished', form.value.isPublished)
    
    if (selectedFile.value) {
      fd.append('thumbnail', selectedFile.value)
    } else if (form.value.thumbnail) {
      fd.append('thumbnail', form.value.thumbnail)
    }

    const token = localStorage.getItem('admin_token')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`
      }
    }

    if (isEdit.value) {
      await axios.put(`${API_URL}/api/news/${form.value.id}`, fd, config)
    } else {
      await axios.post(`${API_URL}/api/news`, fd, config)
    }
    
    alert('Berita berhasil disimpan!')
    closeModal()
    fetchNews()
  } catch (err) {
    console.error('❌ Error Submit:', err)
    const errorMsg = err.response?.data?.message || err.message || 'Gagal menyimpan berita'
    alert(errorMsg)
  } finally {
    submitting.value = false
  }
}

const deleteNews = async (id) => {
  if (!confirm('Yakin ingin menghapus berita ini?')) return
  try {
    await axios.delete(`${API_URL}/api/news/${id}`, { headers })
    fetchNews()
  } catch (err) {
    console.error(err)
  }
}

const togglePublish = async (item) => {
  try {
    await axios.put(`${API_URL}/api/news/${item.id}`, { isPublished: !item.isPublished }, { headers })
    fetchNews()
  } catch (err) {
    console.error(err)
  }
}

const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })

onMounted(fetchNews)
</script>

<template>
  <AdminLayout>
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
      <div>
        <h2 class="text-2xl font-bold text-white">Manajemen Berita</h2>
        <p class="text-white/40">Kelola artikel berita dan pengumuman untuk ditampilkan di website utama</p>
      </div>
      <button
        @click="openCreate"
        class="flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-black font-bold rounded-xl transition-all shadow-lg shadow-amber-500/10 active:scale-95"
      >
        <Plus :size="20" />
        Tambah Berita
      </button>
    </div>

    <!-- Table -->
    <div class="bg-[#1e293b] rounded-2xl border border-white/5 overflow-hidden shadow-xl">
      <div v-if="loading" class="p-20 text-center">
        <div class="animate-spin w-8 h-8 border-4 border-amber-500 border-t-transparent rounded-full mx-auto mb-4"></div>
        <p class="text-white/30">Memuat data...</p>
      </div>
      <div v-else-if="news.length === 0" class="p-20 text-center">
        <ImageIcon :size="48" class="mx-auto mb-4 text-white/10" />
        <p class="text-white/30 text-lg">Belum ada berita yang dibuat.</p>
        <button @click="openCreate" class="mt-4 text-amber-500 hover:underline">Mulai buat berita pertama</button>
      </div>
      <div v-else class="overflow-x-auto">
        <table class="w-full text-left">
          <thead class="bg-white/2 border-b border-white/5">
            <tr class="text-white/40 text-xs uppercase tracking-widest">
              <th class="px-6 py-4 font-semibold">Berita</th>
              <th class="px-6 py-4 font-semibold">Tanggal</th>
              <th class="px-6 py-4 font-semibold">Status</th>
              <th class="px-6 py-4 font-semibold text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="item in news" :key="item.id" class="hover:bg-white/2 transition-colors">
              <td class="px-6 py-5">
                <div class="flex items-center gap-4">
                  <div class="w-16 h-12 rounded-lg bg-white/5 overflow-hidden flex-shrink-0 border border-white/10">
                    <img v-if="item.thumbnail" :src="item.thumbnail.startsWith('http') ? item.thumbnail : `${API_URL}${item.thumbnail}`" class="w-full h-full object-cover" />
                    <div v-else class="w-full h-full flex items-center justify-center text-white/10">
                      <ImageIcon :size="20" />
                    </div>
                  </div>
                  <div>
                    <p class="font-semibold text-white leading-tight mb-1">{{ item.title }}</p>
                    <p class="text-xs text-white/40 line-clamp-1 max-w-md">{{ item.excerpt }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-5 text-white/50 text-sm whitespace-nowrap">{{ formatDate(item.createdAt) }}</td>
              <td class="px-6 py-5">
                <span
                  :class="item.isPublished
                    ? 'bg-green-500/10 text-green-400 border-green-500/20'
                    : 'bg-white/5 text-white/40 border-white/10'"
                  class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border"
                >
                  {{ item.isPublished ? 'Tayang' : 'Draft' }}
                </span>
              </td>
              <td class="px-6 py-5">
                <div class="flex items-center justify-end gap-1">
                  <button
                    @click="togglePublish(item)"
                    class="p-2 rounded-lg hover:bg-white/5 transition-colors group"
                    :title="item.isPublished ? 'Sembunyikan' : 'Tampilkan'"
                  >
                    <Eye v-if="!item.isPublished" :size="18" class="text-white/40 group-hover:text-white" />
                    <EyeOff v-else :size="18" class="text-green-400 group-hover:text-green-300" />
                  </button>
                  <button @click="openEdit(item)" class="p-2 rounded-lg hover:bg-white/5 text-white/40 hover:text-amber-400 transition-colors">
                    <Pencil :size="18" />
                  </button>
                  <button @click="deleteNews(item.id)" class="p-2 rounded-lg hover:bg-red-500/10 text-white/40 hover:text-red-400 transition-colors">
                    <Trash2 :size="18" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form -->
    <Teleport to="body">
      <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-8 bg-black/80 backdrop-blur-md">
        <div class="bg-[#0f172a] rounded-3xl border border-white/10 w-full max-w-4xl shadow-2xl max-h-[90vh] flex flex-col overflow-hidden animate-in fade-in zoom-in duration-300">
          <!-- Modal Header -->
          <div class="flex items-center justify-between px-8 py-6 border-b border-white/5 bg-white/2">
            <div>
              <h3 class="text-xl font-bold text-white">{{ isEdit ? 'Edit Berita' : 'Buat Berita Baru' }}</h3>
              <p class="text-sm text-white/40 mt-0.5">{{ isEdit ? 'Perbarui informasi berita yang sudah ada' : 'Isi formulir untuk menambahkan berita baru' }}</p>
            </div>
            <button @click="closeModal" class="p-2 rounded-full hover:bg-white/5 text-white/40 hover:text-white transition-colors">
              <X :size="24" />
            </button>
          </div>

          <!-- Modal Body -->
          <div class="p-8 overflow-y-auto space-y-6 flex-1 custom-scrollbar">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <!-- Left Column: Media -->
              <div class="space-y-6">
                <div>
                  <label class="text-xs font-bold text-white/40 uppercase tracking-widest mb-3 block">Thumbnail Berita</label>
                  <div
                    @click="fileInput.click()"
                    class="relative aspect-[16/10] bg-white/5 rounded-2xl border-2 border-dashed border-white/10 flex flex-col items-center justify-center cursor-pointer hover:border-amber-500/30 hover:bg-amber-500/5 transition-all overflow-hidden group"
                  >
                    <img v-if="previewUrl" :src="previewUrl" class="w-full h-full object-cover" />
                    <div v-else class="flex flex-col items-center gap-2">
                      <div class="p-3 bg-white/5 rounded-full text-white/20 group-hover:text-amber-500 transition-colors">
                        <Upload :size="24" />
                      </div>
                      <p class="text-xs text-white/30 font-medium">Klik untuk upload</p>
                    </div>
                    
                    <!-- Overlay on Hover -->
                    <div v-if="previewUrl" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                      <p class="text-xs font-bold text-white bg-black/50 px-3 py-1.5 rounded-full">Ganti Gambar</p>
                    </div>
                  </div>
                  <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onFileChange" />
                  <p class="text-[10px] text-white/20 mt-2 text-center italic">Rekomendasi: 800x500px, Maks 5MB</p>
                </div>

                <div class="p-4 bg-white/2 rounded-2xl border border-white/5">
                  <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-white/40 uppercase tracking-widest">Status Publikasi</span>
                    <span :class="form.isPublished ? 'text-green-400' : 'text-white/30'" class="text-[10px] font-bold uppercase tracking-widest">
                      {{ form.isPublished ? 'TAYANG' : 'DRAFT' }}
                    </span>
                  </div>
                  <button
                    type="button"
                    @click="form.isPublished = !form.isPublished"
                    :class="form.isPublished ? 'bg-green-500/20 border-green-500/30' : 'bg-white/5 border-white/10'"
                    class="w-full py-3 rounded-xl border flex items-center justify-center gap-3 transition-all"
                  >
                    <div 
                      :class="form.isPublished ? 'bg-green-500' : 'bg-white/20'"
                      class="w-8 h-4 rounded-full relative transition-colors"
                    >
                      <div 
                        :class="form.isPublished ? 'translate-x-4' : 'translate-x-1'"
                        class="absolute top-0.5 w-3 h-3 bg-white rounded-full transition-transform"
                      ></div>
                    </div>
                    <span :class="form.isPublished ? 'text-green-400' : 'text-white/60'" class="text-sm font-bold">
                      {{ form.isPublished ? 'Berita Publik' : 'Simpan sebagai Draft' }}
                    </span>
                  </button>
                </div>
              </div>

              <!-- Right Column: Form -->
              <div class="md:col-span-2 space-y-6">
                <div>
                  <label class="text-xs font-bold text-white/40 uppercase tracking-widest mb-2 block">Judul Berita *</label>
                  <input v-model="form.title" type="text" placeholder="Masukkan judul yang menarik..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-white/20 focus:outline-none focus:border-amber-500/50 focus:bg-white/10 transition-all font-semibold" />
                </div>

                <div>
                  <label class="text-xs font-bold text-white/40 uppercase tracking-widest mb-2 block">Ringkasan (Excerpt) *</label>
                  <textarea v-model="form.excerpt" rows="2" placeholder="Tulis ringkasan singkat untuk tampilan daftar berita..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm text-white placeholder-white/20 focus:outline-none focus:border-amber-500/50 focus:bg-white/10 transition-all resize-none"></textarea>
                </div>

                <div>
                  <label class="text-xs font-bold text-white/40 uppercase tracking-widest mb-2 block">Konten Berita Lengkap *</label>
                  <textarea v-model="form.content" rows="10" placeholder="Tulis isi berita selengkap mungkin di sini..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm text-white placeholder-white/20 focus:outline-none focus:border-amber-500/50 focus:bg-white/10 transition-all resize-y min-h-[300px]"></textarea>
                  <p class="text-[10px] text-white/20 mt-2 italic">Dukung enter dan spasi untuk pemformatan teks dasar.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="px-8 py-6 border-t border-white/5 bg-white/2 flex justify-end items-center gap-4">
            <button @click="closeModal" class="px-6 py-3 text-sm font-bold text-white/40 hover:text-white transition-colors">Batal</button>
            <button
              @click="submit"
              :disabled="submitting"
              class="px-8 py-3 bg-amber-500 hover:bg-amber-400 disabled:opacity-50 disabled:hover:bg-amber-500 text-black font-bold rounded-2xl transition-all shadow-xl shadow-amber-500/10 active:scale-95 flex items-center gap-2"
            >
              <span v-if="submitting" class="w-4 h-4 border-2 border-black border-t-transparent rounded-full animate-spin"></span>
              {{ submitting ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Publikasikan Berita') }}
            </button>
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
  background: transparent;
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
    transform: scale(0.95) translateY(10px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}
</style>

