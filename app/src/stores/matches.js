import { defineStore } from 'pinia'

export const useMatchesStore = defineStore("matches", {
  state: () => ({
    matches: [],
    match: null,
    leagues: []
  }),
  actions: {
    setMatches(matches) {
      this.matches = matches
    },

    setMatch(match) {
      this.match = match
    },

    setLeagues(leagues) {
      this.leagues = leagues
    }
  }
})
