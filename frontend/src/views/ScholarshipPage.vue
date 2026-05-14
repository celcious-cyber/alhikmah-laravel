<script setup>
import { ref, reactive } from 'vue'
import { 
  GraduationCap, Trophy, BookOpen, HeartHandshake, 
  ArrowLeft, Upload, CheckCircle2, AlertCircle, FileText, Camera
} from 'lucide-vue-next'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const API_URL = import.meta.env.VITE_API_URL || ''

const isSubmitting = ref(false)
const isSuccess = ref(false)
const errorMessage = ref('')

const scholarshipTypes = [
  { id: 'Akademik', title: 'Prestasi Akademik', icon: GraduationCap, color: 'from-blue-500 to-indigo-600', description: 'Nilai rapot tinggi & peringkat 1-5 di kelas.' },
  { id: 'Non-Akademik', title: 'Prestasi Non-Akademik', icon: Trophy, color: 'from-amber-500 to-orange-600', description: 'Juara lomba seni, olahraga, atau lainnya.' },
  { id: 'Tahfidz', title: 'Tahfidzul Qur\'an', icon: BookOpen, color: 'from-emerald-500 to-teal-600', description: 'Memiliki hafalan Al-Qur\'an minimal 3 Juz.' },
  { id: 'Tidak Mampu', title: 'Beasiswa Tidak Mampu', icon: HeartHandshake, color: 'from-rose-500 to-pink-600', description: 'Memiliki SKTM atau terdaftar di data DTKS.' },
]

const form = reactive({
  jenis_beasiswa: '',
  nama_lengkap: '',
  tempat_lahir: '',
  tanggal_lahir: '',
  email_pendaftar: '',
  telepon: '',
  asal_sekolah: '',
  prestasi_deskripsi: '',
})

const files = reactive({
  file_sertifikat: null,
  file_sk_hafalan: null,
  file_sktm: null,
  file_rekomendasi: null,
  file_komitmen: null,
})

const handleFile = (e, field) => {
  files[field] = e.target.files[0]
}

const submitForm = async () => {
  isSubmitting.value = true
  errorMessage.value = ''
  
  try {
    const formData = new FormData()
    Object.keys(form).forEach(key => formData.append(key, form[key]))
    Object.keys(files).forEach(key => {
      if (files[key]) formData.append(key, files[key])
    })

    await axios.post(`${API_URL}/api/beasiswa`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })

    isSuccess.value = true
    window.scrollTo({ top: 0, behavior: 'smooth' })
  } catch (err) {
    console.error(err)
    errorMessage.value = err.response?.data?.message || 'Gagal mengirim pendaftaran beasiswa.'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<template>
  <div class="min-h-screen bg-[#0f172a] text-white selection:bg-secondary/30">
    <!-- Navbar / Back Button -->
    <nav class="fixed top-0 inset-x-0 z-50 bg-black/20 backdrop-blur-md border-b border-white/5">
      <div class="container mx-auto px-6 py-4 flex items-center gap-4">
        <button @click="router.push('/')" class="p-2 hover:bg-white/5 rounded-full transition-colors">
          <ArrowLeft :size="20" />
        </button>
        <h1 class="font-bold text-lg">Program Beasiswa Al-Hikmah 2026</h1>
      </div>
    </nav>

    <main class="container mx-auto px-6 pt-28 pb-20 max-w-4xl">
      <!-- Success State -->
      <div v-if="isSuccess" class="text-center py-20 animate-in fade-in zoom-in duration-500">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-500/20 text-green-500 mb-8">
          <CheckCircle2 :size="48" />
        </div>
        <h2 class="text-3xl font-bold mb-4">Pendaftaran Terkirim!</h2>
        <p class="text-white/60 max-w-md mx-auto mb-10">Terima kasih telah mendaftar Program Beasiswa Al-Hikmah. Kami akan melakukan verifikasi berkas dan menghubungi Anda melalui WhatsApp atau Email.</p>
        <button @click="router.push('/')" class="px-8 py-4 bg-white/5 hover:bg-white/10 rounded-2xl font-bold transition-all">Kembali ke Beranda</button>
      </div>

      <div v-else class="space-y-12">
        <!-- Header Section -->
        <div class="text-center space-y-4">
          <span class="inline-block px-4 py-1.5 bg-secondary/10 text-secondary rounded-full text-xs font-bold tracking-widest uppercase">Penerimaan Beasiswa Santri Baru (PBS26)</span>
          <h2 class="text-4xl md:text-5xl font-black">Raih <span class="text-secondary italic">Pendidikan Terbaik</span> Bersama Kami</h2>
          <p class="text-white/40 max-w-2xl mx-auto">Al-Hikmah berkomitmen mendukung santri-santri berbakat dan berdedikasi melalui berbagai jalur beasiswa penuh dan parsial.</p>
        </div>

        <!-- Step 1: Pilih Jenis Beasiswa -->
        <div v-if="!form.jenis_beasiswa" class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-in slide-in-from-bottom-8 duration-500">
          <button 
            v-for="type in scholarshipTypes" 
            :key="type.id"
            @click="form.jenis_beasiswa = type.id"
            class="group relative text-left p-8 bg-white/5 border border-white/10 rounded-[2.5rem] hover:bg-white/10 hover:border-secondary/30 transition-all hover:-translate-y-1 overflow-hidden"
          >
            <div :class="['w-16 h-16 rounded-2xl bg-gradient-to-br mb-6 flex items-center justify-center text-white', type.color]">
              <component :is="type.icon" :size="32" />
            </div>
            <h3 class="text-xl font-bold mb-2 group-hover:text-secondary transition-colors">{{ type.title }}</h3>
            <p class="text-sm text-white/40 leading-relaxed">{{ type.description }}</p>
            <div class="absolute top-4 right-8 text-4xl font-black text-white/[0.03] group-hover:text-white/5 transition-all">0{{ scholarshipTypes.indexOf(type) + 1 }}</div>
          </button>
        </div>

        <!-- Step 2: Form Pendaftaran -->
        <div v-else class="bg-white/5 border border-white/10 rounded-[3rem] p-8 md:p-12 backdrop-blur-xl animate-in slide-in-from-bottom-8 duration-500">
          <button @click="form.jenis_beasiswa = ''" class="flex items-center gap-2 text-white/40 hover:text-white text-sm mb-10 transition-colors">
            <ArrowLeft :size="16" /> Ganti Jalur Beasiswa
          </button>

          <form @submit.prevent="submitForm" class="space-y-10">
            <div class="flex items-center gap-4 p-6 bg-secondary/5 border border-secondary/10 rounded-2xl mb-10">
              <div class="w-12 h-12 rounded-xl bg-secondary flex items-center justify-center text-primary">
                <component :is="scholarshipTypes.find(t => t.id === form.jenis_beasiswa)?.icon" :size="24" />
              </div>
              <div>
                <p class="text-[10px] text-secondary font-bold tracking-widest uppercase">Jalur Yang Dipilih</p>
                <p class="font-bold text-lg">Beasiswa {{ form.jenis_beasiswa }}</p>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <!-- Data Diri -->
              <div class="space-y-6">
                <h4 class="text-lg font-bold flex items-center gap-2"><FileText :size="20" class="text-secondary" /> Data Diri</h4>
                <div class="space-y-4">
                  <div class="space-y-2">
                    <label class="text-xs font-bold text-white/40 ml-1 uppercase">Nama Lengkap</label>
                    <input v-model="form.nama_lengkap" type="text" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Sesuai Ijazah">
                  </div>
                  <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                      <label class="text-xs font-bold text-white/40 ml-1 uppercase">Tempat Lahir</label>
                      <input v-model="form.tempat_lahir" type="text" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Kota / Kab">
                    </div>
                    <div class="space-y-2">
                      <label class="text-xs font-bold text-white/40 ml-1 uppercase">Tanggal Lahir</label>
                      <input v-model="form.tanggal_lahir" type="date" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
                    </div>
                  </div>
                  <div class="space-y-2">
                    <label class="text-xs font-bold text-white/40 ml-1 uppercase">Email Aktif</label>
                    <input v-model="form.email_pendaftar" type="email" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="nama@email.com">
                  </div>
                  <div class="space-y-2">
                    <label class="text-xs font-bold text-white/40 ml-1 uppercase">No. WhatsApp</label>
                    <input v-model="form.telepon" type="tel" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="08xxxxxxxxxx">
                  </div>
                </div>
              </div>

              <!-- Data Akademik -->
              <div class="space-y-6">
                <h4 class="text-lg font-bold flex items-center gap-2"><GraduationCap :size="20" class="text-secondary" /> Akademik</h4>
                <div class="space-y-4">
                  <div class="space-y-2">
                    <label class="text-xs font-bold text-white/40 ml-1 uppercase">Asal Sekolah</label>
                    <input v-model="form.asal_sekolah" type="text" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="SD / MI / SMP...">
                  </div>
                  <div class="space-y-2">
                    <label class="text-xs font-bold text-white/40 ml-1 uppercase">Deskripsi Prestasi / Kondisi</label>
                    <textarea v-model="form.prestasi_deskripsi" rows="4" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Sebutkan prestasi terbaik Anda..."></textarea>
                  </div>
                </div>
              </div>
            </div>

            <!-- Upload Dokumen -->
            <div class="pt-10 border-t border-white/5 space-y-8">
              <h4 class="text-lg font-bold flex items-center gap-2"><Upload :size="20" class="text-secondary" /> Upload Berkas Persyaratan</h4>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sertifikat (Akademik/Non-Akademik/Tahfidz) -->
                <div v-if="['Akademik', 'Non-Akademik', 'Tahfidz'].includes(form.jenis_beasiswa)" class="space-y-2">
                  <label class="text-xs font-bold text-white/40 ml-1 uppercase">
                    {{ form.jenis_beasiswa === 'Tahfidz' ? 'Sertifikat Hafalan / Syahadah' : 'Sertifikat Prestasi / Rapot' }}
                  </label>
                  <input type="file" required @change="e => handleFile(e, form.jenis_beasiswa === 'Tahfidz' ? 'file_sk_hafalan' : 'file_sertifikat')" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm file:bg-secondary/20 file:text-secondary file:border-none file:rounded-lg file:px-4 file:py-1 file:mr-4 file:font-bold hover:file:bg-secondary/30 transition-all">
                </div>

                <!-- SKTM (Tidak Mampu) -->
                <div v-if="form.jenis_beasiswa === 'Tidak Mampu'" class="space-y-2">
                  <label class="text-xs font-bold text-white/40 ml-1 uppercase">Surat Keterangan Tidak Mampu (SKTM / DTKS)</label>
                  <input type="file" required @change="e => handleFile(e, 'file_sktm')" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm file:bg-secondary/20 file:text-secondary file:border-none file:rounded-lg file:px-4 file:py-1 file:mr-4 file:font-bold hover:file:bg-secondary/30 transition-all">
                </div>

                <!-- Surat Rekomendasi -->
                <div class="space-y-2">
                  <label class="text-xs font-bold text-white/40 ml-1 uppercase">Surat Rekomendasi (Sekolah/Tokoh)</label>
                  <input type="file" required @change="e => handleFile(e, 'file_rekomendasi')" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm file:bg-secondary/20 file:text-secondary file:border-none file:rounded-lg file:px-4 file:py-1 file:mr-4 file:font-bold hover:file:bg-secondary/30 transition-all">
                </div>

                <!-- Surat Komitmen -->
                <div class="space-y-2">
                  <label class="text-xs font-bold text-white/40 ml-1 uppercase">Surat Komitmen (Tertanda Tangan)</label>
                  <input type="file" required @change="e => handleFile(e, 'file_komitmen')" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm file:bg-secondary/20 file:text-secondary file:border-none file:rounded-lg file:px-4 file:py-1 file:mr-4 file:font-bold hover:file:bg-secondary/30 transition-all">
                </div>
              </div>
            </div>

            <!-- Submit -->
            <div v-if="errorMessage" class="p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm flex items-center gap-3">
              <AlertCircle :size="18" /> {{ errorMessage }}
            </div>

            <button 
              type="submit" 
              :disabled="isSubmitting"
              class="w-full py-6 bg-secondary text-primary font-black text-xl rounded-2xl hover:bg-secondary/90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 shadow-2xl shadow-secondary/20"
            >
              <template v-if="isSubmitting">
                <div class="w-6 h-6 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                Mengirim...
              </template>
              <template v-else>
                Daftar Beasiswa Sekarang
              </template>
            </button>
          </form>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.animate-in {
  animation: animate-in 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

@keyframes animate-in {
  from {
    opacity: 0;
    transform: translateY(20px) scale(0.98);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}
</style>
