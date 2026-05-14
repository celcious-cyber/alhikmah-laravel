<script setup>
import { onMounted, ref } from 'vue'
import gsap from 'gsap'
import BaseButton from '../ui/BaseButton.vue'

const heroRef = ref(null)

onMounted(() => {
  const ctx = gsap.context(() => {
    // 1. Entrance Animation for Text
    const tl = gsap.timeline({ delay: 0.5 })

    tl.from(".hero-title-line", {
      y: 100,
      opacity: 0,
      duration: 1.2,
      stagger: 0.15,
      ease: "power4.out"
    })
    .from(".hero-p", {
      y: 30,
      opacity: 0,
      duration: 1,
      ease: "power3.out"
    }, "-=0.8")
    .from(".hero-btns", {
      y: 20,
      opacity: 0,
      duration: 1,
      ease: "power3.out"
    }, "-=0.8")

    // 2. Entrance Animation for Main Image
    gsap.from(".hero-main-img", {
      x: 100,
      opacity: 0,
      duration: 1.5,
      ease: "power4.out",
      delay: 0.8
    })

    // 3. Floating Assets (GSAP Floating)
    gsap.to(".floating-asset", {
      y: -20,
      duration: 3,
      repeat: -1,
      yoyo: true,
      ease: "sine.inOut",
      stagger: {
        each: 0.5,
        from: "random"
      }
    })

    // 4. Mouse Follow Parallax Effect
    const handleMouseMove = (e) => {
      const { clientX, clientY } = e
      const xPos = (clientX / window.innerWidth - 0.5) * 30
      const yPos = (clientY / window.innerHeight - 0.5) * 30

      gsap.to(".parallax-layer-1", {
        x: xPos,
        y: yPos,
        duration: 1.2,
        ease: "power2.out"
      })

      gsap.to(".parallax-layer-2", {
        x: -xPos * 1.5,
        y: -yPos * 1.5,
        duration: 1.8,
        ease: "power2.out"
      })
    }

    window.addEventListener('mousemove', handleMouseMove)
  }, heroRef.value)
})
</script>

<template>
  <section id="hero" ref="heroRef" class="relative min-h-screen flex items-center pt-36 pb-20 overflow-hidden">
    <div class="container-custom relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <!-- Text Side -->
      <div class="space-y-8 py-12 relative z-10 lg:z-20">
        <h1 class="text-4xl md:text-6xl lg:text-[4.8rem] font-extrabold text-white leading-[1.1] tracking-tight">
          <div class="overflow-hidden py-1 w-fit"><span class="hero-title-line block whitespace-nowrap">{{ $t('hero.text1') }} <span class="text-secondary glitch" :data-text="$t('hero.text2')">{{ $t('hero.text2') }}</span></span></div>
          <div class="overflow-hidden py-1 w-fit"><span class="hero-title-line block whitespace-nowrap"><span class="text-secondary glitch" :data-text="$t('hero.text3')">{{ $t('hero.text3') }}</span> {{ $t('hero.text4') }}</span></div>
          <div class="overflow-hidden py-1 w-fit"><span class="hero-title-line block whitespace-nowrap">{{ $t('hero.text5') }}</span></div>
        </h1>

        <p class="hero-p text-lg md:text-xl text-white/70 max-w-xl leading-relaxed text-justify">
          {{ $t('hero.subtitle') }}
        </p>

        <!-- CTA Buttons -->
        <div class="hero-btns flex flex-wrap gap-3 pt-4 lg:pt-4 items-center relative z-30">
          <router-link to="/spsb26" class="w-full sm:w-auto">
            <BaseButton variant="primary" size="lg" class="!bg-secondary !text-[#2f2100] px-8 sm:px-10 hover:!bg-secondary-dark min-w-[200px] sm:min-w-[240px] justify-center h-12 sm:h-14 !rounded-full text-base sm:text-lg shadow-lg shadow-secondary/20 w-full sm:w-auto">
              Daftar Sekarang
            </BaseButton>
          </router-link>
          
          <router-link to="/pbs26" class="w-full sm:w-auto">
            <BaseButton variant="outline" size="lg" class="!bg-white !border-secondary !text-primary hover:!bg-white/90 px-6 sm:px-10 min-w-[180px] sm:min-w-[240px] justify-center h-12 sm:h-14 !rounded-full text-base sm:text-lg flex items-center gap-2 w-full sm:w-auto shadow-xl">
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
          class="hero-main-img relative -left-[20px] z-24 w-full max-w-[622px] h-auto object-contain transition-transform duration-700 hover:scale-105 cursor-pointer drop-shadow-[0_20px_50px_rgba(0,0,0,0.5)]"
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
