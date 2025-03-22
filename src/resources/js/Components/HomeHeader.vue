<script setup>
import { Link, usePage, router } from "@inertiajs/vue3";
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useStore } from "vuex";

const breakpoints = useBreakpoints(breakpointsTailwind);
const greaterThanMd = breakpoints.greater("md");

const store = useStore();
const isMenuOpen = ref(false);
const searchVal = ref("");
const showSearch = ref(false);

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

onMounted(() => {
    if (searchValue.value.length > 0) {
        showSearch.value = true
    }
})

function toggleMenu() {
    document.getElementById("topnav-menu-content").classList.toggle("show");
    isMenuOpen.value = !isMenuOpen.value;
}

function goHome() {
    router.visit("/");
    //TODO: Add using v-motions
}

function goEvents() {
    router.visit("/myevents");
}
function goCinema() {
    router.visit("/mytickets");
}
function goToEventsPage() {
    router.visit("/events");
}
function goToMoviesPage() {
    router.visit("/movies");
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
    <nav class="sticky navbar navbar-expand-lg navigation fixed-top" id="navbar">
        <b-container class="pb-1 mt-4 mb-2 rounded shadow-lg bg-primary" style="position: relative">
            <a class="navbar-logo" href="/">
                <img src="../../images/logos/logo6.png" alt height="40" class="logo logo-dark" />
                <img src="../../images/logos/logo6.png" alt height="40" class="logo logo-light" />
            </a>

            <button type="button" class="px-3 btn btn-sm font-size-16 d-lg-none header-item" data-toggle="collapse"
                @click="toggleMenu()">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="topnav-menu-content" v-motion :initial="{ opacity: 1 }"
                :enter="{ opacity: 1 }" :delay="0" :duration="100">
                <ul class="navbar-nav ms-auto" id="topnav-menu" v-scroll-spy-active="{ selector: 'a.nav-link' }">
                    <li class="pt-1 text-center nav-item" role="button" @click="showSearch = !showSearch"
                        v-if="greaterThanMd">
                        <a class="nav-link">
                            <span class=" bx bx-search-alt" style="font-size: large"></span>
                        </a>
                    </li>
                    <li class="nav-item" role="button" @click="goHome">
                        <a class="nav-link">Home</a>
                    </li>
                    <li class="nav-item" role="button" @click="goToMoviesPage">
                        <a class="nav-link">Movies</a>
                    </li>
                    <li class="nav-item" role="button" @click="goToEventsPage">
                        <a class="nav-link">Events</a>
                    </li>

                    <li class="nav-item" role="button" @click="goCinema">
                        <a class="nav-link">My Tickets</a>
                    </li>
                    <li class="nav-item" role="button" @click="goEvents">
                        <a class="nav-link">Create Event</a>
                    </li>
                </ul>
                <Link :href="route('dashboard')" class="fw-medium" v-if="usePage().props.auth.user">
                <b-button variant="light" class="w-md" pill>
                    My Dashboard</b-button>
                </Link>

                <Link :href="route('login')" class="fw-medium" v-else>
                <b-button variant="secondary" class="w-md" pill>
                    Sign In</b-button>
                </Link>
            </div>
            <div v-if="greaterThanMd" class="" :style="{
                position: 'absolute',
                top: '65%',
                width: '50%',
                left: '25%',
            }">
                <div class="col-12" v-if="showSearch || isSearching" v-motion :initial="{ opacity: 0, y: 10 }"
                    :enter="{ opacity: 1, y: 0, scale: 1 }" :duration="200">
                    <form class="app-search">
                        <div class="position-relative">
                            <input type="text" class="pt-4 pb-4 shadow-lg form-control" id="searched_place"
                                :placeholder="'Search'" @input="goToSearch" :value="searchValue" v-focus />

                            <span class="pt-1 pb-1 bx bx-search-alt"></span>
                            <span style="left: 93%" class="mt-2" v-if="isSearching">
                                <i class="bx bx-loader bx-spin font-size-16"></i></span>
                        </div>
                    </form>
                </div>
            </div>
            <div v-else class="" :style="{
                position: 'absolute',
                top: '70%',
                width: '90%',
                left: '5%',
            }">
                <div class="col-12" v-if="isMenuOpen === false">
                    <form class="app-search">
                        <div class="position-relative">
                            <input type="text" class="form-control" id="searched_place" :placeholder="'Search'" />
                            <span class="bx bx-search-alt"></span>
                        </div>
                    </form>
                </div>
            </div>
        </b-container>
    </nav>
</template>
<style scoped>
.nav-link:hover {
    color: #fff !important;
    /* Text color on hover */
}
</style>
