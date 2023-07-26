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
    async register({ commit }, user) {
      try {
        const response = await Api.post("/register",{
          first_name : user.first_name,
          last_name : user.last_name,
          post_code: user.post_code,
          address: user.address,
          country: user.countryName,
          states: user.statesName,
          city: user.cityName,
          email: user.email,
          password: user.password,
          password_confirmation: user.password_confirmation,
        });
        const token = response.data.token;
        const userData = response.data.data;

        localStorage.setItem("token",token);
        localStorage.setItem("user",JSON.stringify(userData));

        Api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        commit("AUTH_SUCCESS",token,user);
        commit("GET_USER",user);

        return response;
      } catch (error) {
        localStorage.removeItem("token");
        throw error.response.data;
      }
    },

    async login({ commit }, user) {
      // return new Promise((resolve, reject) => {
      //   Api.post("/login", {
      //     email: user.email,
      //     password: user.password,
      //   })
      //     .then((response) => {
      //       const token = response.data.token;
      //       const user = response.data.data;

      //       localStorage.setItem("token", token);
      //       localStorage.setItem("user", JSON.stringify(user));

      //       Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      //       commit("AUTH_SUCCESS", token, user);

      //       commit("GET_USER", user);

      //       resolve(response);
      //     })
      //     .catch((error) => {
      //       localStorage.removeItem("token");
      //       reject(error.response.data);
      //     });
      // });

      try {
        const response = await Api.post("/login",{
          email : user.email,
          password : user.password,
        })

        const token = response.data.token;
        const userData = response.data.data;

        localStorage.setItem("token",token);
        localStorage.setItem("user",JSON.stringify(userData));

        Api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        commit("AUTH_SUCCESS",token,user);
        commit("GET_USER",user);

        return response;
      } catch (error) {
        localStorage.removeItem("token");
        throw error.response.data;
      }
    },

    logout({ commit }) {
        commit("AUTH_LOGOUT");

        localStorage.removeItem("token");
        localStorage.removeItem("user");

        delete Api.defaults.headers.common["Authorization"];
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
