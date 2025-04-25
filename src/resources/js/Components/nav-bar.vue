<script setup>
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";
import { ref, reactive, computed, onMounted } from "vue";

import axios from "axios";
import Swal from "sweetalert2";
import moment from "moment";
import { useStore } from "vuex";
import { Loader } from "@googlemaps/js-api-loader";

const store = useStore();
const breakpoints = useBreakpoints(breakpointsTailwind);
const lgAndSmaller = breakpoints.smallerOrEqual("md");

const state = reactive({
    text: null,
    flag: null,
    value: null,
    currentUser: {},
    currentLink: "",
    searchWithIn: "Users",
    searchText: "",
});

//using vuex
const searchValue = computed(() => {
    const searchVal = store.getters["LoggedInUser/getSearchVal"];
    return searchVal;
});
const isSearching = computed(() => {
    const searchVal = store.getters["LoggedInUser/getIsSearching"];
    return searchVal;
});

const vFocus = {
    mounted: (el) => {
        if (searchValue.value.length > 3) {
            el.focus();
        }
    },
};

const userDetails = computed(() => {
    const store = useStore();
    return store.getters["LoggedInUser/getUserDetails"];
});

const allRoles = computed(() => {
    const allUserRoles = usePage().props.auth.user.roles.map(
        (role) => role.name
    );
    return allUserRoles;
});
const allPermissions = computed(() => {
    const allPermissions = usePage().props.auth.user.allPermissions;
    return allPermissions;
});

const dashboardView = computed(() => {
    let showDashboard = import.meta.env.VITE_COUNTRY_OFFICE;
    let isToShow = 0;
    switch (showDashboard) {
        case "Uganda":
            isToShow = 2;
            break;
        default:
            isToShow = 1;
            break;
    }
    return isToShow;
});

onMounted(() => {
    state.currentUser = usePage().props.auth.user;
    router.reload();
});

function logout() {
    // router.post(route("logout"));
    router.visit("/logout", {
        method: "post",
    });
}

function toggleMenu() {
    this.$parent.toggleMenu();

}
function toggleRightSidebar() {
    this.$parent.toggleRightSidebar();
}

function downloadApk() {
    const fileUrl = `/FRONTROW_V1.0.1.apk`;

    const a = document.createElement("a");
    a.href = fileUrl;
    a.download = "FRONTROW_V1.0.1.apk";
    document.body.appendChild(a);
    a.click();
    URL.revokeObjectURL(fileURL);
    document.body.removeChild(a);
}

function initFullScreen() {
    document.body.classList.toggle("fullscreen-enable");
    if (
        !document.fullscreenElement &&
        /* alternative standard method */ !document.mozFullScreenElement &&
        !document.webkitFullscreenElement
    ) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(
                Element.ALLOW_KEYBOARD_INPUT
            );
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}

function formatDate(theDate) {
    return moment(theDate).fromNow();
}
function goToSearch($event) {
    const searchVal = $event.target.value;
    store.commit("LoggedInUser/setSearchVal", searchVal);
    if (searchVal.length > 3) {
        store.commit("LoggedInUser/setSearching", true);
        router.visit(`/search`);
    } else {
        store.commit("LoggedInUser/setSearching", false);
    }
}
</script>

<template>
    <header id="page-topbar">
        <div class="navbar-header" style="background-color: #01676c">
            <div class="d-flex">
                <!-- LOGO -->
                <div
                    class="navbar-brand-box d-flex align-items-center justify-content-center"
                >
                    <Link :href="route('landing')">
                        <div class="avatar-sm">
                            <span class="avatar-title rounded-circle bg-light">
                                <img
                                    src="@/images/logos/small2.png"
                                    class="avatar-title rounded-circle"
                                    style="background-color: #ffffff"
                                    alt
                                    height="70"
                                />
                            </span>
                        </div>
                    </Link>
                </div>

                <button
                    v-show="lgAndSmaller"
                    id="vertical-menu-btn "
                    type="button"
                    class="px-3 btn btn-sm font-size-16 header-item mobilehumburgeMenu"
                    @click="toggleMenu"
                >
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input
                            type="text"
                            class="form-control"
                            id="searched_place"
                            :placeholder="'Search '"
                            @input="goToSearch"
                            :value="searchValue"
                            v-focus
                        />
                        <span class="bx bx-search-alt"></span>
                    </div>
                </form>
            </div>

            <div class="d-flex" style="color: #f3f3f9">
                <b-dropdown
                    class="ml-2 d-inline-block d-lg-none"
                    variant="black"
                    menu-class="p-0 dropdown-menu-lg dropdown-menu-end"
                    toggle-class="header-item noti-icon"
                    right
                >
                    <template v-slot:button-content>
                        <i class="mdi mdi-magnify"></i>
                    </template>

                    <form class="p-3">
                        <div class="m-0 form-group">
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="searched_place"
                                    placeholder="Search Weather"
                                />
                                <div class="input-group-append">
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </b-dropdown>

                <div class="ml-1 dropdown d-none d-lg-inline-block">
                    <button
                        type="button"
                        class="btn header-item noti-icon"
                        @click="initFullScreen"
                    >
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>

                <b-dropdown
                    right
                    variant="black"
                    toggle-class="header-item"
                    menu-class="dropdown-menu-end"
                >
                    <template v-slot:button-content>
                        <!-- <img class="rounded-circle header-profile-user" :src="avatar1" alt="Header Avatar" /> -->
                        <img
                            :src="state.currentUser.profile_photo_url"
                            :alt="'p'"
                            class="rounded-circle header-profile-user object-fit-cover"
                        />

                        <span
                            class="d-none d-xl-inline-block ms-1"
                            style="color: #f3f3f9"
                            >{{ state.currentUser.name }}</span
                        >
                        <!-- <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i> -->
                    </template>
                    <!-- item-->
                    <Link :href="route('profile.show')">
                        <b-dropdown-item>
                            <i
                                class="p-1 align-middle bx bx-user font-size-16 me-1"
                                style="
                                    color: #639099;
                                    background-color: #e0e8f1;
                                    border-radius: 50%;
                                "
                            ></i>

                            My Profile
                            <!-- {{ $t("navbar.dropdown.henry.list.profile") }} -->
                        </b-dropdown-item>
                    </Link>
                    <!-- <b-dropdown-item href="javascript: void(0);">
                        <i
                            class="p-1 align-middle bx bxs-report font-size-16 me-1"
                            style="
                                color: #639099;
                                background-color: #e0e8f1;
                                border-radius: 50%;
                            "
                        ></i>
                        Reports
                    </b-dropdown-item> -->
                    <Link :href="route('landing')">
                        <b-dropdown-item href="javascript: void(0);">
                            <i
                                class="p-1 align-middle bx bxs-home font-size-16 me-1"
                                style="
                                    color: #639099;
                                    background-color: #e0e8f1;
                                    border-radius: 50%;
                                "
                            ></i>
                            Return to Home
                            <!-- {{ $t("navbar.dropdown.henry.list.mywallet") }} -->
                        </b-dropdown-item>
                    </Link>

                    <Link>
                        <b-dropdown-item @click="downloadApk">
                            <i
                                class="p-1 align-middle bx bx-mobile font-size-16 me-1"
                                style="
                                    color: #639099;
                                    background-color: #e0e8f1;
                                    border-radius: 50%;
                                "
                            ></i>
                            Mobile App
                            <!-- {{ $t("navbar.dropdown.henry.list.mywallet") }} -->
                        </b-dropdown-item>
                    </Link>

                    <b-dropdown-divider></b-dropdown-divider>
                    <a
                        @click="logout"
                        class="dropdown-item text-danger"
                        role="button"
                    >
                        <i
                            class="p-1 align-middle mdi mdi-login-variant font-size-16 me-1 text-danger"
                        ></i>
                        Logout
                    </a>
                </b-dropdown>
            </div>
        </div>
    </header>
</template>
