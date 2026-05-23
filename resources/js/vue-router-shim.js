import { router as inertiaRouter, Link as RouterLink } from '@inertiajs/vue3';

export { RouterLink };

export function useRouter() {
    return {
        push: (url) => inertiaRouter.visit(url),
        back: () => window.history.back(),
        replace: (url) => inertiaRouter.replace(url),
    };
}

export function useRoute() {
    const pathParts = window.location.pathname.split('/').filter(Boolean);
    const params = {};
    
    // Extract slug for news detail route /berita/:slug
    if (window.location.pathname.includes('/berita/')) {
        params.slug = pathParts[pathParts.length - 1];
    }
    
    return {
        params,
        query: Object.fromEntries(new URLSearchParams(window.location.search)),
        path: window.location.pathname,
    };
}
