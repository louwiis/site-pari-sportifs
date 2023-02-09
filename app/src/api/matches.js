import { instance } from "./index";
import { useMatchesStore } from "@/stores/matches.js";

export async function matches() {
  return instance
    .get("/matches")
    .then((response) => {
      useMatchesStore().setMatches(response.data);

      return response.data;
    });
}

export async function match(id) {
  return instance
    .get(`/matches/${id}`)
    .then((response) => {
      useMatchesStore().setMatch(response.data);
      console.log(response.data)
      return response.data;
    });
}

export async function createMatch(home_team, away_team, start_time, league_id) {
  return instance
    .post("/matches", {
      home_team,
      away_team,
      league_id,
      start_time
    })
    .then((response) => {
      return response.data;
    });
}