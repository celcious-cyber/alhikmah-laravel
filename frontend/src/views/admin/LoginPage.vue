<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { Lock, User, Eye, EyeOff } from 'lucide-vue-next'

const router = useRouter()
const username = ref('')
const password = ref('')
const showPassword = ref(false)
const loading = ref(false)
const error = ref('')

const API_URL = import.meta.env.VITE_API_URL || ''

const login = async () => {
  if (!username.value || !password.value) {
    error.value = 'Username dan password wajib diisi.'
    return
  }
  loading.value = true
  error.value = ''
  try {
    const res = await axios.post(`${API_URL}/api/auth/login`, {
      username: username.value,
      password: password.value
    })
    localStorage.setItem('admin_token', res.data.token)
    localStorage.setItem('admin_user', JSON.stringify(res.data.admin))
    router.push('/admin/dashboard')
  } catch (err) {
    error.value = err.response?.data?.message || 'Terjadi kesalahan. Coba lagi.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen bg-[#0f172a] flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-1/4 -left-40 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl"></div>
      <div class="absolute bottom-1/4 -right-40 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
      <!-- Card -->
      <div class="bg-[#1e293b] border border-white/10 rounded-2xl p-8 shadow-2xl">
        <!-- Logo -->
        <div class="text-center mb-8">
          <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-500/30">
            <span class="text-black font-black text-2xl">H</span>
          </div>
          <h1 class="text-xl font-bold text-white">Pondok Modern Al-Hikmah</h1>
          <p class="text-white/40 text-sm mt-1">Masuk ke Panel Admin</p>
        </div>

        <!-- Error Alert -->
        <div v-if="error" class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-lg">
          <p class="text-red-400 text-sm">{{ error }}</p>
        </div>

        <!-- Form -->
        <form @submit.prevent="login" class="space-y-4">
          <!-- Username -->
          <div>
            <label class="block text-sm text-white/60 mb-1.5 font-medium">Username</label>
            <div class="relative">
              <User :size="16" class="absolute left-3 top-1/2 -translate-y-1/2 text-white/30" />
              <input
                v-model="username"
                type="text"
                placeholder="Masukkan username"
                class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-white/25 focus:outline-none focus:border-amber-500/50 focus:bg-white/8 transition-all"
              />
            </div>
          </div>

          <!-- Password -->
          <div>
            <label class="block text-sm text-white/60 mb-1.5 font-medium">Password</label>
            <div class="relative">
              <Lock :size="16" class="absolute left-3 top-1/2 -translate-y-1/2 text-white/30" />
              <input
                v-model="password"
                :type="showPassword ? 'text' : 'password'"
                placeholder="Masukkan password"
                class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-10 py-3 text-sm text-white placeholder-white/25 focus:outline-none focus:border-amber-500/50 transition-all"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-white/30 hover:text-white/60 transition-colors"
              >
                <Eye v-if="!showPassword" :size="16" />
                <EyeOff v-else :size="16" />
              </button>
            </div>
          </div>

          <!-- Submit -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full bg-amber-500 hover:bg-amber-400 text-black font-bold py-3 rounded-xl transition-all duration-200 shadow-lg shadow-amber-500/20 disabled:opacity-60 disabled:cursor-not-allowed mt-2"
          >
            <span v-if="loading">Memproses...</span>
            <span v-else>Masuk</span>
          </button>
        </form>

        <!-- Default credentials hint -->
        <p class="text-center text-xs text-white/25 mt-6">
          Default: admin / alhikmah2024
        </p>
      </div>
    </div>
  </div>
</template>
