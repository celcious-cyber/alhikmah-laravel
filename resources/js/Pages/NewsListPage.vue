<script setup>
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import SectionHeading from '../components/ui/SectionHeading.vue'
import { Calendar, ArrowRight, Newspaper } from 'lucide-vue-next'
import NewsLayout from '../components/layout/NewsLayout.vue'

defineOptions({ layout: NewsLayout })

const API_URL = import.meta.env.VITE_API_URL || ''
const headline = ref(null)
const newsList = ref([])
const popularNews = ref([])
const categoriesList = ref([])
const loading = ref(true)

const fetchNews = async () => {
  loading.value = true
  try {
    const [newsRes, popularRes, catRes] = await Promise.all([
      axios.get(`${API_URL}/api/news`),
      axios.get(`${API_URL}/api/news/popular`),
      axios.get(`${API_URL}/api/categories`)
    ])
    headline.value = newsRes.data.headline
    newsList.value = newsRes.data.list
    popularNews.value = popularRes.data
    categoriesList.value = catRes.data
  } catch (err) {
    console.error('Gagal mengambil berita:', err)
  } finally {
    loading.value = false
  }
}

// formatDate is removed as it is now handled by the backend

onMounted(fetchNews)
</script>

<template>
  <div class="pb-20 min-h-screen">
    <Head>
      <title>Warta & Kabar | Al-Hikmah</title>
      <meta name="description" content="Informasi terbaru, pengumuman, dan prestasi santri di lingkungan Pondok Modern Al-Hikmah.">
    </Head>
    <div class="container-custom">
      <SectionHeading 
        title="Warta & Kabar Al-Hikmah" 
        subtitle="Informasi terbaru, pengumuman, dan prestasi santri di lingkungan Pondok Modern Al-Hikmah."
        :darkText="true"
      />

      <div v-if="loading" class="flex flex-col items-center justify-center py-20">
        <div class="animate-spin w-12 h-12 border-4 border-primary border-t-transparent rounded-full mb-4"></div>
        <p class="text-slate-500 font-medium tracking-widest uppercase text-xs">Memuat Berita...</p>
      </div>

      <div v-else-if="!headline && newsList.length === 0" class="flex flex-col items-center justify-center py-20 bg-slate-50 rounded-[40px] border border-slate-200">
        <Newspaper :size="64" class="text-slate-300 mb-6" />
        <h3 class="text-2xl font-bold text-slate-900 mb-2">Belum Ada Berita</h3>
        <p class="text-slate-500">Nantikan informasi menarik dari kami segera.</p>
        <router-link to="/" class="mt-8 px-8 py-3 bg-primary text-white font-bold rounded-2xl hover:scale-105 transition-transform">
          Kembali ke Beranda
        </router-link>
      </div>

      <div v-else class="flex flex-col gap-12 mt-8">
        <!-- Hero Article (Headline) -->
        <div v-if="headline" class="group grid grid-cols-1 lg:grid-cols-12 gap-8 items-center border-b border-slate-200 pb-12" data-aos="fade-up">
          <div class="lg:col-span-8 relative aspect-video md:aspect-[21/9] overflow-hidden rounded-2xl shadow-lg">
            <img 
              :src="headline.thumbnail ? (headline.thumbnail.startsWith('http') ? headline.thumbnail : `/storage/${headline.thumbnail}`) : 'https://placehold.co/1200x600/154D6E/FFFFFF?text=Berita+Utama'"
              :alt="headline.title"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            />
          </div>
          <div class="lg:col-span-4 flex flex-col justify-center">
            <div class="flex items-center flex-wrap gap-3 text-primary text-xs font-bold tracking-widest uppercase mb-4">
              <div class="flex items-center gap-1.5">
                <Calendar :size="14" />
                <span>{{ headline.formatted_date }}</span>
              </div>
              <div v-if="headline.categories?.length" class="flex gap-2">
                <span 
                  v-for="cat in headline.categories" 
                  :key="cat.id" 
                  class="bg-primary/10 text-primary px-2 py-0.5 rounded-full text-[10px]"
                  :style="cat.color ? { backgroundColor: cat.color + '20', color: cat.color } : {}"
                >
                  {{ cat.name }}
                </span>
              </div>
            </div>
            <h2 class="text-2xl md:text-4xl lg:text-5xl font-black text-slate-900 mb-4 md:mb-6 leading-[1.15] group-hover:text-primary transition-colors duration-300 font-serif">
              <router-link :to="`/berita/${headline.slug}`">{{ headline.title }}</router-link>
            </h2>
            <p class="text-slate-600 text-base md:text-lg leading-relaxed line-clamp-3 md:line-clamp-4 mb-6 md:mb-8">
              {{ headline.excerpt }}
            </p>
            <router-link 
              :to="`/berita/${headline.slug}`" 
              class="inline-flex items-center gap-3 text-primary font-bold hover:gap-5 transition-all uppercase tracking-wider group/link"
            >
              Baca Laporan Utama <ArrowRight :size="18" class="group-hover/link:translate-x-1 transition-transform" />
            </router-link>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
          <!-- Main Content (List) -->
          <div class="lg:col-span-8 flex flex-col gap-8">
            <div class="flex items-center gap-4 mb-2">
              <h3 class="text-2xl font-bold text-slate-900 border-l-4 border-primary pl-4 uppercase tracking-widest font-serif">Berita Terbaru</h3>
              <div class="flex-grow h-px bg-slate-200"></div>
            </div>
            
            <div 
              v-for="(item, index) in newsList" 
              :key="item.id"
              class="group grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-start border-b border-slate-200 pb-8"
              data-aos="fade-up"
              :data-aos-delay="index * 50"
            >
              <div class="md:col-span-4 relative aspect-[4/3] md:aspect-square lg:aspect-[4/3] overflow-hidden rounded-lg shadow-md">
                <img 
                  :src="item.thumbnail ? (item.thumbnail.startsWith('http') ? item.thumbnail : `/storage/${item.thumbnail}`) : 'https://placehold.co/800x600/154D6E/FFFFFF?text=Berita'" 
                  :alt="item.title"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
              </div>
              <div class="md:col-span-8 flex flex-col pt-1">
                <div class="flex items-center flex-wrap gap-3 text-primary text-[10px] font-bold tracking-widest uppercase mb-3">
                  <div class="flex items-center gap-1.5">
                    <Calendar :size="12" />
                    <span>{{ item.formatted_date }}</span>
                  </div>
                  <div v-if="item.categories?.length" class="flex gap-2">
                    <span 
                      v-for="cat in item.categories" 
                      :key="cat.id" 
                      class="bg-primary/10 text-primary px-2 py-0.5 rounded-full text-[9px]"
                      :style="cat.color ? { backgroundColor: cat.color + '20', color: cat.color } : {}"
                    >
                      {{ cat.name }}
                    </span>
                  </div>
                </div>
                <h4 class="text-xl md:text-2xl font-bold text-slate-900 mb-3 leading-tight group-hover:text-primary transition-colors duration-300 font-serif">
                  <router-link :to="`/berita/${item.slug}`">{{ item.title }}</router-link>
                </h4>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed line-clamp-2 md:line-clamp-3 mb-4">
                  {{ item.excerpt }}
                </p>
              </div>
            </div>
          </div>

          <!-- Sidebar (Trending / Kategori) -->
          <div class="lg:col-span-4 flex flex-col gap-8">
            <div class="bg-white rounded-3xl p-8 border border-slate-200 sticky top-32 shadow-sm">
              <h3 class="text-xl font-bold text-slate-900 mb-8 uppercase tracking-wider border-b border-slate-200 pb-4 font-serif text-center relative">
                Topik Populer
                <div class="absolute bottom-[-1px] left-1/2 -translate-x-1/2 w-12 h-0.5 bg-primary"></div>
              </h3>
              
              <div class="flex flex-col gap-8">
                <div 
                  v-for="(item, index) in popularNews" 
                  :key="item.id + '-trend'"
                  class="group flex gap-5 items-start"
                >
                  <span class="text-5xl font-extrabold text-slate-200 font-serif leading-none mt-1 group-hover:text-primary/30 transition-colors">{{ index + 1 }}</span>
                  <div>
                    <h5 class="text-lg font-bold text-slate-900 mb-2 leading-snug group-hover:text-primary transition-colors duration-300 font-serif">
                      <router-link :to="`/berita/${item.slug}`">{{ item.title }}</router-link>
                    </h5>
                    <span class="text-primary/70 text-xs font-bold tracking-wider uppercase">{{ item.formatted_date }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Categories Widget -->
            <div v-if="categoriesList.length > 0" class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm mt-8">
              <h3 class="text-xl font-bold text-slate-900 mb-8 uppercase tracking-wider border-b border-slate-200 pb-4 font-serif text-center relative">
                Kategori Berita
                <div class="absolute bottom-[-1px] left-1/2 -translate-x-1/2 w-12 h-0.5 bg-primary"></div>
              </h3>
              
              <div class="flex flex-wrap gap-3">
                <router-link 
                  to="/berita"
                  v-for="cat in categoriesList" 
                  :key="'widget-' + cat.id"
                  class="bg-slate-50 text-slate-700 hover:text-white px-4 py-2 rounded-full text-sm font-bold tracking-wider uppercase border border-slate-200 hover:border-transparent transition-all duration-300 shadow-sm hover:shadow-md"
                  :style="cat.color ? { '--hover-bg': cat.color } : { '--hover-bg': '#154D6E' }"
                  onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--hover-bg'); this.style.color='#fff'"
                  onmouseout="this.style.backgroundColor=''; this.style.color=''"
                >
                  {{ cat.name }}
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.glassmorphism {
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}
</style>
