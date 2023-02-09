<script setup>
import { useAuthStore } from '@/stores/auth.js'

useAuthStore().me();
</script>

<template>
  <div class="h-[40px] flex justify-between items-center px-4">
    <div class="flex gap-2">
      <router-link to="/">Home</router-link>
      <router-link to="/history" v-if="useAuthStore().user !== null && useAuthStore().user.role !== 'admin'">Historique</router-link>
    </div>

    <div class="flex gap-2 items-center">
      <span v-if="useAuthStore().user !== null && useAuthStore().user.role !== 'admin'" class="bg-gray-200 px-2 py-1 rounded-full">{{ useAuthStore().user.balance }} coins</span>

      <div>
        <div v-if="!useAuthStore().token" class="flex gap-2">
          <router-link to="/login">Login</router-link>
          <router-link to="/register">Register</router-link>
        </div>
        <div v-else>
          <span @click="useAuthStore().logout()">Logout</span>
        </div>
      </div>
    </div>
  </div>
</template>