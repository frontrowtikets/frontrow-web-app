<script setup>
import { onMounted, ref } from "vue";
import { clothsData } from "./products.js";
import "@vueform/slider/themes/default.css";
import EventCard from "./EventCard.vue";

const movies = ref(clothsData);
onMounted(() => {});
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
                        <h4>Featured Offers</h4>
                    </div>
                </div>
            </div>

            <!-- end row -->
            <div
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
            </div>

            <!-- end row -->
        </b-container>
        <!-- end container -->
    </section>
</template>
