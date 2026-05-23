<script setup>
import HeroSection from '../components/sections/HeroSection.vue'
import StatsBar from '../components/sections/StatsBar.vue'
import AboutSection from '../components/sections/AboutSection.vue'
import ProgramsSection from '../components/sections/ProgramsSection.vue'
import NewsSection from '../components/sections/NewsSection.vue'
import WhyChooseSection from '../components/sections/WhyChooseSection.vue'
import FacilitiesSection from '../components/sections/FacilitiesSection.vue'
import GallerySection from '../components/sections/GallerySection.vue'
import TestimonialsSection from '../components/sections/TestimonialsSection.vue'
import CTASection from '../components/sections/CTASection.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <main>
    <Head>
      <title>Beranda | Pondok Modern Al-Hikmah</title>
      <meta name="description" content="Pondok Modern Al-Hikmah adalah lembaga pendidikan Islam terpadu yang membina generasi muda yang beriman, berilmu, dan berakhlak mulia.">
    </Head>
    <HeroSection />
    <StatsBar />
    <AboutSection id="about" />
    <ProgramsSection id="program" />
    <NewsSection id="news" />
    <WhyChooseSection id="why-choose" />
    <FacilitiesSection id="fasilitas" />
    <GallerySection id="galeri" />
    <TestimonialsSection id="testimonial" />
    <CTASection id="cta" />
  </main>
</template>
