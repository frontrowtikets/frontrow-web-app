<script setup>
import PageHeader from "@/js/Components/page-header.vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import { reactive, onMounted, onUnmounted, computed, ref } from "vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import MovieCard from "../../Components/MovieCard.vue";
import icondata from "@/images/icondata.png";

const props = defineProps({
    movies: {
        type: Object,
        required: true,
    },
});

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
    router.visit(`/movie/${slugify(title)}/${id}`);
}
</script>
<template>
    <Head title="Movies" />
    <DashboardLayout>
        <PageHeader title="Movies" :items="state.items" />
        <div class="row">
            <div class="card">
                <div class="card-body">

                    <b-container>

                        <div class="flex-wrap gap-4 d-flex align-items-center justify-content-center">
                            <div v-for="(item, index) in paginatedItems" :key="index" class="col-xl-3 col-md-4 col-sm-6">
                                <MovieCard
                                    :movieName="item.title"
                                    :movieImageLink="item.thumbnail_url"
                                    :movieDate="item.release_date"
                                    :movieId="item.id"
                                    :showTimes="item.show_times"
                                    :overallRating = "item.overallRating"
                        :viewing_format="item.viewing_format"

                                    @view="viewMovie(item.title,item.id)"
                                />
                            </div>
                        </div>
                        <div ref="movieListBottom"></div>
                        <div v-if="nextPageExists" class="mt-4 text-center text-success">
                            <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                        </div>
                        <div v-else class="mt-4 text-center text-primary">No More Data</div>
                    </b-container>
                </div>
            </div>
        </div></DashboardLayout
    >
</template>
