<script>
import { MetisMenu } from "metismenujs";

import { menuItems } from "./menu";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import IsUserAdmin from "../Composables/IsUserAdmin.js";

/**
 * Sidenav component
 */
export default {
    setup() {
        //check whether user is admin
        const { isAdmin } = IsUserAdmin();
        return {
            usePage,
            isAdmin,
        };
    },
    data() {
        return {
            menuItems: menuItems,
            menuData: null,
        };
    },
    mounted: function () {
        //
        if (document.getElementById("side-menu")) new MetisMenu("#side-menu");
        var links = document.getElementsByClassName("side-nav-link-ref");
        var matchingMenuItem = null;
        const paths = [];

        for (var i = 0; i < links.length; i++) {
            paths.push(links[i]["pathname"]);
        }
        var itemIndex = paths.indexOf(window.location.pathname);
        if (itemIndex === -1) {
            const strIndex = window.location.pathname.lastIndexOf("/");
            const item = window.location.pathname
                .substr(0, strIndex)
                .toString();
            matchingMenuItem = links[paths.indexOf(item)];
        } else {
            matchingMenuItem = links[itemIndex];
        }
        if (matchingMenuItem) {
            matchingMenuItem.classList.add("active");
            var parent = matchingMenuItem.parentElement;

            /**
             * TODO: This is hard coded way of expading/activating parent menu dropdown and working till level 3.
             * We should come up with non hard coded approach
             */
            if (parent) {
                parent.classList.add("mm-active");
                const parent2 = parent.parentElement.closest("ul");
                if (parent2 && parent2.id !== "side-menu") {
                    parent2.classList.add("mm-show");

                    const parent3 = parent2.parentElement;
                    if (parent3) {
                        parent3.classList.add("mm-active");
                        var childAnchor = parent3.querySelector(".has-arrow");
                        var childDropdown =
                            parent3.querySelector(".has-dropdown");
                        if (childAnchor) childAnchor.classList.add("mm-active");
                        if (childDropdown)
                            childDropdown.classList.add("mm-active");

                        const parent4 = parent3.parentElement;
                        if (parent4 && parent4.id !== "side-menu") {
                            parent4.classList.add("mm-show");
                            const parent5 = parent4.parentElement;
                            if (parent5 && parent5.id !== "side-menu") {
                                parent5.classList.add("mm-active");
                                const childanchor =
                                    parent5.querySelector(".is-parent");
                                if (childanchor && parent5.id !== "side-menu") {
                                    childanchor.classList.add("mm-active");
                                }
                            }
                        }
                    }
                }
            }
        }
    },
    methods: {
        /**
         * Returns true or false if given menu item has child or not
         * @param item menuItem
         */
        hasItems(item) {
            return item.subItems !== undefined
                ? item.subItems.length > 0
                : false;
        },

        toggleMenu(event) {
            event.currentTarget.nextElementSibling.classList.toggle("mm-show");
        },
        toRouterRegister() {
            document.body.classList.toggle("sidebar-enable");
            router.get(route("userRegister"));
        },
        toRouterDashboard() {
            document.body.classList.toggle("sidebar-enable");
            router.get(route("dashboard"));
        },
        toRouterEvents() {
            document.body.classList.toggle("sidebar-enable");
            router.get(route("my_events_page"));
        },
        toRouterMovies() {
            document.body.classList.toggle("sidebar-enable");
            router.get(route("my_movies_page"));
        },
        toRouterSettings() {
            document.body.classList.toggle("sidebar-enable");
            router.get(route("settings"));
        },
        toTransactions() {
            document.body.classList.toggle("sidebar-enable");
            router.get(route("my_transactions"));
        },
        toWallet() {
            document.body.classList.toggle("sidebar-enable");
            router.get(route("my_wallet"));
        },
        toTickets() {
            document.body.classList.toggle("sidebar-enable");
            router.get(route("my_tickets"));
        },
        toRouterActivations(){
            document.body.classList.toggle("sidebar-enable");
            router.get(route("activations"));
        }
    },
};
</script>

<template>
    <!-- ========== Left Sidebar Start ========== -->

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul id="side-menu" class="metismenu list-unstyled">
            <li class="" role="button">
                <a>
                    <i class="bx bxs-dashboard" style="color: #fff"></i>
                    <span
                        @click="toRouterDashboard"
                        :class="
                            usePage().url == '/dashboard'
                                ? 'text-white fw-bold'
                                : 'text-grayish'
                        "
                        >Dashboard</span
                    >
                </a>
            </li>
            <li class="" role="button" v-if="isAdmin == true">
                <a>
                    <i class="bx bx-user-pin" style="color: #fff"></i>
                    <span
                        :class="
                            usePage().url == '/userregister'
                                ? 'text-white fw-bold'
                                : 'text-grayish'
                        "
                        @click="toRouterRegister"
                        >Users</span
                    >
                </a>
            </li>
            <li class="" role="button" v-if="isAdmin == true">
                <a>
                    <i class="bx bx-bolt-circle" style="color: #fff"></i>
                    <span
                        :class="
                            usePage().url == '/activations'
                                ? 'text-white fw-bold'
                                : 'text-grayish'
                        "
                        @click="toRouterActivations"
                        >Activations</span
                    >
                </a>
            </li>
            <li class="" role="button">
                <a>
                    <i class="mdi mdi-ticket" style="color: #ffffff"></i>
                    <span
                        :class="
                            usePage().url == '/mytickets'
                                ? 'text-white fw-bold'
                                : 'text-grayish'
                        "
                        @click="toTickets"
                        >My Tickets</span
                    >
                </a>
            </li>
            <li class="" role="button">
                <a>
                    <i class="bx bx-play-circle" style="color: #fff"></i>
                    <span
                        :class="
                            usePage().url == '/mymovies' ||
                            usePage().url == '/schedulemovies'
                                ? 'text-white fw-bold'
                                : 'text-grayish'
                        "
                        @click="toRouterMovies"
                        >My Movies</span
                    >
                </a>
            </li>
            <li class="" role="button">
                <a>
                    <i class="mdi mdi-movie-roll" style="color: #fff"></i>
                    <span
                        :class="
                            usePage().url == '/myevents' ||
                            usePage().url == '/scheduleevents'
                                ? 'text-white fw-bold'
                                : 'text-grayish'
                        "
                        @click="toRouterEvents"
                        >My Events</span
                    >
                </a>
            </li>

            <li class="" role="button">
                <a>
                    <i class="bx bx-money" style="color: #fff"></i>
                    <span
                        :class="
                            usePage().url == '/mywallet'
                                ? 'text-white fw-bold'
                                : 'text-grayish'
                        "
                        @click="toWallet"
                        >My Wallet</span
                    >
                </a>
            </li>
            <li class="" role="button">
                <a>
                    <i class="bx bxs-report" style="color: #fff"></i>
                    <span
                        :class="
                            usePage().url == '/mytransactions'
                                ? 'text-white fw-bold'
                                : 'text-grayish'
                        "
                        @click="toTransactions"
                        >{{isAdmin?'Transactions':'My Transactions'}}</span
                    >
                </a>
            </li>
            <li class="" role="button" v-if="isAdmin == true">
                <a>
                    <i class="bx bxs-cog" style="color: #fff"></i>
                    <span
                        :class="
                            usePage().url == '/settings'
                                ? 'text-white fw-bold'
                                : 'text-grayish'
                        "
                        @click="toRouterSettings"
                        >Settings</span
                    >
                </a>
            </li>
        </ul>
    </div>
    <!-- Sidebar -->
</template>
