<script setup>
import { useMatchesStore } from '@/stores/matches';
import { useAuthStore } from '@/stores/auth';
import { matches } from '@/api/matches';

matches();

function formatDate(date) {
  const today = new Date();
  const tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  const matchDate = new Date(date);

  if (matchDate.toDateString() === today.toDateString()) {
    return 'Today ' + matchDate.toLocaleTimeString();
  } else if (matchDate.toDateString() === tomorrow.toDateString()) {
    return 'Tomorrow ' + matchDate.toLocaleTimeString();
  } else {
    return matchDate.toLocaleDateString() + ' ' + matchDate.toLocaleTimeString();
  }
}
</script>

<template>
  <div class="bg-gray-200 items-center gap-4 p-4">
    <h1 class="text-2xl">Matches</h1>

    <router-link to="/matches/new" class="flex flex-col p-2 bg-white text-sm" v-if="useAuthStore().user !== null && useAuthStore().user.role === 'admin'">
      <span>Create a new match</span>
    </router-link>

    <div v-for="match in useMatchesStore().matches" :key="match.id">
      <router-link :to="'/matches/' + match.id" class="flex flex-col w-[800px] p-2 bg-white text-sm">
        <span>{{ match.league.country + ' - ' + match.league.name + ' - ' + formatDate(match.start_time) }}</span>

        <span class="flex items-center justify-center text-lg">
          {{ match.home_team + ' - ' + match.away_team }}
        </span>
      </router-link>
    </div>
  </div>
</template>
