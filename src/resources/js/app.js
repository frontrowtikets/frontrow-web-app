import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import helper from "./mixins/layouts.mixin";
import Vuelidate from "vuelidate";
import vSelect from "vue-select";
import { MotionPlugin } from "@vueuse/motion";

import Vue3Signature from "vue3-signature";

import { BootstrapVueNext } from "bootstrap-vue-next";

import "bootstrap-vue-next/dist/bootstrap-vue-next.css";
import "leaflet/dist/leaflet.css";

//importing the vuex store
import store from "./state/store.js";

// state management
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

//WYSIWYG editor
import CKEditor from "@ckeditor/ckeditor5-vue";

const appName = import.meta.env.VITE_APP_NAME || "FRONTROW";

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        //registering mixins
        app.mixin(helper);

        //global properties
        app.config.globalProperties.$route = route;

        const options = {};

        return app.use(Toast, options).use(MotionPlugin).use(plugin).use(store).use(ZiggyVue).use(vSelect).use(Vuelidate).use(vSelect).use(Vue3Signature).use(BootstrapVueNext).use(CKEditor).mount(el);
    },
    progress: {
        color: "#01B3BD",
    },
});
