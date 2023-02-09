import { instance } from "./index";
import { match } from "./matches";

export async function newBet(betId, amount) {
  return instance
    .post(`/user-bets/${betId}`, {
      amount: amount 
    })
    .then((response) => {
      return response.data;
    });
}

export async function createBet(match_id, title, bet_lines) {
  console.log(match_id, title, bet_lines)
  return instance
    .post(`/matches/bet/${match_id}`, {
      title: title,
      bet_lines: bet_lines
    })
    .then((response) => {
      match(match_id)
      return response.data;
    });
}

export async function deleteBet(bet_id, match_id) {
  return instance
    .delete(`/matches/bet/${bet_id}`)
    .then((response) => {
      match(match_id)
      return response.data;
    });
}

export async function updateBet(bet_id, match_id, status) {
  return instance
    .put(`/matches/bet/${bet_id}`, {
      status: status
    })
    .then((response) => {
      match(match_id)
      return response.data;
    });
}