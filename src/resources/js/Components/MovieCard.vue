<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import moment from "moment";
import useCurrencyFormat from "../Composables/useCurrencyFormat.js";
import { debounce } from "lodash";

const props = defineProps([
    "discount",
    "movieName",
    "movieImageLink",
    "movieDate",
    "movieLocation",
    "movieId",
    "showTimes",
    "overallRating",
]);

const movieRating = ref(3);

onMounted(() => {
    movieRating.value = props.overallRating;
});

const emit = defineEmits(["view"]);
const viewDetails = () => {
    emit("view", props.movieName);
};

const updateRating = debounce(async (rating) => {
      try {
        await fetch('/api/rating', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            movieId: props.movieId,
            rating: rating
          })
        })

        movieRating.value = rating
      } catch (error) {
        console.error('Failed to save rating:', error)
        movieRating.value = props.overallRating
      }
}, 1500);

onBeforeUnmount(() => {
    updateRating.cancel();
});
</script>

<template>
    <b-container>
        <div class="rounded shadow card w-100">
            <div class="p-2">
                <div
                    class="overflow-hidden rounded position-relative"
                    style="height: 320px"
                    role="button"
                    @click="() => $emit('view', movieName, movieId)"
                >
                    <div
                        v-if="discount"
                        class="avatar-sm product-ribbon"
                        style="z-index: 1"
                    >
                        <span class="avatar-title rounded-circle bg-primary"
                            >-{{ discount }}%</span
                        >
                    </div>
                    <div>
                        <img
                            :src="`${movieImageLink}`"
                            alt
                            class=""
                            style="
                                object-fit: cover;
                                object-position: center;
                                height: 320px;
                                background-color: lightgray;
                                width: 100%;
                            "
                            v-motion
                            :initial="{ opacity: 0 }"
                            :enter="{ opacity: 1, scale: 1 }"
                            :hovered="{ scale: 1.1 }"
                            :delay="20"
                            :duration="400"
                        />
                    </div>
                </div>
                <div class="pb-2 mt-4 ps-2 pe-2" role="button">
                    <h5 class="text-truncate text-start">
                        <div
                            class="text-hover-warning"
                            role="button"
                            @click="() => $emit('view', movieName, movieId)"
                        >
                            {{ movieName }}
                        </div>
                    </h5>
                    <div class="flex-row gap-2 mb-1 d-flex" role="button">
                        <div
                            v-for="star in 5"
                            :key="star"
                            class="movie-item-star-icon-button"
                            :class="
                                star <= movieRating
                                    ? 'text-warning'
                                    : 'text-grey'
                            "
                            :disabled="star === movieRating"
                            @click="updateRating(star)"
                            @mouseover="() => (movieRating = star)"
                        >
                            <i class="bx bxs-star"></i>
                        </div>
                    </div>
                    <div
                        @click="() => $emit('view', movieName, movieId)"
                        role="button"
                    >
                        <div class="mb-1 text-primary text-start">
                            <i class="bx bx-calendar-event me-1"></i
                            ><span>{{
                                moment(
                                    props.showTimes[0]?.screening_date
                                ).format("ddd, DD MMM YYYY")
                            }}</span>
                        </div>
                        <div class="text-truncate text-start">
                            <i class="bx bx-map me-1"></i
                            ><span>{{ props.showTimes[0]?.theatre }} </span>
                        </div>
                        <span
                            :class="{ invisible: props.showTimes.length < 1 }"
                            class="ms-3 badge badge-soft-secondary"
                            >See More</span
                        >

                        <h5 class="text-end">
                            <b
                                >{{ props.showTimes[0]?.currency }}
                                {{
                                    useCurrencyFormat(
                                        props.showTimes[0]?.ticket_price
                                    )
                                }}</b
                            >
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </b-container>
</template>
<style scoped>
.text-hover-warning {
    color: black;
    transition: color 0.3s ease-in-out;
}

.text-hover-warning:hover {
    color: #fed444;
}
</style>
