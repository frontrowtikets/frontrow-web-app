import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import helper from "./mixins/layouts.mixin";
import vSelect from "vue-select";
import { MotionPlugin } from "@vueuse/motion";

//importing the vuex store
import store from "./state/store.js";

// toast notifications
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        //registering mixins
        app.mixin(helper);

        //global properties
        app.config.globalProperties.$route = route;

        return app
            .use(Toast, {})
            .use(MotionPlugin)
            .use(plugin)
            .use(store)
            .use(ZiggyVue)
            .use(vSelect)
            .mount(el);
    },
    progress: {
        color: "#01B3BD",
    },
});
