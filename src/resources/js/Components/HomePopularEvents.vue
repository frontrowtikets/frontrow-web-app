<script setup>
import { ref } from "vue";
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";
import EventCard from "./EventCard.vue";
import { clothsData } from "./products.js";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import {  router, } from "@inertiajs/vue3";

const breakpoints = useBreakpoints(breakpointsTailwind);
const movies = ref(clothsData);
const greaterThanMd = breakpoints.greater("md");
const config = {
    itemsToShow:3,
    autoplay: 3000,
  wrapAround: true,
  pauseAutoplayOnHover: true,
      // Breakpoints are mobile-first
  // Any settings not specified will fall back to the carousel's default settings
  breakpoints: {
    // 300px and up
    300: {
      itemsToShow: 1,
      snapAlign: 'center',
    },
    // 400px and up
    400: {
      itemsToShow: 1.5,
      snapAlign: 'start',
    },
    // 500px and up
    500: {
      itemsToShow: 2.5,
      snapAlign: 'start',
    },
    800: {
      itemsToShow: 3,
      snapAlign: 'start',
    },
     1030: {
      itemsToShow: 3.5,
      snapAlign: 'start',
    },
  },
};
function goToEventsPage(){
    router.visit("/events")
}
</script>
<template>
    <!-- Features start -->
    <section class="section" id="features">
        <b-container>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-5 text-center">
                        <div class="small-title">Awesome Events</div>
                        <h4>Popular Events & Cinemas Near You</h4>
                    </div>
                </div>
            </div>

            <div class="mb-4 d-flex w-100 justify-content-end">
                <div>
                    <b-button variant="primary" class="w-md" pill @click="goToEventsPage">
                        View All
                        <span
                            v-motion="{
                                initial: { x: 0 },
                                animate: {
                                    x: [0, 20, 0],
                                },
                                transition: {
                                    duration: 1.5,
                                    repeat: Infinity,
                                    ease: 'ease-in-out',
                                },
                            }"
                            ><i class="mdi mdi-arrow-right"></i
                        ></span>
                    </b-button>
                </div>
            </div>
            <div>
                <Carousel v-bind="config" :wrapAround="true">
                    <!-- <Slide v-for="slide in 10" :key="slide">
                        {{ slide }}
                    </Slide> -->
                     <Slide
                        v-for="(item, index) in movies"
                        :key="index"
                        calss=""
                    >
                        <EventCard
                        class=""
                            :discount="item.discount"
                            :eventName="item.eventName"
                            :eventImageLink="item.eventImage"
                            :eventDate="item.eventDate"
                            :eventLocation="item.eventLocation"
                            :eventPrice="item.eventPrice"
                            :eventCurrency="item.eventCurrency"
                        />
                    </Slide>

                    <template #addons>
                        <Navigation />
                        <!-- <Pagination /> -->
                    </template>
                </Carousel>

                <!-- <div
                    class="flex-wrap gap-4 d-flex align-items-center justify-content-center"
                >
                    <div
                        v-for="(item, index) in movies"
                        :key="index"
                        class="col-xl-3 col-md-4 col-sm-6"
                    >
                        <EventCard
                            :discount="item.discount"
                            :eventName="item.eventName"
                            :eventImageLink="item.eventImage"
                            :eventDate="item.eventDate"
                            :eventLocation="item.eventLocation"
                            :eventPrice="item.eventPrice"
                            :eventCurrency="item.eventCurrency"
                        />
                    </div>
                </div> -->
            </div>
        </b-container>
        <!-- end container -->
    </section>
    <!-- Features end -->
</template>
