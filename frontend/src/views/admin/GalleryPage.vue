<script setup>
import { ref, onMounted } from 'vue'
import AdminLayout from '../../components/admin/AdminLayout.vue'
import axios from 'axios'
import { Upload, Trash2, X, Image as ImageIcon } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const token = localStorage.getItem('admin_token')
const headers = { Authorization: `Bearer ${token}` }

const gallery = ref([])
const loading = ref(true)
const uploading = ref(false)
const showModal = ref(false)

const form = ref({ caption: '', category: 'umum' })
const selectedFile = ref(null)
const previewUrl = ref('')
const fileInput = ref(null)

const categories = ['umum', 'kegiatan', 'fasilitas', 'prestasi', 'alumni']

const fetchGallery = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/gallery`)
    gallery.value = res.data
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

const openModal = () => {
  form.value = { caption: '', category: 'umum' }
  selectedFile.value = null
  previewUrl.value = ''
  showModal.value = true
}

const upload = async () => {
  if (!selectedFile.value) return
  uploading.value = true
  try {
    const fd = new FormData()
    fd.append('image', selectedFile.value)
    fd.append('caption', form.value.caption)
    fd.append('category', form.value.category)
    await axios.post(`${API_URL}/api/gallery`, fd, {
      headers: { ...headers, 'Content-Type': 'multipart/form-data' }
    })
    showModal.value = false
    fetchGallery()
  } catch (err) {
    console.error(err)
    alert('Gagal mengupload foto.')
  } finally {
    uploading.value = false
  }
}

const deletePhoto = async (id) => {
  if (!confirm('Yakin ingin menghapus foto ini?')) return
  try {
    await axios.delete(`${API_URL}/api/gallery/${id}`, { headers })
    fetchGallery()
  } catch (err) {
    console.error(err)
  }
}

onMounted(fetchGallery)
</script>

<template>
  <AdminLayout>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-lg font-bold">Manajemen Galeri</h2>
        <p class="text-sm text-white/40">Upload dan kelola foto-foto kegiatan pesantren</p>
      </div>
      <button
        @click="openModal"
        class="flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-400 text-black font-semibold rounded-xl text-sm transition-colors"
      >
        <Upload :size="16" />
        Upload Foto
      </button>
    </div>

    <!-- Gallery Grid -->
    <div v-if="loading" class="text-center py-10 text-white/30">Memuat galeri...</div>
    <div v-else-if="gallery.length === 0" class="text-center py-10 text-white/30">
      <ImageIcon :size="48" class="mx-auto mb-3 opacity-20" />
      <p>Belum ada foto. Klik "Upload Foto" untuk menambah.</p>
    </div>
    <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <div
        v-for="item in gallery"
        :key="item.id"
        class="group relative aspect-square bg-white/5 rounded-xl overflow-hidden border border-white/5"
      >
        <img :src="item.imageUrl" :alt="item.caption" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-between p-3">
          <div class="flex justify-end">
            <button @click="deletePhoto(item.id)" class="p-1.5 bg-red-500/80 hover:bg-red-500 rounded-lg transition-colors">
              <Trash2 :size="14" />
            </button>
          </div>
          <div>
            <span class="text-xs bg-amber-500/80 text-black px-2 py-0.5 rounded-full font-medium">{{ item.category }}</span>
            <p v-if="item.caption" class="text-xs text-white/80 mt-1.5 line-clamp-2">{{ item.caption }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Upload Modal -->
    <Teleport to="body">
      <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-[#1e293b] rounded-2xl border border-white/10 w-full max-w-md shadow-2xl">
          <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <h3 class="font-semibold">Upload Foto Baru</h3>
            <button @click="showModal = false" class="text-white/40 hover:text-white"><X :size="20" /></button>
          </div>
          <div class="p-6 space-y-4">
            <!-- File Drop Zone -->
            <div
              @click="fileInput.click()"
              class="border-2 border-dashed border-white/10 rounded-xl p-6 text-center cursor-pointer hover:border-amber-500/30 transition-colors"
            >
              <div v-if="previewUrl" class="relative">
                <img :src="previewUrl" class="max-h-40 mx-auto rounded-lg object-contain" />
                <p class="text-xs text-white/40 mt-2">{{ selectedFile?.name }}</p>
              </div>
              <div v-else>
                <Upload :size="32" class="mx-auto text-white/20 mb-2" />
                <p class="text-sm text-white/50">Klik untuk pilih foto</p>
                <p class="text-xs text-white/25 mt-1">JPG, PNG, WEBP · Maks 5MB</p>
              </div>
            </div>
            <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onFileChange" />

            <div>
              <label class="text-xs text-white/50 uppercase tracking-wider mb-1.5 block">Kategori</label>
              <select v-model="form.category" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500/50">
                <option v-for="cat in categories" :key="cat" :value="cat" class="bg-[#1e293b]">
                  {{ cat.charAt(0).toUpperCase() + cat.slice(1) }}
                </option>
              </select>
            </div>

            <div>
              <label class="text-xs text-white/50 uppercase tracking-wider mb-1.5 block">Keterangan (opsional)</label>
              <input v-model="form.caption" type="text" placeholder="Deskripsi foto..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-white/25 focus:outline-none focus:border-amber-500/50 transition-all" />
            </div>
          </div>
          <div class="px-6 py-4 border-t border-white/5 flex justify-end gap-3">
            <button @click="showModal = false" class="px-4 py-2 text-sm text-white/50 hover:text-white transition-colors">Batal</button>
            <button
              @click="upload"
              :disabled="!selectedFile || uploading"
              class="px-5 py-2 bg-amber-500 hover:bg-amber-400 text-black font-semibold rounded-xl text-sm transition-colors disabled:opacity-50"
            >
              {{ uploading ? 'Mengupload...' : 'Upload' }}
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </AdminLayout>
</template>
