<script setup>
import BaseButton from '../ui/BaseButton.vue'
</script>

<template>
  <section id="hero" class="relative min-h-screen flex items-center pt-36 pb-20 overflow-hidden">
    <div class="container-custom relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <!-- Text Side -->
      <div class="space-y-8 py-12 relative z-10 lg:z-20">
        <h1 class="text-4xl md:text-6xl lg:text-[4.8rem] font-extrabold text-white leading-[1.1] tracking-tight">
          <div data-aos="fade-up" data-aos-delay="200">{{ $t('hero.text1') }} <span class="text-secondary glitch" :data-text="$t('hero.text2')">{{ $t('hero.text2') }}</span></div>
          <div data-aos="fade-up" data-aos-delay="350"><span class="text-secondary glitch" :data-text="$t('hero.text3')">{{ $t('hero.text3') }}</span> {{ $t('hero.text4') }}</div>
          <div data-aos="fade-up" data-aos-delay="500">{{ $t('hero.text5') }}</div>
        </h1>

        <p class="text-lg md:text-xl text-white/70 max-w-xl leading-relaxed text-justify" data-aos="fade-up" data-aos-delay="650">
          {{ $t('hero.subtitle') }}
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap gap-3 pt-4 lg:pt-4 items-center relative z-30" data-aos="fade-up" data-aos-delay="800">
          <router-link to="/spsb26" class="w-full sm:w-auto">
            <BaseButton variant="primary" size="lg" class="!bg-secondary !text-[#2f2100] px-8 sm:px-10 hover:!bg-secondary-dark min-w-[200px] sm:min-w-[240px] justify-center h-12 sm:h-14 !rounded-full text-base sm:text-lg shadow-lg shadow-secondary/20 w-full sm:w-auto">
              Daftar Sekarang
            </BaseButton>
          </router-link>
          
          <router-link to="/pbs26" class="w-full sm:w-auto">
            <BaseButton variant="outline" size="lg" class="!border-secondary !text-secondary hover:!bg-secondary hover:!text-primary px-6 sm:px-10 min-w-[180px] sm:min-w-[240px] justify-center h-12 sm:h-14 !rounded-full text-base sm:text-lg flex items-center gap-2 w-full sm:w-auto shadow-xl">
              Program Beasiswa
            </BaseButton>
          </router-link>
        </div>
      </div>

      <!-- Image Side -->
      <div class="relative lg:h-[700px] flex items-end justify-center -mt-20 lg:mt-0 z-0">
        <!-- The Main Student Image -->
        <img 
          src="/assets/images/banner.png" 
          alt="Al-Hikmah Student" 
          class="relative -left-[20px] z-24 w-full max-w-[622px] h-auto object-contain transition-transform duration-700 hover:scale-105 cursor-pointer drop-shadow-[0_20px_50px_rgba(0,0,0,0.5)]"
          data-aos="fade-left"
          data-aos-delay="900"
          data-aos-duration="1500"
        />

        <!-- Gold Medal Asset -->
        <img 
          src="/assets/images/gold-medal.png" 
          class="absolute top-[20%] left-[5%] w-24 sm:w-32 lg:w-40 rotate-[-12deg] z-30 animate-bounce-slow"
          alt="gold-medal"
          data-aos="zoom-in"
          data-aos-delay="1200"
        />
      </div>
    </div>
  </section>
</template>

<style scoped>
.glitch {
  position: relative;
  display: inline-block;
  animation: glitch-shift 2.6s infinite steps(1, end);
  transition: text-shadow 0.3s ease-in-out;
}

.glitch:hover {
  text-shadow: 0 0 15px rgba(247, 192, 74, 0.8), 0 0 30px rgba(247, 192, 74, 0.5);
  cursor: default;
}

.glitch::before,
.glitch::after {
  content: attr(data-text);
  position: absolute;
  inset: 0;
  pointer-events: none;
  opacity: 0;
}

.glitch::before {
  color: #ffd166;
  text-shadow: -1px 0 rgba(255, 255, 255, 0.38);
  animation: glitch-before 2.6s infinite steps(1, end);
}

.glitch::after {
  color: #ffb000;
  text-shadow: 1px 0 rgba(21, 77, 110, 0.6);
  animation: glitch-after 2.6s infinite steps(1, end);
}


@keyframes glitch-shift {
  0%, 88%, 100% { transform: translate(0, 0); }
  89% { transform: translate(-1px, 1px); }
  90% { transform: translate(1px, -1px); }
  91% { transform: translate(-1px, 0); }
  92% { transform: translate(1px, 0); }
}

@keyframes glitch-before {
  0%, 88%, 100% {
    opacity: 0;
    transform: translate(0, 0);
    clip-path: inset(0 0 0 0);
  }
  89% {
    opacity: 0.7;
    transform: translate(-2px, 0);
    clip-path: inset(12% 0 48% 0);
  }
  90% {
    opacity: 0.35;
    transform: translate(1px, -1px);
    clip-path: inset(56% 0 12% 0);
  }
  91% {
    opacity: 0.55;
    transform: translate(-1px, 1px);
    clip-path: inset(38% 0 30% 0);
  }
}

@keyframes glitch-after {
  0%, 88%, 100% {
    opacity: 0;
    transform: translate(0, 0);
    clip-path: inset(0 0 0 0);
  }
  89% {
    opacity: 0.45;
    transform: translate(2px, 0);
    clip-path: inset(60% 0 8% 0);
  }
  90% {
    opacity: 0.7;
    transform: translate(-1px, 1px);
    clip-path: inset(18% 0 52% 0);
  }
  91% {
    opacity: 0.4;
    transform: translate(1px, -1px);
    clip-path: inset(42% 0 28% 0);
  }
}
</style>
