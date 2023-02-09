import { instance } from "./index";
import { useAuthStore } from "@/stores/auth.js";

export async function login(email, password) {
  return instance
    .post("/auth/login", {
      email,
      password,
    })
    .then((response) => {
      useAuthStore().login(response.data.access_token);
      localStorage.setItem("token", response.data.access_token);

      return response;
    });
}

export async function register(name, email, password, password_confirmation) {
  return instance
    .post("/auth/register", {
      name,
      email,
      password,
      password_confirmation,
    })
    .then((response) => {
      useAuthStore().login(response.data.access_token);
      localStorage.setItem("token", response.data.access_token);

      return response;
    });
}

export async function me() {
  return instance.get("/auth/me").then((response) => {
    useAuthStore().user = response.data;
    return response.data;
  });
}
