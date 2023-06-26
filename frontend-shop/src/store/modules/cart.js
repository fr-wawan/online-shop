import Api from "../../api/Api";
const cart = {
  namespaced: true,

  state: {
    carts: [],
    count: {},
  },
  mutations: {
    SET_CART(state, cart) {
      state.carts = cart;
    },
    SET_COUNT(state, count) {
      state.count = count;
    },
  },
  actions: {
    getCart({ commit }) {
      const token = localStorage.getItem("token");

      Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      Api.get("/cart")
        .then((response) => {
          commit("SET_CART", response.data.data);
          commit("SET_COUNT", response.data.count);
        })
        .catch((error) => {
          if (error.response && error.response.status === 401) {
            return;
          }
          console.log(error);
        });
    },
    storeCart({ dispatch }, formData) {
      return new Promise((resolve, reject) => {
        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        Api.post("/cart", formData)
          .then((response) => {
            dispatch("getCart");
            resolve(response);
          })
          .catch((error) => {
            reject(error.response.data);
          });
      });
    },
    async updateCart({ commit }, formData) {
      try {
        const token = localStorage.getItem("token");
        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        const response = await Api.put(`/cart/${formData.id}`, formData);

        return response;
      } catch (error) {
        throw error;
      }
    },

    async deleteCart({ dispatch }, cart) {
      try {
        const token = localStorage.getItem("token");
        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        const response = await Api.delete(`/cart/${cart.id}`);

        dispatch("getCart");

        return response;
      } catch (error) {
        throw error.response.data;
      }
    },
  },

  getters: {
    cartTotal: (state) => {
      return state.carts
        .reduce((acc, cart) => {
          return cart.quantity * cart.product.price + acc;
        }, 0)
        .toFixed(2);
    },
  },
};

export default cart;
