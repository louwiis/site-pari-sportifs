import { defineStore } from 'pinia'

export const useBetStore = defineStore("bet", {
  state: () => ({
    bets: [],
  }),
  actions: {
    addBet(bet) {
      // remove the bet if it already exists
      if (this.bets.some((b) => b.id === bet.id)) {
        this.removeBet(bet)
      } else {
        this.bets.push(bet)
      }
    },

    removeBet(bet) {
      this.bets = this.bets.filter((b) => b.id !== bet.id)
    },

    clearBets() {
      this.bets = []
    }
  }
})
