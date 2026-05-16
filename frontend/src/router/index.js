import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../views/HomePage.vue'
import ActivitiesPage from '../views/ActivitiesPage.vue'
import RegistrationPage from '../views/RegistrationPage.vue'
import GalleryPage from '../views/GalleryPage.vue'
import ScholarshipPage from '../views/ScholarshipPage.vue'
import NewsListPage from '../views/NewsListPage.vue'
import NewsDetailPage from '../views/NewsDetailPage.vue'
import FacilitiesPage from '../views/FacilitiesPage.vue'

// Admin pages
import AdminLoginPage from '../views/admin/LoginPage.vue'
import AdminDashboardPage from '../views/admin/DashboardPage.vue'
import AdminNewsPage from '../views/admin/NewsPage.vue'
import AdminGalleryPage from '../views/admin/GalleryPage.vue'
import AdminRegistrationsPage from '../views/admin/RegistrationsPage.vue'
import AdminMessagesPage from '../views/admin/MessagesPage.vue'
import AdminScholarshipsPage from '../views/admin/ScholarshipsPage.vue'

const routes = [
  // Public Routes
  { path: '/', name: 'home', component: HomePage },
  { path: '/agenda', name: 'activities', component: ActivitiesPage },
  { path: '/register', name: 'register', component: RegistrationPage },
  { path: '/spsb26', name: 'spsb26', component: RegistrationPage },
  { path: '/pbs26', name: 'pbs26', component: ScholarshipPage },
  { path: '/gallery', name: 'gallery', component: GalleryPage },
  { path: '/berita', name: 'news-list', component: NewsListPage },
  { path: '/berita/:slug', name: 'news-detail', component: NewsDetailPage },
  { path: '/facilities', name: 'facilities', component: FacilitiesPage },

  // Admin Routes
  { path: '/admin/login', name: 'admin-login', component: AdminLoginPage },
  {
    path: '/admin',
    redirect: '/admin/dashboard',
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/dashboard',
    name: 'admin-dashboard',
    component: AdminDashboardPage,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/news',
    name: 'admin-news',
    component: AdminNewsPage,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/gallery',
    name: 'admin-gallery',
    component: AdminGalleryPage,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/registrations',
    name: 'admin-registrations',
    component: AdminRegistrationsPage,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/messages',
    name: 'admin-messages',
    component: AdminMessagesPage,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/scholarships',
    name: 'admin-scholarships',
    component: AdminScholarshipsPage,
    meta: { requiresAuth: true }
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return { el: to.hash, behavior: 'smooth' }
    }
    return { top: 0, behavior: 'smooth' }
  }
})

// Navigation Guard — proteksi halaman admin
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const token = localStorage.getItem('admin_token')
    if (!token) {
      next('/admin/login')
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
