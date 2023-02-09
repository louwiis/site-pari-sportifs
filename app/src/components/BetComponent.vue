<script setup>
import { useBetStore } from '@/stores/bet.js'
import { useAuthStore } from '@/stores/auth.js'
import { newBet } from '@/api/bets.js'
import { useRouter } from 'vue-router';
import { match } from '@/api/matches.js'

const router = useRouter();
const { id } = router.currentRoute.value.params;

const betStore = useBetStore()

const amount = []
</script>

<template>
  <div class="w-[500px] h-full flex p-4 m-4 flex-col" v-if="useAuthStore().user !== null">
    <h2 class="text-xl">Your bets</h2>

    <div class="flex flex-col gap-4 p-4 overflow-scroll">
      <div v-for="bet in betStore.bets" :key="bet.id" class="flex flex-col gap-4 bg-gray-100 p-4 justify-between">
        <div class="flex flex-row justify-between">
          <div class="flex flex-row gap-4">
            <p>{{ bet.title }}</p>
            <p>{{ bet.odd }}</p>
          </div>

          <button @click="() => {
            betStore.removeBet(bet);
          }">X</button>            
        </div>

        <div class="flex flex-row">
          <input type="number" class="w-full border border-3 p-2" placeholder="Amount" v-model="amount[bet.id]" />
          <button
            class="bg-green-500 hover:bg-green-300 w-[100px]"
            @click="() => {
              newBet(bet.id, amount[bet.id]);
              betStore.removeBet(bet);
              useAuthStore().me();
              match(id)
            }"
          >Place bet</button>
        </div>
      </div>
    </div>
  </div>
</template>