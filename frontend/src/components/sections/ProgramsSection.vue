<script setup>
import { ref, computed, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Pagination, Navigation } from 'swiper/modules'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'
import 'swiper/css'
import 'swiper/css/pagination'
import 'swiper/css/navigation'
import SectionHeading from '../ui/SectionHeading.vue'

const { tm, t } = useI18n()

// Images for programs
const programImages = [
  'https://picsum.photos/seed/tahfidz/600/400',
  'https://picsum.photos/seed/speech/600/400',
  'https://picsum.photos/seed/art/600/400',
  'https://picsum.photos/seed/skill/600/400',
  'https://picsum.photos/seed/sport/600/400',
  'https://picsum.photos/seed/kitab/600/400',
  'https://picsum.photos/seed/scout/600/400',
  'https://picsum.photos/seed/org/600/400',
  'https://picsum.photos/seed/study/600/400',
  'https://picsum.photos/seed/teach/600/400',
  'https://picsum.photos/seed/library/600/400',
  'https://picsum.photos/seed/tour/600/400',
  'https://picsum.photos/seed/imam/600/400'
]

const tabs = computed(() => [
  t('programs.tabs.all'),
  t('programs.tabs.extra'),
  t('programs.tabs.class')
])

const activeTab = ref(tabs.value[0])

watch(tabs, (newTabs) => {
  activeTab.value = newTabs[0]
})

const prev = ref(null)
const next = ref(null)

const programs = computed(() => {
  const items = tm('programs.items')
  return items.map((item, index) => {
    return {
      id: index + 1,
      title: item.title,
      category: index < 7 ? t('programs.tabs.extra') : t('programs.tabs.class'),
      desc: item.desc,
      image: programImages[index]
    }
  })
})

const filteredPrograms = computed(() => {
  if (activeTab.value === t('programs.tabs.all')) return programs.value
  return programs.value.filter(p => p.category === activeTab.value)
})
</script>

<template>
  <section id="program" class="section-padding bg-transparent overflow-hidden">
    <div class="container-custom">
      <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 gap-6">
        <SectionHeading 
          :title="$t('programs.title')" 
          :subtitle="$t('programs.subtitle')"
          class="!mb-0 !text-center md:!text-left"
        />

        <!-- Navigation Buttons -->
        <div class="flex gap-4">
          <button ref="prev" class="p-4 glassmorphism rounded-2xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 shadow-lg cursor-pointer disabled:opacity-30 disabled:cursor-not-allowed">
            <ChevronLeft :size="24" />
          </button>
          <button ref="next" class="p-4 glassmorphism rounded-2xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 shadow-lg cursor-pointer disabled:opacity-30 disabled:cursor-not-allowed">
            <ChevronRight :size="24" />
          </button>
        </div>
      </div>

      <!-- Tabs -->
      <div class="flex flex-wrap justify-center md:justify-start gap-4 mb-12" data-aos="fade-up">
        <button 
          v-for="tab in tabs" 
          :key="tab"
          @click="activeTab = tab"
          class="px-8 py-3 rounded-full font-bold transition-all duration-300"
          :class="activeTab === tab ? 'bg-secondary text-primary shadow-lg shadow-secondary/20' : 'bg-white/5 text-white/70 hover:bg-white/10 hover:text-white'"
        >
          {{ tab }}
        </button>
      </div>

      <!-- Swiper -->
      <div data-aos="fade-up" data-aos-delay="200">
        <Swiper
          :key="activeTab"
          :modules="[Autoplay, Pagination, Navigation]"
          :slides-per-view="1"
          :space-between="30"
          :pagination="{ clickable: true }"
          :navigation="{
            prevEl: prev,
            nextEl: next,
          }"
          :autoplay="{ delay: 5000 }"
          :breakpoints="{
            '640': { slidesPerView: 2 },
            '1024': { slidesPerView: 3 }
          }"
          class="pb-16"
        >
          <SwiperSlide v-for="program in filteredPrograms" :key="program.id">
            <div class="glassmorphism rounded-3xl overflow-hidden shadow-card hover:shadow-card-hover transition-all duration-500 group h-full flex flex-col">
              <!-- Image -->
              <div class="relative overflow-hidden aspect-video">
                <img 
                  :src="program.image" 
                  :alt="program.title"
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                />
                <div class="absolute top-4 left-4">
                  <span class="px-4 py-1.5 bg-secondary text-primary text-xs font-bold rounded-full shadow-lg">
                    {{ program.category }}
                  </span>
                </div>
              </div>

              <!-- Content -->
              <div class="p-8 space-y-4 flex-grow">
                <h4 class="text-2xl font-bold text-white">{{ program.title }}</h4>
                <p class="text-white/70 leading-relaxed">
                  {{ program.desc }}
                </p>
                <div class="pt-4">
                  <a href="#" class="text-secondary font-bold hover:text-white transition-colors inline-flex items-center">
                    {{ $t('programs.more') }} <span class="ml-2">→</span>
                  </a>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </div>
  </section>
</template>

<!-- Style moved to style.css to avoid build errors -->
