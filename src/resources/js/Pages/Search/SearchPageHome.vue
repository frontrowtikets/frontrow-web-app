<script setup>
import HomeHeader from "../../Components/HomeHeader.vue";
import FooterSection from "../../Components/FooterSection.vue";
import MovieCard from "../../Components/MovieCard.vue";
import EventCard from "../../Components/EventCard.vue";
import { router } from "@inertiajs/vue3";
import { useStore } from "vuex";
import { ref, onMounted, computed, onUnmounted } from "vue";
import axios from "axios";
import icondata from "@/images/icondata.png";

const store = useStore();

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
function viewEvent(title, id) {
    router.visit(`/home/event/${slugify(title)}/${id}`);
}
function viewMovie(title, id) {
    router.visit(`/home/movie/${slugify(title)}/${id}`);
}
</script>
<template>
    <b-container class="mt-5">
        <HomeHeader />

        <div style="margin-top: 22vh; margin-bottom: 10vh">
            <div class="col-12">
                <div class="mb-4 col-12 d-flex justify-content-between align-items-center">
                    <div class="">
                        <div class="mt-2">
                            <h5>Search Results</h5>
                        </div>
                    </div>
                </div>

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
                                        :movieId="item.id"
                                        :showTimes="item.show_times"
                        :viewing_format="item.viewing_format"

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
    </b-container>
    <FooterSection />
</template>
