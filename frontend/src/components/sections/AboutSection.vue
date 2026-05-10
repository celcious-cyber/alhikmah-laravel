<script setup>
import SectionHeading from '../ui/SectionHeading.vue'
import { Quote } from 'lucide-vue-next'
</script>

<template>
  <section id="about" class="section-padding bg-transparent">
    <div class="container-custom">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <!-- Image Side -->
        <div class="relative" data-aos="fade-right">
          <!-- Decorative Frame -->
          <div class="absolute -top-4 -left-4 w-full h-full border-2 border-secondary rounded-2xl translate-x-4 translate-y-4 -z-10"></div>
          <img 
            src="https://picsum.photos/seed/leader/800/1000" 
            alt="Pimpinan Pondok" 
            class="w-full h-auto rounded-2xl shadow-2xl object-cover aspect-[4/5]"
          />
          <!-- Badge overlay -->
          <div class="absolute bottom-8 right-8 glassmorphism p-6 rounded-xl shadow-xl max-w-xs">
            <Quote class="text-secondary mb-2" :size="32" />
            <p class="text-white font-medium italic text-justify">
              Dia (Allah) menganugerahkan HIKMAH kepada siapa yang Dia kehendaki. Siapa yang dianugerahi HIKMAH, sungguh dia telah dianugerahi kebaikan yang banyak. Tidak ada yang dapat mengambil pelajaran (darinya), kecuali ululalbab.”
              <br />
              <span class="text-secondary text-sm font-bold not-italic mt-2 block">(Q.S. Al-Baqarah : 269)</span>
            </p>
          </div>
        </div>

        <!-- Text Side -->
        <div class="space-y-8" data-aos="fade-left">
          <SectionHeading 
            :title="$t('about.title')" 
            :subtitle="$t('about.subtitle')"
            class="!text-left !mb-8"
          />
          
          <div class="space-y-6 text-white/70 text-lg leading-relaxed text-justify">
            <p v-html="$t('about.p1')"></p>
            <p>{{ $t('about.p2') }}</p>
          </div>

          <div class="pt-6 border-t border-white/10">
            <h4 class="text-white font-bold text-xl">KH. Syihabuddin Muhammad</h4>
            <p class="text-secondary font-medium">{{ $t('about.founder_title') }}</p>
            <!-- Signature Placeholder -->
            <div class="mt-4 font-serif text-3xl text-white/20 italic">Syihabuddin M.</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
:deep(.section-heading) {
  text-align: left !important;
}
:deep(.section-heading div) {
  margin-left: 0 !important;
}
</style>
