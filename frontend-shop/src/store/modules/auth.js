import Api from "../../api/Api";

const auth = {
  namespaced: true,

  state: {
    token: localStorage.getItem("token") || "",
    user: JSON.parse(localStorage.getItem("user")) || {},
    profile: {},
  },

  mutations: {
    AUTH_SUCCESS(state, token, user) {
      state.token = token;
      state.user = user;
    },

    GET_USER(state, user) {
      state.user = user;
    },

    AUTH_LOGOUT(state) {
      state.token = "";
      state.user = {};
      state.profile = {};
    },
    SET_USER(state, profile) {
      state.profile = profile;
    },
  },
  actions: {
    register({ commit }, user) {
      return new Promise((resolve, reject) => {
        Api.post("/register", {
          username: user.username,
          first_name: user.first_name,
          last_name: user.last_name,
          phone: user.phone,
          post_code: user.post_code,
          address: user.address,
          country: user.countryName,
          states: user.statesName,
          city: user.cityName,
          email: user.email,
          password: user.password,
          password_confirmation: user.password_confirmation,
        })
          .then((response) => {
            const token = response.data.token;
            const user = response.data.data;
            localStorage.setItem("token", token);
            localStorage.setItem("user", JSON.stringify(user));

            Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

            commit("AUTH_SUCCESS", token, user);
            commit("GET_USER", user);
            resolve(response);
          })
          .catch((error) => {
            localStorage.removeItem("token");
            reject(error.response.data);
          });
      });
    },

    login({ commit }, user) {
      return new Promise((resolve, reject) => {
        Api.post("/login", {
          email: user.email,
          password: user.password,
        })
          .then((response) => {
            const token = response.data.token;
            const user = response.data.data;

            localStorage.setItem("token", token);
            localStorage.setItem("user", JSON.stringify(user));

            Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

            commit("AUTH_SUCCESS", token, user);

            commit("GET_USER", user);

            resolve(response);
          })
          .catch((error) => {
            localStorage.removeItem("token");
            reject(error.response.data);
          });
      });
    },

    logout({ commit }) {
      return new Promise((resolve) => {
        commit("AUTH_LOGOUT");

        localStorage.removeItem("token");
        localStorage.removeItem("user");

        delete Api.defaults.headers.common["Authorization"];

        resolve();
      });
    },
  },

  getters: {
    currentUser(state) {
      return state.user;
    },
    isLoggedIn(state) {
      return state.token;
    },
  },
};

export default auth;
