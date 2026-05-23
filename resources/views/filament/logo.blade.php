<div class="flex items-center justify-center">
    <img src="{{ asset('assets/images/logo.svg') }}" alt="Pondok Modern Al-Hikmah" class="h-8 logo-dynamic">
</div>
<style>
    .logo-dynamic {
        filter: invert(1);
    }
    :is(.dark .logo-dynamic) {
        filter: invert(0);
    }
</style>
