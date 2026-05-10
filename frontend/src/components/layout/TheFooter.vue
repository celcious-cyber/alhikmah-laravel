<script setup>
import { Instagram, Facebook, Youtube, Send } from 'lucide-vue-next'

const quickLinks = [
  { name: 'Beranda', href: '#hero' },
  { name: 'Tentang', href: '#about' },
  { name: 'Program', href: '#program' },
  { name: 'Fasilitas', href: '#fasilitas' },
  { name: 'Galeri', href: '#galeri' },
  { name: 'Pendaftaran', href: '#cta' },
]

const socialMedia = [
  { icon: Instagram, href: '#' },
  { icon: Facebook, href: '#' },
  { icon: Youtube, href: '#' },
]
</script>

<template>
  <footer class="bg-black/40 backdrop-blur-sm text-white pt-20 pb-10">
    <div class="container-custom grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
      <!-- About -->
      <div class="space-y-6">
        <h3 class="text-2xl font-extrabold text-white">Al-Hikmah</h3>
        <p class="text-white/60 leading-relaxed">
          Pondok Pesantren Modern yang berdedikasi untuk mencetak generasi Qur'ani yang unggul dalam ilmu agama dan inovasi modern.
        </p>
      </div>

      <!-- Quick Links -->
      <div class="space-y-6">
        <h4 class="text-xl font-bold">Link Cepat</h4>
        <ul class="space-y-3">
          <li v-for="link in quickLinks" :key="link.name">
            <a :href="link.href" class="text-white/60 hover:text-secondary transition-colors">
              {{ link.name }}
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="space-y-6">
        <h4 class="text-xl font-bold">Kontak</h4>
        <ul class="space-y-3 text-white/60">
          <li>Jl. Raya Pesantren No. 123</li>
          <li>Jawa Timur, Indonesia</li>
          <li>+62 123 4567 890</li>
          <li>info@alhikmah.id</li>
        </ul>
      </div>

      <!-- Social & Newsletter -->
      <div class="space-y-6">
        <h4 class="text-xl font-bold">Ikuti Kami</h4>
        <div class="flex space-x-4">
          <a 
            v-for="(social, index) in socialMedia" 
            :key="index" 
            :href="social.href"
            class="p-2 bg-white/10 rounded-lg hover:bg-secondary transition-colors"
          >
            <component :is="social.icon" :size="20" />
          </a>
        </div>
        <div class="space-y-3">
          <p class="text-white/60 text-sm">Berlangganan berita terbaru</p>
          <div class="flex">
            <input 
              type="email" 
              placeholder="Email Anda" 
              class="bg-white/10 border border-white/20 px-4 py-2 rounded-l-lg focus:outline-none focus:border-secondary flex-grow"
            />
            <button class="bg-secondary p-2 rounded-r-lg hover:bg-secondary-light transition-colors">
              <Send :size="20" class="text-primary" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="container-custom pt-8 border-t border-white/10 text-center text-white/40 text-sm">
      <p>&copy; 2026 Al-Hikmah Pondok Pesantren Modern. All rights reserved.</p>
    </div>
  </footer>
</template>
