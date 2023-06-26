import Api from "../../api/Api";

const paginationProduct = {
  namespaced: true,

  state: {
    products: [],
    currentPage: 1,
    totalPages: 1,
  },

  mutations: {
    SET_PRODUCTS(state, data) {
      state.products = data.data;
      state.currentPage = data.current_page;
      state.totalPages = data.last_page;
    },
  },

  actions: {
    getProducts({ commit }, page = 1) {
      Api.get(`/product/newest?page=${page}`)
        .then((response) => {
          commit("SET_PRODUCTS", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getProductsByFilter({ commit }, category_id) {
      Api.get(`/product/newest?category_id=${category_id}`)
        .then((response) => {
          commit("SET_PRODUCTS", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};

export default paginationProduct;
