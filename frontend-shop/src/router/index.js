import { createRouter, createWebHistory } from "vue-router";

import store from "../store";

const routes = [
  {
    path: "/register",
    name: "register",
    component: () => import("../views/auth/Register.vue"),
  },
  {
    path: "/login",
    name: "login",
    component: () => import("../views/auth/Login.vue"),
  },
  {
    path: "/dashboard",
    name: "dashboard",
    component: () => import("../views/dashboard/Dashboard.vue"),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/profile",
    name: "profile",
    component: () => import("../views/profile/Profile.vue"),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/orders",
    name: "orders",
    component: () => import("../views/order/Order.vue"),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/orders/:invoice",
    name: "detailsOrder",
    component: () => import("../views/order/DetailsOrder.vue"),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/",
    name: "home",
    component: () => import("../views/Home/Home.vue"),
  },
  {
    path: "/product/:slug",
    name: "detailsProduct",
    component: () => import("../views/home/DetailsProduct.vue"),
  },
  {
    path: "/shop",
    name: "shop",
    component: () => import("../views/shop/Shop.vue"),
  },
  {
    path: "/about",
    name: "about",
    component: () => import("../views/about/About.vue"),
  },
  {
    path: "/contact",
    name: "contact",
    component: () => import("../views/contact/Contact.vue"),
  },
  {
    path: "/cart",
    name: "cart",
    component: () => import("../views/cart/Cart.vue"),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/checkout",
    name: "checkout",
    component: () => import("../views/checkout/Checkout.vue"),
    meta: {
      requiresAuth: true,
    },
  },
];

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { top: 0 };
    }
  },
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (store.getters["auth/isLoggedIn"]) {
      next();
      return;
    }
    next("/login");
  } else {
    next();
  }
});

export default router;
