<script setup>
import { ref } from 'vue'
import SectionHeading from '../components/ui/SectionHeading.vue'
import BaseButton from '../components/ui/BaseButton.vue'
import { User, Mail, Phone, BookOpen, MapPin, Send, CheckCircle } from 'lucide-vue-next'

const form = ref({
  fullName: '',
  email: '',
  phone: '',
  program: '',
  address: '',
  message: ''
})

const isSubmitted = ref(false)

const programs = [
  'KMI (Pondok Modern)',
  'SMP Al-Hikmah',
  'MA Al-Hikmah'
]

const handleSubmit = () => {
  // Simulate submission
  console.log('Form submitted:', form.value)
  isSubmitted.value = true
}
</script>

<template>
  <div class="pt-[188px] pb-20 min-h-screen">
    <div class="container-custom">
      <SectionHeading 
        title="Pendaftaran Santri Baru" 
        subtitle="Mulai perjalanan spiritual dan intelektual Anda bersama Pondok Modern Al-Hikmah. Silakan isi formulir di bawah ini."
      />

      <div class="max-w-4xl mx-auto mt-12">
        <div v-if="!isSubmitted" class="glassmorphism p-8 md:p-12 rounded-[40px] shadow-2xl border border-white/10" data-aos="fade-up">
          <form @submit.prevent="handleSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Full Name -->
            <div class="space-y-3">
              <label class="flex items-center gap-2 text-white/80 font-medium ml-1">
                <User :size="18" class="text-secondary" /> Nama Lengkap Calon Santri
              </label>
              <input 
                v-model="form.fullName"
                type="text" 
                required
                placeholder="Contoh: Muhammad Akmal"
                class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/20"
              />
            </div>

            <!-- Email -->
            <div class="space-y-3">
              <label class="flex items-center gap-2 text-white/80 font-medium ml-1">
                <Mail :size="18" class="text-secondary" /> Alamat Email Wali
              </label>
              <input 
                v-model="form.email"
                type="email" 
                required
                placeholder="email@contoh.com"
                class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/20"
              />
            </div>

            <!-- Phone -->
            <div class="space-y-3">
              <label class="flex items-center gap-2 text-white/80 font-medium ml-1">
                <Phone :size="18" class="text-secondary" /> Nomor WhatsApp Aktif
              </label>
              <input 
                v-model="form.phone"
                type="tel" 
                required
                placeholder="0812xxxxxxx"
                class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/20"
              />
            </div>

            <!-- Program Selection -->
            <div class="space-y-3">
              <label class="flex items-center gap-2 text-white/80 font-medium ml-1">
                <BookOpen :size="18" class="text-secondary" /> Jenjang Pendidikan
              </label>
              <select 
                v-model="form.program"
                required
                class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all appearance-none"
              >
                <option value="" disabled selected class="bg-[#081a24]">Pilih Program</option>
                <option v-for="p in programs" :key="p" :value="p" class="bg-[#081a24]">{{ p }}</option>
              </select>
            </div>

            <!-- Address -->
            <div class="md:col-span-2 space-y-3">
              <label class="flex items-center gap-2 text-white/80 font-medium ml-1">
                <MapPin :size="18" class="text-secondary" /> Alamat Lengkap
              </label>
              <textarea 
                v-model="form.address"
                rows="3" 
                required
                placeholder="Masukkan alamat lengkap sesuai KTP..."
                class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-secondary/50 focus:ring-4 focus:ring-secondary/10 outline-none transition-all placeholder:text-white/20"
              ></textarea>
            </div>

            <!-- Submit Button -->
            <div class="md:col-span-2 pt-4">
              <BaseButton type="submit" variant="primary" class="w-full py-5 !rounded-2xl text-lg font-bold !bg-secondary !text-primary flex items-center justify-center gap-3 group shadow-xl shadow-secondary/10">
                Kirim Formulir Pendaftaran <Send :size="20" class="group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
              </BaseButton>
            </div>
          </form>

          <p class="text-center text-white/40 text-sm mt-8">
            * Tim admin kami akan menghubungi Anda melalui WhatsApp dalam waktu 1x24 jam setelah formulir dikirim.
          </p>
        </div>

        <!-- Success State -->
        <div v-else class="glassmorphism p-12 rounded-[40px] text-center shadow-2xl border border-secondary/20 bg-secondary/5" data-aos="zoom-in">
          <div class="inline-flex items-center justify-center p-6 bg-secondary/20 rounded-full mb-8">
            <CheckCircle :size="64" class="text-secondary" />
          </div>
          <h3 class="text-3xl font-bold text-white mb-4">Pendaftaran Terkirim!</h3>
          <p class="text-white/70 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
            Terima kasih telah mendaftar. Data santri **{{ form.fullName }}** telah masuk ke sistem kami. Mohon simpan nomor WhatsApp Anda tetap aktif untuk koordinasi selanjutnya.
          </p>
          <router-link to="/">
            <BaseButton variant="secondary" outline class="px-10 py-4 !rounded-2xl font-bold"> Kembali ke Beranda </BaseButton>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Custom style for select arrow */
select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 1.5rem center;
  background-size: 1.5rem;
}
</style>
