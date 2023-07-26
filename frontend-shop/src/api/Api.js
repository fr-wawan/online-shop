import axios from "axios";

const Api = axios.create({
  baseURL: "https://toko.hermawantan.com/api",
});

export default Api;
