import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import About from '../components/About.vue'
import ClientHome from '../pages/client/Index.vue'
import Order from '../pages/client/Order.vue'
import Register from '../pages/auth/Register.vue'
import Login from '../pages/auth/Login.vue'
import Forgot from '../pages/auth/Forgot.vue'
import Account from '../pages/client/Account.vue'
import Documents from '../pages/client/Documents.vue'
import { api, clearAuthToken, getAuthToken } from '../lib/api'

const routes = [
  {
    path: '/app',
    name: 'client-home',
    component: ClientHome,
    meta: { requiresAuth: true },
  },
  {
    path: '/account',
    name: 'account',
    component: Account,
    meta: { requiresAuth: true },
  },
  {
    path: '/order/:carId',
    name: 'order',
    component: Order,
    meta: { requiresAuth: true },
  },
  {
    path: '/account/documents',
    name: 'account-documents',
    component: Documents,
    meta: { requiresAuth: true },
  },
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/about',
    name: 'about',
    component: About,
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: { guestOnly: true },
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: { guestOnly: true },
  },
  {
    path: '/forgot',
    name: 'forgot',
    component: Forgot,
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

async function isAuthenticated() {
  const token = getAuthToken()
  if (!token) return false

  try {
    await api.get('/auth/me')
    return true
  } catch (error) {
    clearAuthToken()
    return false
  }
}

router.beforeEach(async (to) => {
  const auth = await isAuthenticated()

  if (to.meta.requiresAuth && !auth) {
    return { name: 'login' }
  }

  if (to.meta.guestOnly && auth) {
    return { name: 'client-home' }
  }

  return true
})

export default router
