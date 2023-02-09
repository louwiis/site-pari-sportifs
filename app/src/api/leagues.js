import { instance } from "./index";
import { useMatchesStore } from "@/stores/matches.js";

export async function leagues() {
  return instance
    .get("/leagues")
    .then((response) => {
      useMatchesStore().setLeagues(response.data);

      return response.data;
    });
}

export async function createLeague(country, name) {
  return instance
    .post("/leagues", {
      country,
      name
    })
    .then((response) => {
      return response.data;
    });
}