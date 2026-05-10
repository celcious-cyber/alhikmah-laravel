<script setup>
import { useI18n } from 'vue-i18n'
import SectionHeading from '../ui/SectionHeading.vue'
import BaseButton from '../ui/BaseButton.vue'

const { t } = useI18n()

const images = [
  { id: 1, category: 'Kegiatan', caption: 'Pelajaran Kitab Kuning', image: 'https://picsum.photos/seed/gall1/800/1000' },
  { id: 2, category: 'Prestasi', caption: 'Juara MTQ Nasional', image: 'https://picsum.photos/seed/gall2/800/600' },
  { id: 3, category: 'Kegiatan', caption: 'Ekstrakurikuler Memanah', image: 'https://picsum.photos/seed/gall3/800/800' },
  { id: 4, category: 'Wisuda', caption: 'Haflah Akhirussanah 2025', image: 'https://picsum.photos/seed/gall4/800/600' },
  { id: 5, category: 'Kegiatan', caption: 'Praktik Laboratorium IPA', image: 'https://picsum.photos/seed/gall5/800/1200' },
  { id: 6, category: 'Prestasi', caption: 'Lomba Pidato Bahasa Arab', image: 'https://picsum.photos/seed/gall6/800/600' },
  { id: 7, category: 'Wisuda', caption: 'Prosesi Wisuda Tahfidz', image: 'https://picsum.photos/seed/gall7/800/1000' },
  { id: 8, category: 'Kegiatan', caption: 'Shalat Berjamaah', image: 'https://picsum.photos/seed/gall8/800/800' },
]
</script>

<template>
  <section id="galeri" class="section-padding bg-transparent">
    <div class="container-custom">
      <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 gap-6">
        <SectionHeading 
          :title="$t('gallery.title')" 
          :subtitle="$t('gallery.subtitle')"
          class="!mb-0 !text-center md:!text-left"
        />
        
        <router-link to="/gallery">
          <BaseButton variant="primary" size="md" class="!bg-secondary !text-primary px-8 py-3 !rounded-2xl font-bold">
            {{ $t('gallery.explore') }}
          </BaseButton>
        </router-link>
      </div>

      <!-- Grid 4 Columns -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="200">
        <div 
          v-for="img in images.slice(0, 8)" 
          :key="img.id"
          class="relative group aspect-square overflow-hidden rounded-[32px] shadow-xl"
        >
          <img 
            :src="img.image" 
            :alt="img.caption"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
          />
          
          <!-- Hover Overlay -->
          <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center p-6 text-center backdrop-blur-sm">
            <h5 class="text-white font-bold text-lg mb-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
              {{ img.caption }}
            </h5>
            <span class="px-4 py-1 bg-secondary/20 text-secondary rounded-full text-xs font-bold transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 delay-75">
              {{ img.category }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
