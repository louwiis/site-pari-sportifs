import axios from "axios";

const instance = axios.create({
  baseURL: "http://localhost:8000/",
});

instance.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");

  config.headers = {
    ...config.headers,
    Authorization: `Bearer ${token}`,
    "Access-Control-Allow-Origin": "*",
  };

  return config;
});

export { instance };
