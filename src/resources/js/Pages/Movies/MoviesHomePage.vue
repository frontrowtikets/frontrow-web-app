<script setup>
import HomeHeader from "../../Components/HomeHeader.vue";
import FooterSection from "../../Components/FooterSection.vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import MovieCard from "../../Components/MovieCard.vue";
import { router, Head } from "@inertiajs/vue3";

import { ref,onMounted } from "vue";

const props = defineProps({
    movies: {
        type: Array,
        default: [],
    },
    categories: {
        type: Array,
    },
});
const movieListBottom = ref(null);

const { paginatedItems, nextPageExists } = useInfiniteScroll("movies", movieListBottom);
onMounted(()=>{
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
})
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
    <Head title="Frontrow - Movies" />
    <b-container class="mt-5">
        <HomeHeader />

        <div style="margin-top: 22vh; margin-bottom: 10vh">
            <div class="col-12">
                <div class="mb-4 col-12 d-flex justify-content-between align-items-center">
                    <div class="">
                        <div class="mt-2">
                            <h5>Movies</h5>
                        </div>
                    </div>
                    <div class="">
                        <b-dropdown variant="light" right>
                            <template v-slot:button-content>
                                Filter
                                <i class="mdi mdi-chevron-down"></i>
                            </template>
                            <b-dropdown-item>
                                <b-form-checkbox id="checkbox-1" name="checkbox-1" :value="true" :unchecked-value="false" checked>
                                    All
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-for="(cat, index) in props.categories"
                                    :key="`${index}_${cat.id}`"
                                    id="checkbox-1"
                                    name="checkbox-1"
                                    :value="true"
                                    :unchecked-value="false"
                                >
                                    {{ cat.name }}
                                </b-form-checkbox>
                            </b-dropdown-item>
                        </b-dropdown>
                    </div>
                </div>

                <b-container>
                    <div class="flex-wrap gap-4 pt-4 d-flex align-items-center justify-content-center">
                        <div v-for="(item, index) in paginatedItems" :key="index" class="col-xl-3 col-md-4 col-sm-6">
                            <MovieCard
                                :movieName="item.title"
                                :movieImageLink="item.thumbnail_url"
                                :movieDate="item.release_date"
                                :movieId="item.id"
                                :showTimes="item.show_times"
                                :overallRating="item.overallRating"
                        :viewing_format="item.viewing_format"

                                @view="viewEvent"
                            />
                        </div>
                    </div>
                    <div ref="movieListBottom"></div>
                    <div v-if="nextPageExists" class="mt-4 text-center text-success">
                        <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                    </div>
                    <div v-else class="mt-4 text-center text-primary">No More Data</div>

                    <!-- end row -->
                </b-container>
            </div>
        </div>
    </b-container>
    <FooterSection />
</template>
