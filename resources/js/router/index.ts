import { createRouter, createWebHistory } from 'vue-router'
import DashboardView from '@/views/DashboardView.vue'
import CustomerView from '@/views/customer/CustomerView.vue'
import LoginView from '@/views/LoginView.vue'
import PublicLayout from '@/layouts/PublicLayout.vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import RegisterView from '@/views/RegisterView.vue'
import LeadView from '@/views/lead/LeadView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      component: PublicLayout,
      children: [
        {
          path: '',
          name: 'login',
          component: LoginView
        }
      ]
    },
    {
      path: '/register',
      component: PublicLayout,
      children: [
        {
          path: '',
          name: 'register',
          component: RegisterView,
          meta: {
            title: 'Registration'
          }
        }
      ]
    },
    {
      path: '/',
      component: DefaultLayout,
      children: [
        {
          path: '',
          name: 'home',
          component: DashboardView,
          meta: {
            title: 'Dashboard'
          }
        },
        {
          // path: '/customer/:page?',
          path: '/customer',
          props: true,
          name: 'customer',
          component: CustomerView,
          meta: {
            title: 'Customers',
          }
        },
        {
          path: 'lead',
          props: true,
          name: 'lead',
          component: LeadView,
          meta: {
            title: 'Leads'
          }
        },
        {
          path: '/about',
          name: 'about',
          // route level code-splitting
          // this generates a separate chunk (About.[hash].js) for this route
          // which is lazy-loaded when the route is visited.
          component: () => import('../views/AboutView.vue'),
          meta: {
            title: 'About'
          }
        }
      ]
    }
  ]
})

router.beforeEach((to, from) => {
  const title = to.meta?.title ?? import.meta?.env.VITE_APP_NAME
  document.title = title
})

export default router
