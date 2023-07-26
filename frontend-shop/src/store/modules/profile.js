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
    async updateProfile({ commit }, formData) {
      try {
        const token = localStorage.getItem("token");
        Api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        const response = await Api.post("/profile",formData);

        const user = response.data.data;
        localStorage.setItem("user",JSON.stringify(user));

        commit("SET_PROFILE",response.data.data);

        return response;
      } catch (error) {
        throw error.response.data;
      }
    },

    async updatePassword({ commit }, userPassword) {
      try {        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        const response = await Api.post("/profile/password",{
          password : userPassword.password,
          password_confirmation : userPassword.password_confirmation
        })

        commit("SET_PROFILE",response.data.data);

        return response;
      } catch (error) {
        throw error.response.data;
      }
    },
  },

  getters: {},
};

export default profile;
