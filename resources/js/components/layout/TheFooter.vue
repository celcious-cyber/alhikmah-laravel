<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Instagram, Facebook, Youtube, Send, MapPin, Phone, Mail } from 'lucide-vue-next'

const page = usePage()
const settings = computed(() => page.props.cmsSettings || {})

const quickLinks = [
  { name: 'Beranda', href: '#hero' },
  { name: 'Tentang', href: '#about' },
  { name: 'Program', href: '#program' },
  { name: 'Fasilitas', href: '#fasilitas' },
  { name: 'Galeri', href: '#galeri' },
  { name: 'Pendaftaran', href: '#cta' },
]

const socialMedia = [
  { icon: Instagram, href: 'https://www.instagram.com/ponpes_alhikmah.utan/' },
  { icon: Facebook, href: 'https://web.facebook.com/ponpes.alhikmahutan?locale=id_ID' },
  { icon: Youtube, href: 'https://www.youtube.com/@Alhikmahutan' },
]
</script>

<template>
  <footer class="bg-[#081a24] text-white pt-20 pb-10">
    <div class="container-custom grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
      <!-- About -->
      <div class="space-y-6">
        <img src="/assets/images/logo.svg" alt="Al Hikmah" class="h-20 w-auto block mb-4" />
        <p class="text-white/80 font-medium italic leading-relaxed">
          "Berdiri di atas dan untuk semua golongan"
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
        <ul class="space-y-4 text-white/60">
          <li class="flex gap-3">
            <MapPin :size="20" class="text-secondary shrink-0" />
            <a 
              href="https://maps.app.goo.gl/BKm93f7b5CPAh9B57" 
              target="_blank" 
              class="hover:text-secondary transition-colors"
            >
              {{ settings.contact_address || 'Jl. Lintas Sumbawa Tano, Stowe Brang, Kec. Utan, Kab. Sumbawa - NTB' }}
            </a>
          </li>
          <li class="flex gap-3 items-center">
            <Phone :size="20" class="text-secondary shrink-0" />
            <a :href="`tel:${settings.contact_phone || '+6285958561289'}`" class="hover:text-secondary transition-colors text-sm">
              {{ settings.contact_phone || '+62 859-5856-1289' }}
            </a>
          </li>
          <li class="flex gap-3 items-center">
            <Mail :size="20" class="text-secondary shrink-0" />
            <a :href="`mailto:${settings.contact_email || 'sekretariat@alhikmahutan.ponpes.id'}`" class="hover:text-secondary transition-colors text-xs sm:text-sm break-all">
              {{ settings.contact_email || 'sekretariat@alhikmahutan.ponpes.id' }}
            </a>
          </li>
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
            target="_blank"
            class="p-2 bg-white/10 rounded-lg hover:bg-secondary transition-colors text-white"
          >
            <component :is="social.icon" :size="20" />
          </a>
        </div>
        <div class="space-y-3">
          <p class="text-white/60 text-sm">Kritik dan Saran</p>
          <div class="flex">
            <input 
              type="text" 
              placeholder="Pesan Anda" 
              class="bg-white/10 border border-white/20 px-4 py-2 rounded-l-lg focus:outline-none focus:border-secondary flex-grow text-sm placeholder:text-white/40"
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
