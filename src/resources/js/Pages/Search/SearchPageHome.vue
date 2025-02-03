<script setup>
import HomeHeader from "../../Components/HomeHeader.vue";
import FooterSection from "../../Components/FooterSection.vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import MovieCard from "../../Components/MovieCard.vue";
import { router } from "@inertiajs/vue3";
import { useStore } from "vuex";


import { ref } from "vue";

const props = defineProps({
    movies: {
        type: Array,
        default: [],
    },
    categories: {
        type: Array,
    },
});

const store = useStore();

const isSearching = ref(true);

function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}
function viewEvent(title, id) {
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
                    <!-- <div class="flex-wrap gap-4 pt-4 d-flex align-items-center justify-content-center">
                        <div v-for="(item, index) in paginatedItems" :key="index" class="col-xl-3 col-md-4 col-sm-6">
                            <MovieCard
                                :movieName="item.title"
                                :movieImageLink="item.thumbnail_url"
                                :movieDate="item.release_date"
                                :movieId="item.id"
                                :showTimes="item.show_times"
                                :overallRating="item.overallRating"
                                @view="viewEvent"
                            />
                        </div>
                    </div> -->
                </b-container>
            </div>
        </div>
    </b-container>
    <FooterSection />
</template>
