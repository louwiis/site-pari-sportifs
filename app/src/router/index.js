import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import RegisterView from '@/views/RegisterView.vue'
import LoginView from '@/views/LoginView.vue'
import MatchView from '@/views/MatchView.vue'
import NewMatchView from '@/views/NewMatchView.vue'
import NewLeagueView from '@/views/NewLeagueView.vue'

import DefaultLayout from '@/layouts/DefaultLayout.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/',
      name: 'DefaultLayout',
      component: DefaultLayout,
      children: [
        {
          path: '/',
          name: 'home',
          component: HomeView,
        },
        {
          path: '/matches',
          name: 'matches',
          children: [
            {
              path: ':id',
              name: 'match',
              component: MatchView,
            },
            {
              path: 'new',
              name: 'new-match',
              component: NewMatchView,
            }
          ]
        }
      ]
    },
    {
      path: '/leagues/new',
      name: 'new-league',
      component: NewLeagueView
    }
  ]
})

export default router
