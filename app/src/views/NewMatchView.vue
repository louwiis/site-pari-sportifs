<script setup>
import { leagues } from '@/api/leagues';
import { createMatch } from '@/api/matches';
import { useMatchesStore } from '@/stores/matches';
import { useRouter } from 'vue-router';

const router = useRouter();
leagues();

let home_team = '';
let away_team = '';
let start_time = '';
let league = '';
</script>

<template>
  <div>
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="() => {
      createMatch(home_team, away_team, start_time, league)
      .then((response) => {
        router.push(`/matches/${response.id}`);
      })
    }">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="league">
          League
        </label>
        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="league" v-model="league" required>
          <option v-for="league in useMatchesStore().leagues" :key="league.id" :value="league.id">
            {{ league.country }} -
            {{ league.name }}
          </option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="home_team">
          Home Team
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="home_team" type="text" placeholder="Home Team" v-model="home_team" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="away_team">
          Away Team
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="away_team" type="text" placeholder="Away Team" v-model="away_team" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="start_time">
          Start Time
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="start_time" type="datetime-local" placeholder="Start Time" v-model="start_time" required>
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
          Create Match
        </button>
      </div>
    </form>
  </div>
</template>