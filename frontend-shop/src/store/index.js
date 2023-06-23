import { createStore } from "vuex";
import auth from "./modules/auth";
import profile from "./modules/profile";
import product from "./modules/product";
import category from "./modules/category";
import paginationProduct from "./modules/paginationProduct";
import cart from "./modules/cart";

export default createStore({
  modules: {
    auth,
    profile,
    product,
    category,
    paginationProduct,
    cart,
  },
});
