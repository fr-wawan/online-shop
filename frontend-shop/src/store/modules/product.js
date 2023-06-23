import Api from "../../api/Api";

const product = {
  namespaced: true,

  state: {
    products: [],
    popularProducts: [],
    nextExists: false,
    nextPage: 0,
    product: {},
  },

  mutations: {
    SET_PRODUCT(state, data) {
      state.products = data;
    },
    SET_POPULAR(state, data) {
      state.popularProducts = data;
    },
    SET_NEXTEXISTS(state, nextExists) {
      state.nextExists = nextExists;
    },
    SET_NEXTPAGE(state, nextPage) {
      state.nextPage = nextPage;
    },
    SET_DETAILS(state, product) {
      state.product = product;
    },
    SET_LOADMORE(state, data) {
      data.forEach((row) => {
        state.products.push(row);
      });
    },
  },

  actions: {
    getProduct({ commit }) {
      Api.get("/product/newest")
        .then((response) => {
          commit("SET_PRODUCT", response.data.data.data);

          if (response.data.data.current_page < response.data.data.last_page) {
            commit("SET_NEXTEXISTS", true);
            commit("SET_NEXTPAGE", response.data.data.current_page + 1);
          } else {
            commit("SET_NEXTEXISTS", false);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getPopularProduct({ commit }) {
      Api.get("/product")
        .then((response) => {
          commit("SET_POPULAR", response.data.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getDetailsProduct({ commit }, slug) {
      Api.get(`/product/${slug}`)
        .then((response) => {
          commit("SET_DETAILS", response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getLoadMore({ commit }, nextPage) {
      Api.get(`/product/newest?page=${nextPage}`).then((response) => {
        commit("SET_LOADMORE", response.data.data.data);

        if (response.data.data.current_page < response.data.data.last_page) {
          commit("SET_NEXTEXISTS", true);
          commit("SET_NEXTPAGE", response.data.data.current_page + 1);
        } else {
          commit("SET_NEXTEXISTS", false);
        }
      });
    },
  },
};

export default product;
