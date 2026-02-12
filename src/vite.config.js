import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources"),
        },
    },
    plugins: [
        laravel({
            input: "resources/js/app.js",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                assetFileNames: "assets/[name]-[hash][extname]",
                manualChunks: {
                    vendor: ["vue", "@inertiajs/vue3"],
                    charts: ["apexcharts", "vue3-apexcharts"],
                    maps: ["@googlemaps/js-api-loader"],
                    editors: ["vue3-editor"],
                },
            },
        },
    },
});
