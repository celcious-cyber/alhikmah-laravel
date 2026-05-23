<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import SectionHeading from '../ui/SectionHeading.vue'
import BaseButton from '../ui/BaseButton.vue'
import { Quote } from 'lucide-vue-next'

const page = usePage()
const settings = computed(() => page.props.cmsSettings || {})
</script>

<template>
  <section id="about" class="section-padding bg-transparent relative z-20">
    <div class="container-custom">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <!-- Image Side -->
        <div class="relative" data-aos="fade-right">

          <img 
            :src="settings.about_image ? '/storage/' + settings.about_image : 'https://placehold.co/800x1000/154D6E/FFFFFF?text=Pimpinan'" 
            :alt="settings.founder_name || 'Pimpinan Pondok'" 
            class="w-full h-auto rounded-2xl shadow-2xl object-cover aspect-[4/5]"
          />
          <!-- Badge overlay -->
          <div class="relative mt-8 lg:mt-0 lg:absolute lg:bottom-8 lg:-right-8 glassmorphism p-6 rounded-xl shadow-xl max-w-sm mx-auto lg:mx-0 lg:max-w-xs z-10">
            <Quote class="text-secondary mb-2" :size="32" />
            <p class="text-white font-medium italic text-justify">
              {{ settings.quote_text || $t('about.quote') }}
              <br />
              <span class="text-secondary text-sm font-bold not-italic mt-2 block">{{ settings.quote_source || '(Q.S. Al-Baqarah : 269)' }}</span>
            </p>
          </div>
        </div>

        <!-- Text Side -->
        <div class="space-y-8 text-center lg:text-left" data-aos="fade-left">
          <SectionHeading 
            :title="settings.about_title || $t('about.title')" 
            :subtitle="settings.about_subtitle || $t('about.subtitle')"
            class="!text-center lg:!text-left !mb-8"
          />
          
          <div class="space-y-6 text-white/70 text-lg leading-relaxed text-center lg:text-justify prose-p:mb-4 last:prose-p:mb-0">
            <div v-html="settings.about_p1 || '<p>Pondok Modern Al-Hikmah didirikan pada tahun 1995 oleh KH. Syihabuddin Muhammad dengan visi mencetak generasi Qur\'ani yang berwawasan global. Berawal dari sebuah surau kecil di pelosok desa, kini Al-Hikmah telah berkembang pesat menjadi institusi pendidikan Islam terpadu yang modern dan inklusif.</p>'"></div>
            <div v-html="settings.about_p2 || '<p>Melalui perpaduan harmonis antara kurikulum pesantren salaf dan pendidikan nasional, kami senantiasa berkomitmen untuk melahirkan barisan santri yang tidak hanya unggul dalam pemahaman agama (tafaqquh fiddin), tetapi juga tangguh menghadapi tantangan sains dan teknologi masa depan.</p>'"></div>
          </div>

          <div class="pt-6 border-t border-white/10 flex flex-col items-center lg:flex-row lg:justify-between gap-6">
            <div class="text-center lg:text-left">
              <h4 class="text-white font-bold text-xl">{{ settings.founder_name || 'KH. Syihabuddin Muhammad' }}</h4>
              <p class="text-secondary font-medium">{{ settings.founder_title || $t('about.founder_title') }}</p>
            </div>
            
            <router-link to="/profil" class="w-full lg:w-auto">
              <BaseButton variant="outline" class="!border-secondary !text-secondary hover:!bg-secondary hover:!text-primary w-full self-center">
                Selengkapnya
              </BaseButton>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
@media (min-width: 1024px) {
  :deep(.section-heading) {
    text-align: left !important;
  }
  :deep(.section-heading div) {
    margin-left: 0 !important;
  }
}
</style>
