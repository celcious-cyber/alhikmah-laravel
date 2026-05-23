<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import { Calendar, ArrowLeft, Share2, Facebook, Twitter, MessageCircle, User, Heart, Eye } from 'lucide-vue-next'
import NewsLayout from '../components/layout/NewsLayout.vue'

defineOptions({ layout: NewsLayout })

const route = useRoute()
const router = useRouter()
const API_URL = import.meta.env.VITE_API_URL || ''

const item = ref(null)
const loading = ref(true)
const error = ref(null)

// Comment form
const commentForm = ref({ name: '', email: '', content: '' })
const submittingComment = ref(false)
const commentError = ref('')
const commentSuccess = ref(false)

// updateMetaTags is removed in favor of <Head> component from Inertia

const fetchDetail = async () => {
  loading.value = true
  try {
    const res = await axios.get(`${API_URL}/api/news/slug/${route.params.slug}`)
    item.value = res.data
  } catch (err) {
    console.error('Gagal mengambil detail berita:', err)
    error.value = err.response?.data?.message || 'Gagal mengambil detail berita.'
  } finally {
    loading.value = false
  }
}

// formatDate is removed as it is now handled by the backend

const formattedContent = computed(() => {
  if (!item.value?.content) return ''
  if (!item.value.content.includes('<p>')) {
    return item.value.content.split('\n').filter(p => p.trim() !== '').map(p => `<p class="mb-6">${p}</p>`).join('')
  }
  return item.value.content
})

const shareUrl = window.location.href

const formatNumber = (num) => {
  if (!num) return '0'
  if (num >= 1000) {
    return (num / 1000).toFixed(1) + 'k'
  }
  return num.toString()
}

const handleShare = async (platform) => {
  if (!item.value) return
  try {
    const res = await axios.post(`${API_URL}/api/news/${item.value.id}/share`)
    if (res.data.shares_count !== undefined) {
      item.value.shares_count = res.data.shares_count
    }
  } catch (err) {
    console.error('Failed to increment share count', err)
  }
  
  let url = ''
  if (platform === 'facebook') url = `https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`
  if (platform === 'twitter') url = `https://twitter.com/intent/tweet?url=${shareUrl}&text=${item.value.title}`
  if (platform === 'whatsapp') url = `https://wa.me/?text=${item.value.title}%20${shareUrl}`
  
  if (url) window.open(url, '_blank')
}

const submitComment = async () => {
  if (!commentForm.value.name || !commentForm.value.content) {
    commentError.value = 'Nama dan isi komentar wajib diisi.'
    return
  }
  
  submittingComment.value = true
  commentError.value = ''
  commentSuccess.value = false
  
  try {
    const res = await axios.post(`${API_URL}/api/news/${item.value.id}/comment`, commentForm.value)
    
    // Add new comment to the list
    if (!item.value.comments) item.value.comments = []
    item.value.comments.unshift(res.data)
    
    // Reset form
    commentForm.value = { name: '', email: '', content: '' }
    commentSuccess.value = true
    
    setTimeout(() => { commentSuccess.value = false }, 5000)
  } catch (err) {
    console.error('Gagal mengirim komentar:', err)
    commentError.value = err.response?.data?.message || 'Gagal mengirim komentar.'
  } finally {
    submittingComment.value = false
  }
}

onMounted(fetchDetail)
</script>

<template>
  <div class="pb-20 min-h-screen">
    <Head v-if="item">
      <title>{{ item.title }} | Al-Hikmah</title>
      <meta name="description" :content="item.excerpt">
      <meta property="og:title" :content="item.title">
      <meta property="og:description" :content="item.excerpt">
      <meta property="og:image" :content="item.thumbnail ? (item.thumbnail.startsWith('http') ? item.thumbnail : `https://alhikmahutan.ponpes.id${item.thumbnail}`) : 'https://alhikmahutan.ponpes.id/og-image.jpg'">
      <meta property="og:url" :content="shareUrl">
      <meta name="twitter:title" :content="item.title">
      <meta name="twitter:description" :content="item.excerpt">
      <meta name="twitter:image" :content="item.thumbnail ? (item.thumbnail.startsWith('http') ? item.thumbnail : `https://alhikmahutan.ponpes.id${item.thumbnail}`) : 'https://alhikmahutan.ponpes.id/og-image.jpg'">
    </Head>

    <div class="container-custom">
      <!-- Back Button (Loading/Error State) -->
      <button 
        v-if="!item"
        @click="router.back()"
        class="flex items-center gap-2 text-primary font-bold mb-12 hover:-translate-x-2 transition-transform"
      >
        <ArrowLeft :size="20" />
        KEMBALI KE DAFTAR BERITA
      </button>

      <div v-if="loading" class="flex flex-col items-center justify-center py-20">
        <div class="animate-spin w-12 h-12 border-4 border-primary border-t-transparent rounded-full mb-4"></div>
        <p class="text-slate-500 font-medium tracking-widest uppercase text-xs">Memuat Artikel...</p>
      </div>

      <div v-else-if="error" class="text-center py-20 bg-slate-50 rounded-[40px] border border-slate-200">
        <h3 class="text-2xl font-bold text-slate-900 mb-2">Oops!</h3>
        <p class="text-slate-500">{{ error }}</p>
        <router-link to="/berita" class="mt-8 inline-block px-8 py-3 bg-primary text-white font-bold rounded-2xl">
          Kembali ke Daftar Berita
        </router-link>
      </div>

      <article v-else class="max-w-4xl mx-auto pt-4 md:pt-0">
        <!-- Header -->
        <header class="mb-12">
          <div class="flex flex-row items-center justify-between mb-8" data-aos="fade-up">
            <!-- Back Button -->
            <button 
              @click="router.back()"
              class="flex items-center gap-2 text-primary font-bold text-sm md:text-base hover:-translate-x-2 transition-transform"
            >
              <ArrowLeft :size="20" class="shrink-0" />
              <span class="hidden md:inline">KEMBALI KE DAFTAR BERITA</span>
              <span class="md:hidden">KEMBALI</span>
            </button>

            <!-- Date -->
            <div class="flex items-center gap-2 md:gap-3 text-primary text-[10px] md:text-xs font-bold tracking-widest uppercase text-right">
              <Calendar :size="16" class="shrink-0" />
              <span>{{ item.formatted_date }}</span>
            </div>
          </div>
          
          <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-slate-900 mb-10 leading-[1.15] font-serif" data-aos="fade-up" data-aos-delay="100">
            {{ item.title }}
          </h1>

          <!-- Featured Image -->
          <div class="aspect-[16/9] rounded-[20px] overflow-hidden border border-slate-200 shadow-xl mb-8" data-aos="zoom-in" data-aos-delay="200">
            <img 
              :src="item.thumbnail ? (item.thumbnail.startsWith('http') ? item.thumbnail : `/storage/${item.thumbnail}`) : 'https://placehold.co/1200x800/154D6E/FFFFFF?text=Berita+Al-Hikmah'" 
              :alt="item.title"
              class="w-full h-full object-cover"
            />
          </div>

          <!-- Author Info & Stats -->
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 border-b border-slate-200 mb-8" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center gap-4" v-if="item.author">
              <img :src="item.author.avatar_url ? `/storage/${item.author.avatar_url}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(item.author.name)}&background=154D6E&color=fff`" :alt="item.author.name" class="w-14 h-14 rounded-full border-2 border-white shadow-md shrink-0 object-cover">
              <div>
                <p class="text-slate-900 font-bold md:text-lg leading-tight mb-1">{{ item.author.name }}</p>
                <p class="text-xs md:text-sm text-slate-500">{{ item.author.title || 'Tim Redaksi Al-Hikmah' }}</p>
              </div>
            </div>
            <div class="flex items-center gap-4" v-else>
              <img src="https://ui-avatars.com/api/?name=Admin+Pondok&background=154D6E&color=fff" alt="Admin Pondok" class="w-14 h-14 rounded-full border-2 border-white shadow-md shrink-0">
              <div>
                <p class="text-slate-900 font-bold md:text-lg leading-tight mb-1">Redaksi Al-Hikmah</p>
              </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
              <div v-if="item.categories?.length" class="flex gap-2">
                <span 
                  v-for="cat in item.categories" 
                  :key="cat.id" 
                  class="bg-primary/10 text-primary px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border border-primary/20"
                  :style="cat.color ? { backgroundColor: cat.color + '20', color: cat.color, borderColor: cat.color + '40' } : {}"
                >
                  {{ cat.name }}
                </span>
              </div>
              <div class="flex items-center gap-1.5 text-slate-600 text-xs font-bold bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200">
                <Calendar :size="14" class="text-primary" />
                <span>{{ item.formatted_date }}</span>
              </div>
              <div class="flex items-center gap-1.5 text-slate-600 text-xs font-bold bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200" title="Jumlah Dilihat">
                <Eye :size="14" class="text-primary" />
                <span>{{ formatNumber(item.views_count) }}</span>
              </div>
              <div class="flex items-center gap-1.5 text-slate-600 text-xs font-bold bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200" title="Jumlah Komentar">
                <MessageCircle :size="14" class="text-primary" />
                <span>{{ formatNumber(item.comments?.length || 0) }}</span>
              </div>
              <div class="flex items-center gap-1.5 text-slate-600 text-xs font-bold bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200" title="Jumlah Dibagikan">
                <Share2 :size="14" class="text-primary" />
                <span>{{ formatNumber(item.shares_count) }}</span>
              </div>
            </div>
          </div>
        </header>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
          <!-- Main Content -->
          <div class="lg:col-span-8">
            <div 
              class="prose prose-slate max-w-none text-slate-800 text-lg leading-relaxed article-content mb-12 border-b border-slate-200 pb-12"
              v-html="formattedContent"
              data-aos="fade-up"
            ></div>

            <!-- Author Bio at bottom -->
            <div v-if="item.author" class="bg-primary/5 border border-primary/10 rounded-2xl p-6 mb-12 flex items-start gap-4 md:gap-6" data-aos="fade-up">
              <img :src="item.author.avatar_url ? `/storage/${item.author.avatar_url}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(item.author.name)}&background=154D6E&color=fff&size=128`" :alt="item.author.name" class="w-16 h-16 md:w-20 md:h-20 rounded-full border-4 border-white shadow-md shrink-0 object-cover">
              <div>
                <h4 class="text-slate-900 font-bold text-lg md:text-xl mb-1">{{ item.author.name }}</h4>
                <p class="text-primary font-medium text-sm md:text-base mb-3">{{ item.author.title || 'Penulis Al-Hikmah' }}</p>
                <p v-if="item.author.bio" class="text-slate-600 text-sm md:text-base leading-relaxed">{{ item.author.bio }}</p>
              </div>
            </div>

            <!-- Mobile Sharing -->
            <div class="lg:hidden flex flex-col items-center justify-center py-6 mb-12" data-aos="fade-up">
              <h5 class="text-slate-900 font-bold mb-6 uppercase tracking-widest text-sm font-serif">
                Bagikan Artikel
              </h5>
              <div class="flex items-center gap-6">
                <button @click="handleShare('facebook')" class="w-14 h-14 flex items-center justify-center rounded-full bg-[#1877F2]/10 text-[#1877F2] hover:bg-[#1877F2] hover:text-white transition-all" title="Bagikan ke Facebook">
                  <Facebook :size="24" />
                </button>
                <button @click="handleShare('twitter')" class="w-14 h-14 flex items-center justify-center rounded-full bg-[#1DA1F2]/10 text-[#1DA1F2] hover:bg-[#1DA1F2] hover:text-white transition-all" title="Bagikan ke X (Twitter)">
                  <Twitter :size="24" />
                </button>
                <button @click="handleShare('whatsapp')" class="w-14 h-14 flex items-center justify-center rounded-full bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all" title="Bagikan ke WhatsApp">
                  <MessageCircle :size="24" />
                </button>
              </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-slate-50 p-6 md:p-8 rounded-[32px] border border-slate-200" data-aos="fade-up">
              <h3 class="text-2xl font-bold text-slate-900 mb-6 font-serif">Komentar ({{ item.comments?.length || 0 }})</h3>
              
              <form @submit.prevent="submitComment" class="mb-10">
                <div v-if="commentSuccess" class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl">
                  Komentar Anda berhasil dikirim!
                </div>
                <div v-if="commentError" class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl">
                  {{ commentError }}
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                  <input v-model="commentForm.name" type="text" placeholder="Nama Anda" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" required>
                  <input v-model="commentForm.email" type="email" placeholder="Email (Opsional)" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                </div>
                <textarea v-model="commentForm.content" rows="4" placeholder="Tulis komentar Anda..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all mb-4 resize-none" required></textarea>
                <button type="submit" :disabled="submittingComment" class="px-8 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors disabled:opacity-50">
                  {{ submittingComment ? 'Mengirim...' : 'Kirim Komentar' }}
                </button>
              </form>

              <!-- Comments List -->
              <div v-if="item.comments && item.comments.length > 0" class="space-y-6">
                <div v-for="comment in item.comments" :key="comment.id" class="flex gap-4">
                  <div class="w-12 h-12 bg-slate-200 rounded-full flex items-center justify-center text-slate-500 font-bold shrink-0 uppercase">
                    {{ comment.name.substring(0, 2) }}
                  </div>
                  <div>
                    <div class="flex items-center gap-3 mb-1">
                      <h4 class="font-bold text-slate-900">{{ comment.name }}</h4>
                      <span class="text-xs text-slate-400">{{ comment.formatted_date }}</span>
                    </div>
                    <p class="text-slate-600">{{ comment.content }}</p>
                  </div>
                </div>
              </div>

              <!-- Empty Comments Mock -->
              <div v-else class="text-center py-8">
                <MessageCircle :size="48" class="mx-auto text-slate-300 mb-4" />
                <p class="text-slate-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
              </div>
            </div>
          </div>

          <!-- Sidebar / Sharing -->
          <div class="lg:col-span-4 space-y-10 hidden lg:block">
            <div class="bg-slate-50 p-8 rounded-[32px] border border-slate-200 sticky top-32">
              <h5 class="text-slate-900 font-bold mb-6 flex items-center gap-2">
                <Share2 :size="18" class="text-primary" />
                BAGIKAN ARTIKEL
              </h5>
              <div class="flex items-center gap-4">
                <button @click="handleShare('facebook')" class="w-12 h-12 flex items-center justify-center rounded-full bg-[#1877F2]/10 text-[#1877F2] hover:bg-[#1877F2] hover:text-white transition-all" title="Bagikan ke Facebook">
                  <Facebook :size="20" />
                </button>
                <button @click="handleShare('twitter')" class="w-12 h-12 flex items-center justify-center rounded-full bg-[#1DA1F2]/10 text-[#1DA1F2] hover:bg-[#1DA1F2] hover:text-white transition-all" title="Bagikan ke X (Twitter)">
                  <Twitter :size="20" />
                </button>
                <button @click="handleShare('whatsapp')" class="w-12 h-12 flex items-center justify-center rounded-full bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all" title="Bagikan ke WhatsApp">
                  <MessageCircle :size="20" />
                </button>
              </div>

              <div class="mt-10 pt-10 border-t border-slate-200">
                <p class="text-xs text-slate-500 font-medium leading-relaxed italic">
                  "Sampaikanlah walau satu ayat." Mari sebarkan kebaikan melalui informasi yang bermanfaat.
                </p>
              </div>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</template>

<style>
.article-content p {
  margin-bottom: 1.5rem;
}
.article-content strong {
  color: #0f172a; /* slate-900 */
}
</style>
