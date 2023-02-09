<script setup>
import { RouterView } from 'vue-router'
import DefaultNavbar from '@/components/DefaultNavbar.vue'
import BetComponent from '@/components/BetComponent.vue'
import { useAuthStore } from '@/stores/auth.js'

</script>

<template>
  <DefaultNavbar class="fixed top-0 left-0 right-0 z-10 bg-white" />

  <main class="pt-12 flex flex-row h-screen">
    <RouterView class="flex flex-col grow overflow-scroll"/>

    <BetComponent class="flex flex-col shrink-0 w-[500px]" v-if="useAuthStore().user !== null && useAuthStore().user.role === 'user'" />
  </main>
</template>