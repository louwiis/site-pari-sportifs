<script setup>
import { leagues } from '@/api/leagues';
import { createLeague } from '@/api/leagues';
import { useRouter } from 'vue-router';

const router = useRouter();
leagues();

let country = '';
let name = '';
</script>

<template>
  <div>
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="() => {
      createLeague(country, name,)
      .then((response) => {
        router.push('/')
      })
    }">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="country">
          Country
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" type="text" placeholder="Country" v-model="country" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
          Name
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Name" v-model="name" required>
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
          Create League
        </button>
      </div>
    </form>
  </div>
</template>