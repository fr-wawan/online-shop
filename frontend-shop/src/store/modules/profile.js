import Api from "../../api/Api";

const profile = {
  namespaced: true,

  state: {
    profile: {},
    user: JSON.parse(localStorage.getItem("user")) || {},
  },

  mutations: {
    SET_PROFILE(state, data) {
      state.profile = data;
    },
  },

  actions: {
    getProfile({ commit }) {
      const token = localStorage.getItem("token");

      Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      Api.get("/profile")
        .then((response) => {
          commit("SET_PROFILE", response.data.data);
        })
        .catch((error) => {
          if (error.response && error.response.status === 401) {
            return;
          }

          console.log(error);
        });
    },
    updateProfile({ commit }, formData) {
      return new Promise((resolve, reject) => {
        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        Api.post("/profile", formData)
          .then((response) => {
            const user = response.data.data;
            localStorage.setItem("user", JSON.stringify(user));
            commit("SET_PROFILE", response.data.data);

            resolve(response);
          })
          .catch((error) => {
            reject(error.response.data);
          });
      });
    },

    updatePassword({ commit }, userPassword) {
      return new Promise((resolve, reject) => {
        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        Api.post("/profile/password", {
          password: userPassword.password,
          password_confirmation: userPassword.password_confirmation,
        })
          .then((response) => {
            commit("SET_PROFILE", response.data.data);

            resolve(response);
          })
          .catch((error) => {
            reject(error.response.data);
          });
      });
    },
  },

  getters: {},
};

export default profile;
