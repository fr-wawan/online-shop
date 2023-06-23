import { createApp } from "vue";
import App from "./App.vue";
import vueClickOutsideElement from "vue-click-outside-element";
import { MotionPlugin } from "@vueuse/motion";

/**
 * import Toastr
 */
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

/**
 * Tailwind CSS
 */
import "./style.css";

/**
 * Mixins
 */
import mixins from "./mixins";

import router from "./router";

import store from "./store";

import NProgress from "nprogress";
import "nprogress/nprogress.css";

NProgress.configure({
  showSpinner: false,
});
router.beforeEach(() => {
  NProgress.start();
});

router.afterEach(() => {
  NProgress.done();
});

const app = createApp(App);

app.use(Toast);

app.mixin(mixins);

app.use(router);

app.use(store);

app.use(vueClickOutsideElement);

app.use(MotionPlugin);

app.mount("#app");
