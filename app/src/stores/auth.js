import { defineStore } from 'pinia'
import { me } from '@/api/auth'

export const useAuthStore = defineStore("auth", {
  state: () => ({
    token: localStorage.getItem('token'),
    user: null
  }),
  actions: {
    login(token) {
      localStorage.setItem('token', token)
      this.token = token
    },

    logout() {
      localStorage.removeItem('token')
      this.token = null
      this.user = null
    },

    async me() {
      try {
        await me()
      } catch (error) {
        this.logout()
      }
    }
  }
})
