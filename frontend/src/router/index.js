import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../views/HomePage.vue'
import ActivitiesPage from '../views/ActivitiesPage.vue'
import RegistrationPage from '../views/RegistrationPage.vue'
import GalleryPage from '../views/GalleryPage.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage
  },
  {
    path: '/agenda',
    name: 'activities',
    component: ActivitiesPage
  },
  {
    path: '/register',
    name: 'register',
    component: RegistrationPage
  },
  {
    path: '/gallery',
    name: 'gallery',
    component: GalleryPage
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth',
      }
    }
    return { top: 0, behavior: 'smooth' }
  }
})

export default router
