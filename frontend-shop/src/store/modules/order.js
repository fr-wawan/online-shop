import Api from "../../api/Api";

const order = {
  namespaced: true,

  state: {
    orders: [],
    order: {},
  },

  mutations: {
    SET_ORDERS(state, orders) {
      state.orders = orders;
    },
    SET_DETAILS(state, order) {
      state.order = order;
    },
  },

  actions: {
    async getOrders({ commit }) {
      const token = localStorage.getItem("token");

      Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      await Api.get("/transaction")
        .then((response) => {
          commit("SET_ORDERS", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
     detailsProduct({ commit }, invoice) {
      const token = localStorage.getItem("token");

      Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

       Api.get(`/transaction/${invoice}`)
        .then((response) => {
          commit("SET_DETAILS", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async storeOrder({ dispatch }, { formData, paymentMethod }) {
      try {
        const token = localStorage.getItem("token");

        Api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        const response = await Api.post(
          `/transaction/${paymentMethod}`,
          formData
        );

        await dispatch("cart/getCart", null, { root: true });
        return response.data.data;
      } catch (error) {
        throw error;
      }
    },
  },

  getters: {},
};

export default order;
