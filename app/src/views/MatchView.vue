<script setup>
import { match } from '@/api/matches';
import { useRouter } from 'vue-router';
import { useMatchesStore } from '@/stores/matches.js'
import { useBetStore } from '@/stores/bet.js'
import { useAuthStore } from '@/stores/auth.js'

import { createBet, deleteBet, updateBet } from '@/api/bets';
import { ref } from 'vue';

const router = useRouter();
const { id } = router.currentRoute.value.params;

match(id);

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

let title = '';
let betLines = ref([
  {
    name: 'Paris Saint Germain',
    odd: 1.17,
  },
  {
    name: 'Match nul',
    odd: 3.75,
  },
]);
</script>

<template>
  <div class="bg-gray-200 p-4">
    <div class="p-4 mb-4 bg-white">

      <span>{{ useMatchesStore().match?.league?.country + ' - ' + useMatchesStore().match?.league?.name + ' - ' + formatDate(useMatchesStore().match?.start_time) }}</span>

      <span class="flex items-center justify-center text-lg">
        {{ useMatchesStore().match?.home_team + ' - ' + useMatchesStore().match?.away_team }}
      </span>
    </div>

    <div class="bg-white p-4 gap-4" v-if="useAuthStore().user !== null && useAuthStore().user.role === 'admin'">
      <form class="flex flex-col gap-4 rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="() => {
        createBet({
          match_id: id,
          title,
          bet_lines: betLines,
        });
      }">
        <h2 class="text-xl">New bet</h2>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
            Title
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" placeholder="Title" v-model="title" required @input="title = $event.target.value">
        </div>

        <div class="flex w-full items-center" v-for="(betLine, index) in betLines" :key="index">
          <div class="mb-4 w-50">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
              Name
            </label>
            <input class="shadow w-full appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Name" required @input="betLine.title = $event.target.value">
          </div>

          <div class="mb-4 w-50">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="odd">
              Odd
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="odd" type="number" placeholder="Odd" required @input="betLine.odd = $event.target.value">
          </div>

          <button class="bg-red-500 hover:bg-red-700 h-[40px] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="() => {
            betLines.splice(index, 1);
          }">
            Remove bet line
          </button>
        </div>

        <div class="flex flex-row gap-4">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="() => {
            betLines.push({
              name: 'Name',
              odd: '1',
            });
          }">
            Add bet line
          </button>

          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="() => {
            createBet(id, title, betLines);
            title = '';
            betLines = [];
          }">
            Create bet
          </button>
        </div>
      </form>
    </div>

    <div class="flex flex-row flex-wrap gap-4 pt-4">
      <div v-for="bets in useMatchesStore().match?.bets" :key="bets.id" class="bg-white w-[500px] p-[10px] gap-4">
        <div class="flex flex-row justify-between pb-4">
          <p class="mb-2">{{ bets.title }}</p>

          <span class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="() => {
            deleteBet(bets.id, id);
          }" v-if="useAuthStore().user !== null && useAuthStore().user.role === 'admin'">
            X
          </span>
        </div>

        <div class="flex flex-wrap gap-[10px]">
          <div v-for="bet in bets.bet_lines" :key="bet.id" class="bg-yellow-500 hover:bg-yellow-300 w-[235px] flex flex-col" @click="() => {
            useBetStore().addBet(bet);
          }">
            <p>{{ bet.title }}</p>
            
            <p>{{ bet.odd }}</p>

            <select name="status" id="status" v-model="bet.status" @change="() => {
              updateBet(bet.id, id, bet.status);
            }" v-if="useAuthStore().user !== null && useAuthStore().user.role === 'admin'">
              <option value="pending">pending</option>
              <option value="lost">lost</option>
              <option value="won">won</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>