import Api from "../../api/Api";

const category = {
  namespaced: true,

  state: {
    categories: [],
  },

  mutations: {
    SET_CATEGORY(state, data) {
      state.categories = data;
    },
  },

  actions: {
    getCategory({ commit }) {
      Api.get("/category")
        .then((response) => {
          commit("SET_CATEGORY", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  getters: {},
};

export default category;
