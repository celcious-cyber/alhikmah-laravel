<script setup>
import { ref, onMounted } from 'vue'
import AdminLayout from '../../components/admin/AdminLayout.vue'
import axios from 'axios'
import { Plus, Pencil, Trash2, Eye, EyeOff, X, Check } from 'lucide-vue-next'

const API_URL = import.meta.env.VITE_API_URL || ''
const token = localStorage.getItem('admin_token')
const headers = { Authorization: `Bearer ${token}` }

const news = ref([])
const loading = ref(true)
const showModal = ref(false)
const isEdit = ref(false)
const submitting = ref(false)

const form = ref({ id: null, title: '', excerpt: '', content: '', thumbnail: '', isPublished: false })

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

const openCreate = () => {
  form.value = { id: null, title: '', excerpt: '', content: '', thumbnail: '', isPublished: false }
  isEdit.value = false
  showModal.value = true
}

const openEdit = (item) => {
  form.value = { ...item }
  isEdit.value = true
  showModal.value = true
}

const closeModal = () => { showModal.value = false }

const submit = async () => {
  if (!form.value.title || !form.value.excerpt || !form.value.content) return
  submitting.value = true
  try {
    if (isEdit.value) {
      await axios.put(`${API_URL}/api/news/${form.value.id}`, form.value, { headers })
    } else {
      await axios.post(`${API_URL}/api/news`, form.value, { headers })
    }
    closeModal()
    fetchNews()
  } catch (err) {
    console.error(err)
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
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-lg font-bold">Manajemen Berita</h2>
        <p class="text-sm text-white/40">Kelola artikel berita dan pengumuman pesantren</p>
      </div>
      <button
        @click="openCreate"
        class="flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-400 text-black font-semibold rounded-xl text-sm transition-colors"
      >
        <Plus :size="16" />
        Berita Baru
      </button>
    </div>

    <!-- Table -->
    <div class="bg-[#1e293b] rounded-xl border border-white/5 overflow-hidden">
      <div v-if="loading" class="p-10 text-center text-white/30">Memuat data...</div>
      <div v-else-if="news.length === 0" class="p-10 text-center text-white/30">Belum ada berita. Klik "Berita Baru" untuk menambah.</div>
      <table v-else class="w-full text-sm">
        <thead class="border-b border-white/5">
          <tr class="text-white/40 text-xs uppercase">
            <th class="text-left px-5 py-3">Judul</th>
            <th class="text-left px-5 py-3">Tanggal</th>
            <th class="text-left px-5 py-3">Status</th>
            <th class="text-right px-5 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
          <tr v-for="item in news" :key="item.id" class="hover:bg-white/2 transition-colors">
            <td class="px-5 py-4">
              <p class="font-medium text-white">{{ item.title }}</p>
              <p class="text-xs text-white/40 mt-0.5 line-clamp-1">{{ item.excerpt }}</p>
            </td>
            <td class="px-5 py-4 text-white/50 whitespace-nowrap">{{ formatDate(item.createdAt) }}</td>
            <td class="px-5 py-4">
              <span
                :class="item.isPublished
                  ? 'bg-green-500/10 text-green-400 border-green-500/20'
                  : 'bg-white/5 text-white/40 border-white/10'"
                class="px-2 py-0.5 rounded-full text-xs border"
              >
                {{ item.isPublished ? 'Tayang' : 'Draft' }}
              </span>
            </td>
            <td class="px-5 py-4">
              <div class="flex items-center justify-end gap-2">
                <button
                  @click="togglePublish(item)"
                  class="p-1.5 rounded-lg hover:bg-white/5 transition-colors"
                  :title="item.isPublished ? 'Jadikan Draft' : 'Tayang'"
                >
                  <Eye v-if="!item.isPublished" :size="15" class="text-white/40" />
                  <EyeOff v-else :size="15" class="text-green-400" />
                </button>
                <button @click="openEdit(item)" class="p-1.5 rounded-lg hover:bg-white/5 text-white/40 hover:text-amber-400 transition-colors">
                  <Pencil :size="15" />
                </button>
                <button @click="deleteNews(item.id)" class="p-1.5 rounded-lg hover:bg-red-500/10 text-white/40 hover:text-red-400 transition-colors">
                  <Trash2 :size="15" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal Form -->
    <Teleport to="body">
      <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-[#1e293b] rounded-2xl border border-white/10 w-full max-w-2xl shadow-2xl max-h-[90vh] flex flex-col">
          <!-- Modal Header -->
          <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <h3 class="font-semibold">{{ isEdit ? 'Edit Berita' : 'Berita Baru' }}</h3>
            <button @click="closeModal" class="text-white/40 hover:text-white transition-colors">
              <X :size="20" />
            </button>
          </div>

          <!-- Modal Body -->
          <div class="p-6 overflow-y-auto space-y-4 flex-1">
            <div>
              <label class="text-xs text-white/50 uppercase tracking-wider mb-1.5 block">Judul *</label>
              <input v-model="form.title" type="text" placeholder="Judul berita..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-white/25 focus:outline-none focus:border-amber-500/50 transition-all" />
            </div>
            <div>
              <label class="text-xs text-white/50 uppercase tracking-wider mb-1.5 block">Ringkasan *</label>
              <textarea v-model="form.excerpt" rows="2" placeholder="Ringkasan singkat berita..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-white/25 focus:outline-none focus:border-amber-500/50 transition-all resize-none"></textarea>
            </div>
            <div>
              <label class="text-xs text-white/50 uppercase tracking-wider mb-1.5 block">Isi Berita *</label>
              <textarea v-model="form.content" rows="6" placeholder="Tulis isi berita di sini..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-white/25 focus:outline-none focus:border-amber-500/50 transition-all resize-none"></textarea>
            </div>
            <div>
              <label class="text-xs text-white/50 uppercase tracking-wider mb-1.5 block">URL Thumbnail</label>
              <input v-model="form.thumbnail" type="text" placeholder="https://..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-white/25 focus:outline-none focus:border-amber-500/50 transition-all" />
            </div>
            <div class="flex items-center gap-3">
              <button
                type="button"
                @click="form.isPublished = !form.isPublished"
                :class="form.isPublished ? 'bg-amber-500' : 'bg-white/10'"
                class="w-10 h-5 rounded-full transition-colors relative"
              >
                <span :class="form.isPublished ? 'translate-x-5' : 'translate-x-1'" class="block w-3.5 h-3.5 bg-white rounded-full transition-transform absolute top-0.5"></span>
              </button>
              <span class="text-sm text-white/60">Langsung Tayangkan</span>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="px-6 py-4 border-t border-white/5 flex justify-end gap-3">
            <button @click="closeModal" class="px-4 py-2 text-sm text-white/50 hover:text-white transition-colors">Batal</button>
            <button
              @click="submit"
              :disabled="submitting"
              class="px-5 py-2 bg-amber-500 hover:bg-amber-400 text-black font-semibold rounded-xl text-sm transition-colors disabled:opacity-60"
            >
              {{ submitting ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Publikasikan') }}
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </AdminLayout>
</template>

