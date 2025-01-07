<script setup>
import { onMounted, ref } from "vue";
import "@vueform/slider/themes/default.css";
import EventCard from "./EventCard.vue";
import MovieCard from "./MovieCard.vue";
import { router } from "@inertiajs/vue3";


const props = defineProps(["last3Movies", "last3Events"]);

onMounted(() => {});
function viewMovie(title, id) {
    router.visit(`/home/movie/${slugify(title)}/${id}`);
}
function viewEvent(title, id) {
    router.visit(`/home/event/${slugify(title)}/${id}`);
}
</script>
<template>
    <section class="pt-4 section" id="about">
        <b-container>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-5 text-center">
                        <div class="small-title">
                            The Art of Making Memories
                        </div>
                        <h4>Featured</h4>
                    </div>
                </div>
            </div>

            <!-- end row -->
            <div
                class="flex-wrap gap-4 d-flex align-items-center justify-content-center"
            >
            <div
                    v-for="(item, index) in props.last3Movies"
                    :key="index"
                    class="col-xl-3 col-md-4 col-sm-6"
                >
                    <MovieCard
                        :movieName="item.title"
                        :movieImageLink="item.thumbnail_url"
                        :movieDate="item.release_date"
                        :movieId="item.id"
                        :showTimes="item.show_times"
                        :overallRating="item.overallRating"
                        @view="viewMovie"
                    />
                </div>
                <div
                    v-for="(item, index) in props.last3Events"
                    :key="index"
                    class="col-xl-3 col-md-4 col-sm-6"
                >
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

            <!-- end row -->
        </b-container>
        <!-- end container -->
    </section>
</template>
