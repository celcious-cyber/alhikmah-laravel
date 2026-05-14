<script setup>
import { ref, computed } from 'vue'
import SectionHeading from '../components/ui/SectionHeading.vue'
import BaseButton from '../components/ui/BaseButton.vue'
import { 
  User, Mail, Phone, MapPin, Send, CheckCircle, 
  ChevronRight, ChevronLeft, GraduationCap, Users, 
  FileText, Camera, Upload, Home, Heart, Target
} from 'lucide-vue-next'
import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL || ''

const currentStep = ref(1)
const totalSteps = 5
const isSubmitting = ref(false)
const isSubmitted = ref(false)
const errorMessage = ref('')

const form = ref({
  // Step 1: Data Pribadi
  nama_lengkap: '',
  email_pendaftar: '',
  tempat_lahir: '',
  tanggal_lahir: '',
  jenis_kelamin: '',
  nisn: '',
  nik: '',
  agama: 'Islam',
  hobi: '',
  cita_cita: '',
  anak_ke: '',
  jumlah_saudara_kandung: '',

  // Step 2: Alamat
  alamat: '',
  rt_rw: '',
  dusun: '',
  desa: '',
  kecamatan: '',
  kabupaten: '',
  provinsi: '',
  kode_pos: '',

  // Step 3: Orang Tua
  no_kk: '',
  kepala_keluarga: '',
  nama_ayah_kandung: '',
  status_ayah: 'Masih Hidup',
  alamat_ayah: '',
  nik_ayah: '',
  pekerjaan_ayah: '',
  nama_ibu_kandung: '',
  status_ibu: 'Masih Hidup',
  nik_ibu: '',
  pekerjaan_ibu: '',
  alamat_ibu: '',
  nama_wali: '',
  nik_wali: '',
  alamat_wali: '',
  penghasilan: '',

  // Step 4: Kesejahteraan & Sekolah
  no_kks: '',
  no_pkh: '',
  no_kip: '',
  asal_sekolah: '',
  npsn_sekolah: '',
  alamat_sekolah: '',
  no_surat_lulus: '',
  no_blangko_ijazah: '',
  nilai_rata2_ijazah: '',

  // Step 5: File Uploads (Refs for files)
  foto_3x4: null,
  file_ijazah: null,
  file_surat_lulus: null,
  file_akte_lahir: null,
  file_kk: null,
  file_kartu_nisn: null,
  file_kartu_kip: null,
  file_kartu_pkh: null,
  file_kartu_kks: null,
  file_foto_rapot: null
})

const nextStep = () => {
  if (currentStep.value < totalSteps) {
    currentStep.value++
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

const prevStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

const handleFileChange = (e, field) => {
  const file = e.target.files[0]
  if (file) {
    form.value[field] = file
  }
}

const handleSubmit = async () => {
  isSubmitting.value = true
  errorMessage.value = ''

  try {
    const formData = new FormData()
    
    // Append all text fields
    Object.keys(form.value).forEach(key => {
      if (!(form.value[key] instanceof File) && form.value[key] !== null) {
        formData.append(key, form.value[key])
      }
    })

    // Append files
    const fileFields = [
      'foto_3x4', 'file_ijazah', 'file_surat_lulus', 'file_akte_lahir', 
      'file_kk', 'file_kartu_nisn', 'file_kartu_kip', 'file_kartu_pkh', 
      'file_kartu_kks', 'file_foto_rapot'
    ]
    fileFields.forEach(field => {
      if (form.value[field]) {
        formData.append(field, form.value[field])
      }
    })

    await axios.post(`${API_URL}/api/pendaftaran`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
    
    isSubmitted.value = true
    window.scrollTo({ top: 0, behavior: 'smooth' })
  } catch (err) {
    console.error('Submission error:', err)
    errorMessage.value = err.response?.data?.message || 'Gagal mengirim pendaftaran. Silakan coba lagi.'
  } finally {
    isSubmitting.value = false
  }
}

const stepTitles = [
  'Data Pribadi',
  'Alamat Lengkap',
  'Orang Tua & Keluarga',
  'Sekolah & Kesejahteraan',
  'Upload Dokumen'
]
</script>

<template>
  <div class="pt-[140px] pb-20 min-h-screen bg-[#081a24]">
    <div class="container-custom">
      <SectionHeading 
        title="PSB 2026/2027" 
        subtitle="Penerimaan Santri Baru Pondok Modern Al-Hikmah. Silakan lengkapi formulir pendaftaran di bawah ini."
      />

      <!-- Progress Stepper -->
      <div class="max-w-4xl mx-auto mb-12 mt-10">
        <div class="flex items-center justify-between relative px-2">
          <div class="absolute top-1/2 left-0 w-full h-0.5 bg-white/5 -translate-y-1/2 z-0"></div>
          <div 
            class="absolute top-1/2 left-0 h-0.5 bg-secondary -translate-y-1/2 z-0 transition-all duration-500"
            :style="{ width: `${((currentStep - 1) / (totalSteps - 1)) * 100}%` }"
          ></div>
          
          <div v-for="n in totalSteps" :key="n" class="relative z-10 flex flex-col items-center gap-2">
            <div 
              class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300"
              :class="[
                currentStep >= n ? 'bg-secondary border-secondary text-primary' : 'bg-[#081a24] border-white/10 text-white/40',
                currentStep === n ? 'ring-4 ring-secondary/20 scale-110' : ''
              ]"
            >
              <span class="font-bold text-sm">{{ n }}</span>
            </div>
            <span class="hidden md:block text-[10px] uppercase tracking-wider font-bold text-white/40" :class="{'text-secondary': currentStep >= n}">
              {{ stepTitles[n-1] }}
            </span>
          </div>
        </div>
      </div>

      <div class="max-w-5xl mx-auto">
        <div v-if="!isSubmitted" class="glassmorphism p-6 md:p-10 rounded-[32px] shadow-2xl border border-white/10 overflow-hidden" data-aos="fade-up">
          <form @submit.prevent="handleSubmit" class="space-y-8">
            
            <!-- Step 1: Data Pribadi -->
            <div v-if="currentStep === 1" class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-in fade-in slide-in-from-right-4 duration-500">
              <h3 class="md:col-span-2 text-xl font-bold text-secondary flex items-center gap-2 mb-2">
                <User :size="20" /> Data Pribadi Calon Santri
              </h3>
              
              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nama Lengkap (Sesuai Ijazah)</label>
                <input v-model="form.nama_lengkap" type="text" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Masukkan nama lengkap">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Email Aktif</label>
                <input v-model="form.email_pendaftar" type="email" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="contoh@gmail.com">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Tempat Lahir</label>
                <input v-model="form.tempat_lahir" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Kota/Kabupaten">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Tanggal Lahir</label>
                <input v-model="form.tanggal_lahir" type="date" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Jenis Kelamin</label>
                <select v-model="form.jenis_kelamin" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">NISN</label>
                <input v-model="form.nisn" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="10 digit nomor NISN">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">NIK (Sesuai KK)</label>
                <input v-model="form.nik" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="16 digit nomor NIK">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Agama</label>
                <select v-model="form.agama" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
                  <option value="Islam">Islam</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Hobi</label>
                <input v-model="form.hobi" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Olahraga, Membaca, dll">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Cita-cita</label>
                <input v-model="form.cita_cita" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Guru, Dokter, Tentara, dll">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Anak Ke-</label>
                <input v-model="form.anak_ke" type="number" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="1">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Jumlah Saudara Kandung</label>
                <input v-model="form.jumlah_saudara_kandung" type="number" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="0">
              </div>
            </div>

            <!-- Step 2: Alamat -->
            <div v-if="currentStep === 2" class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-in fade-in slide-in-from-right-4 duration-500">
              <h3 class="md:col-span-2 text-xl font-bold text-secondary flex items-center gap-2 mb-2">
                <MapPin :size="20" /> Alamat Tempat Tinggal
              </h3>

              <div class="md:col-span-2 space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Alamat Jalan / Dusun</label>
                <textarea v-model="form.alamat" rows="2" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Jl. Al-Hikmah No. 01..."></textarea>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">RT / RW</label>
                <input v-model="form.rt_rw" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="001/002">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Desa / Kelurahan</label>
                <input v-model="form.desa" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Masukkan Desa">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Kecamatan</label>
                <input v-model="form.kecamatan" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Masukkan Kecamatan">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Kabupaten / Kota</label>
                <input v-model="form.kabupaten" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Masukkan Kabupaten">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Provinsi</label>
                <input v-model="form.provinsi" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Masukkan Provinsi">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Kode Pos</label>
                <input v-model="form.kode_pos" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="12345">
              </div>
            </div>

            <!-- Step 3: Orang Tua -->
            <div v-if="currentStep === 3" class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-in fade-in slide-in-from-right-4 duration-500">
              <h3 class="md:col-span-2 text-xl font-bold text-secondary flex items-center gap-2 mb-2">
                <Users :size="20" /> Data Orang Tua & Keluarga
              </h3>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nomor Kartu Keluarga (KK)</label>
                <input v-model="form.no_kk" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="16 digit No KK">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nama Kepala Keluarga</label>
                <input v-model="form.kepala_keluarga" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="Sesuai KK">
              </div>

              <!-- Ayah -->
              <div class="md:col-span-2 pt-4 border-t border-white/5">
                <h4 class="text-lg font-bold text-white mb-4">Data Ayah</h4>
              </div>
              
              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nama Ayah Kandung</label>
                <input v-model="form.nama_ayah_kandung" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">NIK Ayah</label>
                <input v-model="form.nik_ayah" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Status Ayah</label>
                <select v-model="form.status_ayah" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
                  <option value="Masih Hidup">Masih Hidup</option>
                  <option value="Meninggal">Meninggal</option>
                </select>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Pekerjaan Ayah</label>
                <input v-model="form.pekerjaan_ayah" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <!-- Ibu -->
              <div class="md:col-span-2 pt-6 border-t border-white/5">
                <h4 class="text-lg font-bold text-white mb-4">Data Ibu</h4>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nama Ibu Kandung</label>
                <input v-model="form.nama_ibu_kandung" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">NIK Ibu</label>
                <input v-model="form.nik_ibu" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Pekerjaan Ibu</label>
                <input v-model="form.pekerjaan_ibu" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Penghasilan Orang Tua (Per Bulan)</label>
                <select v-model="form.penghasilan" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
                  <option value="">Pilih Rentang Penghasilan</option>
                  <option value="< 1.000.000">&lt; 1.000.000</option>
                  <option value="1.000.000 - 3.000.000">1.000.000 - 3.000.000</option>
                  <option value="3.000.000 - 5.000.000">3.000.000 - 5.000.000</option>
                  <option value="> 5.000.000">&gt; 5.000.000</option>
                </select>
              </div>
            </div>

            <!-- Step 4: Sekolah & Kesejahteraan -->
            <div v-if="currentStep === 4" class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-in fade-in slide-in-from-right-4 duration-500">
              <h3 class="md:col-span-2 text-xl font-bold text-secondary flex items-center gap-2 mb-2">
                <GraduationCap :size="20" /> Data Sekolah Asal & Kesejahteraan
              </h3>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nama Sekolah Asal</label>
                <input v-model="form.asal_sekolah" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="SD / MI / SMP...">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">NPSN Sekolah Asal</label>
                <input v-model="form.npsn_sekolah" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10" placeholder="8 digit NPSN">
              </div>

              <div class="md:col-span-2 space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Alamat Sekolah</label>
                <input v-model="form.alamat_sekolah" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">No. Surat Keterangan Lulus</label>
                <input v-model="form.no_surat_lulus" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">No. Blangko Ijazah</label>
                <input v-model="form.no_blangko_ijazah" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nilai Rata-rata Ijazah</label>
                <input v-model="form.nilai_rata2_ijazah" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="md:col-span-2 pt-4 border-t border-white/5">
                <h4 class="text-lg font-bold text-white mb-4">Kartu Keluarga Sejahtera (KKS)</h4>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nomor KKS (Opsional)</label>
                <input v-model="form.no_kks" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nomor KIP (Opsional)</label>
                <input v-model="form.no_kip" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-white/60 ml-1">Nomor PKH</label>
                <input v-model="form.no_pkh" type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/10">
              </div>
            </div>

            <!-- Step 5: Upload Dokumen -->
            <div v-if="currentStep === 5" class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-in fade-in slide-in-from-right-4 duration-500">
              <h3 class="md:col-span-2 text-xl font-bold text-secondary flex items-center gap-2 mb-2">
                <Upload :size="20" /> Upload Dokumen Pendukung (Format: JPG/PNG/PDF)
              </h3>

              <div v-for="file in [
                { id: 'foto_3x4', label: 'Pas Foto 3x4 (Terbaru)', icon: Camera },
                { id: 'file_ijazah', label: 'Scan Ijazah (Depan & Belakang)', icon: FileText },
                { id: 'file_surat_lulus', label: 'Scan Surat Keterangan Lulus', icon: FileText },
                { id: 'file_akte_lahir', label: 'Scan Akte Kelahiran', icon: FileText },
                { id: 'file_kk', label: 'Scan Kartu Keluarga', icon: FileText },
                { id: 'file_foto_rapot', label: 'Scan Rapor Terakhir', icon: FileText },
              ]" :key="file.id" class="space-y-3">
                <label class="text-sm font-medium text-white/80 ml-1 flex items-center gap-2">
                  <component :is="file.icon" :size="16" class="text-secondary" /> {{ file.label }}
                </label>
                <div class="relative group">
                  <input 
                    type="file" 
                    @change="(e) => handleFileChange(e, file.id)"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                    accept=".jpg,.jpeg,.png,.pdf"
                  >
                  <div class="w-full bg-white/5 border-2 border-dashed border-white/10 rounded-2xl px-6 py-8 text-center transition-all group-hover:border-secondary/40 group-hover:bg-secondary/5">
                    <Upload :size="24" class="mx-auto text-white/20 mb-2 group-hover:text-secondary/60 transition-colors" />
                    <span class="text-sm" :class="form[file.id] ? 'text-secondary font-bold' : 'text-white/40'">
                      {{ form[file.id] ? form[file.id].name : 'Pilih file atau drag & drop' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Error Message -->
            <div v-if="errorMessage" class="p-4 bg-red-500/20 border border-red-500/50 rounded-2xl text-red-200 text-sm">
              {{ errorMessage }}
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-white/10">
              <BaseButton 
                v-if="currentStep > 1"
                type="button" 
                variant="outline" 
                @click="prevStep"
                class="px-8 py-4 !rounded-2xl font-bold flex items-center gap-2"
              >
                <ChevronLeft :size="20" /> Kembali
              </BaseButton>
              <div v-else></div>

              <BaseButton 
                v-if="currentStep < totalSteps"
                type="button" 
                variant="secondary" 
                @click="nextStep"
                class="px-10 py-4 !rounded-2xl font-bold flex items-center gap-2 !bg-secondary !text-primary"
              >
                Selanjutnya <ChevronRight :size="20" />
              </BaseButton>

              <BaseButton 
                v-else
                type="submit" 
                variant="primary" 
                :disabled="isSubmitting"
                class="px-12 py-4 !rounded-2xl font-bold flex items-center gap-2 !bg-secondary !text-primary shadow-lg shadow-secondary/20"
              >
                <span v-if="isSubmitting">Mengirim...</span>
                <span v-else class="flex items-center gap-2">Kirim Pendaftaran <Send :size="20" /></span>
              </BaseButton>
            </div>
          </form>
        </div>

        <!-- Success State -->
        <div v-else class="glassmorphism p-12 rounded-[40px] text-center shadow-2xl border border-secondary/20 bg-secondary/5" data-aos="zoom-in">
          <div class="inline-flex items-center justify-center p-6 bg-secondary/20 rounded-full mb-8">
            <CheckCircle :size="64" class="text-secondary" />
          </div>
          <h3 class="text-3xl font-bold text-white mb-4">Pendaftaran Berhasil!</h3>
          <p class="text-white/70 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
            Terima kasih telah mendaftar di Pondok Modern Al-Hikmah. Data Ananda **{{ form.nama_lengkap }}** telah kami terima. Mohon simpan bukti pendaftaran ini dan tunggu konfirmasi selanjutnya dari panitia.
          </p>
          <div class="flex flex-col md:flex-row items-center justify-center gap-4">
            <router-link to="/">
              <BaseButton variant="secondary" outline class="px-10 py-4 !rounded-2xl font-bold"> Kembali ke Beranda </BaseButton>
            </router-link>
            <BaseButton variant="secondary" class="px-10 py-4 !rounded-2xl font-bold !bg-secondary !text-primary"> Cetak Bukti Pendaftaran </BaseButton>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Custom style for select arrow */
select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='rgba(255,255,255,0.3)'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 1.5rem center;
  background-size: 1.2rem;
}

/* Transitions */
.animate-in {
  animation: animate-in 0.5s ease-out;
}

@keyframes animate-in {
  from {
    opacity: 0;
    transform: translateX(10px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
</style>
