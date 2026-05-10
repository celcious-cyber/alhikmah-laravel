<script setup>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import SectionHeading from '../ui/SectionHeading.vue'
import { Eye, Target, Heart, Zap, Star, X, ChevronLeft, ChevronRight } from 'lucide-vue-next'

const { tm } = useI18n()
const scrollContainer = ref(null)
const selectedItem = ref(null)
const isModalOpen = ref(false)

const scroll = (direction) => {
  if (scrollContainer.value) {
    const scrollAmount = 450
    scrollContainer.value.scrollBy({
      left: direction === 'left' ? -scrollAmount : scrollAmount,
      behavior: 'smooth'
    })
  }
}

const openModal = (item) => {
  selectedItem.value = item
  isModalOpen.value = true
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  isModalOpen.value = false
  document.body.style.overflow = 'auto'
}

const items = computed(() => {
  const i18nItems = tm('vision.items')
  return [
    {
      title: i18nItems[0].title,
      icon: Eye,
      color: 'border-primary',
      shortDesc: i18nItems[0].short,
      text: i18nItems[0].detail
    },
    {
      title: i18nItems[1].title,
      icon: Target,
      color: 'border-secondary',
      shortDesc: i18nItems[1].short,
      list: i18nItems[1].detail
    },
    {
      title: i18nItems[2].title,
      icon: Star,
      color: 'border-accent',
      shortDesc: i18nItems[2].short,
      text: i18nItems[2].detail
    },
    {
      title: i18nItems[3].title,
      icon: Zap,
      color: 'border-primary',
      shortDesc: i18nItems[3].short,
      list: i18nItems[3].detail
    }
  ]
})
</script>

<template>
  <section id="visi-misi" class="section-padding bg-transparent">
    <div class="container-custom">
      <div class="flex justify-between items-end mb-12">
        <SectionHeading 
          :title="$t('vision.title')" 
          :subtitle="$t('vision.subtitle')"
          class="!mb-0 !text-left"
        />
        
        <!-- Navigation Buttons -->
        <div class="hidden md:flex gap-4 pb-4">
          <button 
            @click="scroll('left')"
            class="p-4 glassmorphism rounded-2xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 shadow-lg"
          >
            <ChevronLeft :size="24" />
          </button>
          <button 
            @click="scroll('right')"
            class="p-4 glassmorphism rounded-2xl text-white hover:bg-secondary hover:text-primary transition-all duration-300 shadow-lg"
          >
            <ChevronRight :size="24" />
          </button>
        </div>
      </div>

      <div ref="scrollContainer" class="flex gap-8 overflow-x-auto overflow-y-visible py-12 px-4 -mx-4 snap-x snap-mandatory hide-scrollbar">
        <div 
          v-for="(item, index) in items" 
          :key="index"
          class="glassmorphism p-8 rounded-3xl border-l-8 shadow-card flex flex-col min-w-[320px] md:min-w-[400px] h-[340px] snap-center transition-all duration-[2000ms] cubic-bezier(0.16, 1, 0.3, 1) hover:-translate-y-4 hover:scale-[1.03] hover:bg-white/[0.22] hover:shadow-[0_30px_60px_rgba(240,173,29,0.15)] hover:border-secondary/60 group"
          :class="item.color"
          data-aos="fade-up"
          :data-aos-delay="index * 100"
        >
          <div class="flex items-center gap-4 mb-6">
            <div class="p-3 bg-secondary/10 rounded-xl group-hover:bg-secondary/20 transition-colors duration-[2000ms] cubic-bezier(0.16, 1, 0.3, 1)">
              <component :is="item.icon" :size="28" class="text-secondary" />
            </div>
            <h4 class="text-2xl font-bold text-white group-hover:text-secondary transition-colors duration-[2000ms] cubic-bezier(0.16, 1, 0.3, 1)">{{ item.title }}</h4>
          </div>

          <div class="flex-grow">
            <p class="text-white/70 leading-relaxed text-lg group-hover:text-white transition-colors duration-[2000ms] cubic-bezier(0.16, 1, 0.3, 1)">
              {{ item.shortDesc }}
            </p>
          </div>

          <button 
            @click="openModal(item)"
            class="mt-6 text-secondary font-bold flex items-center gap-2 hover:translate-x-2 transition-transform duration-300 group/btn"
          >
            {{ $t('vision.more') }}
            <span class="group-hover/btn:translate-x-1 transition-transform">→</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Detail -->
    <Transition name="fade">
      <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-8">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md" @click="closeModal"></div>
        
        <div class="relative glassmorphism w-full max-w-2xl max-h-[80vh] overflow-y-auto rounded-[32px] p-8 md:p-12 shadow-2xl border-secondary/30" data-aos="zoom-in" data-aos-duration="300">
          <button @click="closeModal" class="absolute top-6 right-6 p-2 text-white/50 hover:text-white hover:bg-white/10 rounded-full transition-all">
            <X :size="24" />
          </button>

          <div class="flex items-center gap-6 mb-8">
            <div class="p-4 bg-secondary/10 rounded-2xl">
              <component :is="selectedItem?.icon" :size="32" class="text-secondary" />
            </div>
            <h2 class="text-3xl font-bold text-white">{{ selectedItem?.title }}</h2>
          </div>

          <div v-if="selectedItem?.text" class="text-white/80 text-xl leading-relaxed text-justify">
            {{ selectedItem?.text }}
          </div>

          <ul v-else-if="selectedItem?.list" class="space-y-4 list-none">
            <li v-for="(point, pIndex) in selectedItem.list" :key="pIndex" class="flex gap-4 text-white/80 text-lg leading-relaxed">
              <span class="text-secondary mt-1.5 shrink-0 text-2xl">•</span>
              <span>{{ point }}</span>
            </li>
          </ul>

          <button 
            @click="closeModal"
            class="mt-12 w-full bg-secondary text-primary font-bold py-4 rounded-2xl hover:bg-secondary-dark transition-colors"
          >
            {{ $t('vision.close') }}
          </button>
        </div>
      </div>
    </Transition>
  </section>
</template>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
