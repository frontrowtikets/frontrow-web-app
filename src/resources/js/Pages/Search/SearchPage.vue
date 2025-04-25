<script setup>
import PageHeader from "@/js/Components/page-header.vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import { reactive, onMounted, onUnmounted, computed, ref } from "vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import MovieCard from "../../Components/MovieCard.vue";
import EventCard from "../../Components/EventCard.vue";
import { useStore } from "vuex";
import icondata from "@/images/icondata.png";
import axios from "axios";


const store = useStore();

const state = reactive({
    items: [
        {
            text: "Dashboard",
        },
        {
            text: "Movies",
            active: true,
        },
    ],
});
const searchResults = ref([]);


const isSearching = computed(() => {
    const searchVal = store.getters["LoggedInUser/getIsSearching"];
    return searchVal;
});

const searchValue = computed(() => {
    const searchVal = store.getters["LoggedInUser/getSearchVal"];
    return searchVal;
});

onMounted(() => {
    searchItems();
});

onUnmounted(() => {
    store.commit("LoggedInUser/setSearching", false);
});

function searchItems() {
    store.commit("LoggedInUser/setSearching", true);

    if (searchValue.value.length > 3) {
        axios
            .post("api/search", { searchVal: searchValue.value })
            .then((res) => {
                searchResults.value = res.data.results;
                store.commit("LoggedInUser/setSearching", false);
            })
            .catch((e) => {
                console.log("err", e);
                store.commit("LoggedInUser/setSearching", false);
            });
    }
}
function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}
function viewMovie(title, id) {
    router.visit(`/movie/${slugify(title)}/${id}`);
}
function viewEvent(title, id) {
    router.visit(`/event/${slugify(title)}/${id}`);
}
</script>
<template>
    <Head title="Search" />
    <DashboardLayout>
        <PageHeader title="Search Results" :items="state.items" />
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <b-container>

                         <div v-if="isSearching" class="mt-5 d-flex align-items-center justify-content-center" style="height: 50vh">
                        <div><i class="bx bx-hourglass bx-spin me-2"></i> Searching ...</div>
                    </div>
                    <div v-else>
                        <div v-if="searchResults?.events?.length === 0 && searchResults?.movies?.length === 0">
                            <div class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                <div>No Results Found.</div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="flex-wrap gap-4 pt-4 d-flex align-items-center justify-content-center">
                                <div v-for="(item, index) in searchResults?.movies" :key="index" class="col-xl-3 col-md-4 col-sm-6">
                                    <MovieCard
                                        :movieName="item.title"
                                        :movieImageLink="item.thumbnail_url"
                                        :movieDate="item.release_date"
                        :viewing_format="item.viewing_format"

                                        :movieId="item.id"
                                        :showTimes="item.show_times"
                                        :overallRating="item.overallRating"
                                        @view="viewMovie"
                                    />
                                </div>
                                <div v-for="(item, index) in searchResults?.events" :key="index" class="col-xl-3 col-md-4 col-sm-6">
                                    <EventCard
                                        :eventName="item.title"
                                        :eventImageLink="item.thumbnail_url"
                                        :eventDate="item.start_date"
                                        :eventLocation="item.location_name"
                                        :eventId="item.id"
                                        :eventTickets="item.event_tickets"
                                        @view="viewEvent"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    </b-container>
                </div>
            </div>
        </div></DashboardLayout
    >
</template>
