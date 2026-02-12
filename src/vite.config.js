import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { VitePWA } from "vite-plugin-pwa";
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
        VitePWA({
            registerType: "autoUpdate",
            injectRegister: null,
            manifest: false,
            workbox: {
                globPatterns: ["**/*.{js,css,html,ico,png,svg,woff,woff2}"],
                navigateFallback: null,
                runtimeCaching: [
                    {
                        urlPattern: /^https:\/\/fonts\.(googleapis|gstatic|bunny)\.net\/.*/i,
                        handler: "CacheFirst",
                        options: {
                            cacheName: "google-fonts",
                            expiration: { maxEntries: 20, maxAgeSeconds: 365 * 24 * 60 * 60 },
                        },
                    },
                    {
                        urlPattern: /\.(?:png|jpg|jpeg|svg|gif|webp)$/i,
                        handler: "CacheFirst",
                        options: {
                            cacheName: "images",
                            expiration: { maxEntries: 100, maxAgeSeconds: 60 * 24 * 60 * 60 },
                        },
                    },
                    {
                        urlPattern: /\.(?:js|css)$/i,
                        handler: "StaleWhileRevalidate",
                        options: {
                            cacheName: "static-resources",
                            expiration: { maxEntries: 50, maxAgeSeconds: 30 * 24 * 60 * 60 },
                        },
                    },
                    {
                        urlPattern: /^https:\/\/.*\/api\/.*/i,
                        handler: "NetworkFirst",
                        options: {
                            cacheName: "api-cache",
                            networkTimeoutSeconds: 5,
                            expiration: { maxEntries: 50, maxAgeSeconds: 24 * 60 * 60 },
                        },
                    },
                ],
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
