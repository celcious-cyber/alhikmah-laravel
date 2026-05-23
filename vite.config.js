import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            'vue-router': '/resources/js/vue-router-shim.js',
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        if (id.includes('vue') || id.includes('pinia') || id.includes('vue-i18n')) {
                            return 'vendor-vue';
                        }
                        if (id.includes('swiper')) {
                            return 'vendor-swiper';
                        }
                        if (id.includes('axios') || id.includes('aos')) {
                            return 'vendor-utils';
                        }
                        if (id.includes('lucide-vue-next')) {
                            return 'vendor-icons';
                        }
                        return 'vendor-others';
                    }
                }
            }
        },
        chunkSizeWarningLimit: 1000
    }
});
