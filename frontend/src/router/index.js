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

const routes = [
  {
    path: '/app',
    name: 'client-home',
    component: ClientHome,
  },
  {
    path: '/account',
    name: 'account',
    component: Account,
  },
  {
    path: '/order/:carId',
    name: 'order',
    component: Order,
  },
  {
    path: '/account/documents',
    name: 'account-documents',
    component: Documents,
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
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
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

export default router
