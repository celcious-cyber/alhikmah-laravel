<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/png" href="/assets/images/KMI.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Primary Meta Tags -->
    <title>{{ config('app.seo_title', 'Pondok Modern Al-Hikmah Utan') }}</title>
    <meta name="title" content="{{ config('app.seo_title', 'Pondok Modern Al-Hikmah Utan') }}" />
    <meta name="description" content="{{ config('app.seo_description', 'Pondok Pesantren Modern Al-Hikmah - Menjembatani tradisi abadi dan inovasi modern. Pendidikan Islam berkualitas dengan fasilitas lengkap dan lingkungan islami.') }}" />

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ config('app.seo_url', 'https://alhikmahutan.ponpes.id/') }}" />
    <meta property="og:title" content="{{ config('app.seo_title', 'Pondok Modern Al-Hikmah Utan') }}" />
    <meta property="og:description" content="{{ config('app.seo_description', 'Pondok Pesantren Modern Al-Hikmah - Menjembatani tradisi abadi dan inovasi modern. Pendidikan Islam berkualitas dengan fasilitas lengkap dan lingkungan islami.') }}" />
    <meta property="og:image" content="{{ config('app.seo_image', 'https://alhikmahutan.ponpes.id/og-image.jpg') }}" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ config('app.seo_url', 'https://alhikmahutan.ponpes.id/') }}" />
    <meta property="twitter:title" content="{{ config('app.seo_title', 'Pondok Modern Al-Hikmah Utan') }}" />
    <meta property="twitter:description" content="{{ config('app.seo_description', 'Pondok Pesantren Modern Al-Hikmah - Menjembatani tradisi abadi dan inovasi modern. Pendidikan Islam berkualitas dengan fasilitas lengkap dan lingkungan islami.') }}" />
    <meta property="twitter:image" content="{{ config('app.seo_image', 'https://alhikmahutan.ponpes.id/og-image.jpg') }}" />

    @inertiaHead

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet" />

    <!-- Preload LCP Image -->
    <link rel="preload" href="/assets/images/banner.png" as="image" />

    <!-- Vite Styles and Scripts -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
  </head>
  <body class="antialiased font-sans">
    @inertia
  </body>
</html>
