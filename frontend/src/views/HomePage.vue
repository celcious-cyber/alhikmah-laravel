<script setup>
import HeroSection from '../components/sections/HeroSection.vue'
import StatsBar from '../components/sections/StatsBar.vue'
import AboutSection from '../components/sections/AboutSection.vue'
import VisionMissionSection from '../components/sections/VisionMissionSection.vue'
import ProgramsSection from '../components/sections/ProgramsSection.vue'
import NewsSection from '../components/sections/NewsSection.vue'
import WhyChooseSection from '../components/sections/WhyChooseSection.vue'
import FacilitiesSection from '../components/sections/FacilitiesSection.vue'
import GallerySection from '../components/sections/GallerySection.vue'
import TestimonialsSection from '../components/sections/TestimonialsSection.vue'
import CTASection from '../components/sections/CTASection.vue'
</script>

<template>
  <main>
    <HeroSection />
    <StatsBar />
    <AboutSection id="about" />
    <VisionMissionSection id="visi-misi" />
    <ProgramsSection id="program" />
    <NewsSection id="news" />
    <WhyChooseSection id="why-choose" />
    <FacilitiesSection id="fasilitas" />
    <GallerySection id="galeri" />
    <TestimonialsSection id="testimonial" />
    <CTASection id="cta" />
  </main>
</template>
