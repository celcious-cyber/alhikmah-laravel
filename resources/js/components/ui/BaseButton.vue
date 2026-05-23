<script setup>
defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'outline'].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  href: {
    type: String,
    default: ''
  }
})

const variantClasses = {
  primary: 'bg-secondary text-[#2f2100] hover:bg-secondary-dark',
  secondary: 'bg-white text-primary border-2 border-primary hover:bg-surface',
  outline: 'bg-transparent border-2 border-white text-white hover:bg-white hover:text-primary'
}

const sizeClasses = {
  sm: 'px-6 py-2 text-sm',
  md: 'px-8 py-3 text-base',
  lg: 'px-10 py-4 text-lg'
}
</script>

<template>
  <component
    :is="href ? 'a' : 'button'"
    :href="href"
    class="inline-flex items-center justify-center font-bold rounded-full transition-all duration-300 active:scale-95 cursor-pointer"
    :class="[variantClasses[variant], sizeClasses[size]]"
  >
    <slot />
  </component>
</template>
