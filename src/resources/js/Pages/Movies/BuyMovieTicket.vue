<script setup>
import { reactive, onMounted, computed, ref } from "vue";
import DashboardLayout from "../../Layouts/main.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import MovieCheckout from "../../Components/MovieCheckout.vue";
import { useWindowSize } from '@vueuse/core'

const state = reactive({});
const { height } = useWindowSize()

const rooms = ref(["Room 1", "Room 2", "Room 3", "Room 4"]);

const seats = ref(["A6", "A7", "A8", "A9", "B4", "B5", "C5"]);
const selectedTheatre = ref(null);
const selectedRoom = ref("");
const selectedSeats = ref([]);
const showCheckout = ref(false);
const props = defineProps(["buyMovieDetails"]);

const totalPrice = computed(() => {
    if (selectedSeats.value.length > 0 && selectedTheatre) {
        const total = selectedTheatre.value?.ticket_price * selectedSeats.value.length;
        return total;
    } else {
        return 0;
    }
});
</script>
<template>
    <Head title="Schedule Movies" />

    <DashboardLayout>
        <PageHeader title="Schedule Movie" :items="state.items" />
        <div v-if="showCheckout">
            <div class="col-12">
                <div class="card" :style="{height:`${height-100}px`}">
                    <div class=" card-body d-flex align-items-center justify-content-center">

                        <MovieCheckout />
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="row">
            <div class="col-xl-8 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="w-100 d-flex justify-content-between">
                            <div><h5 class="mb-4 card-title">Seat Map</h5></div>
                            <div class="">
                                <a href="/ecommerce/product-detail" class="btn btn-light">
                                    <i class="mdi mdi-arrow-left me-1"></i> View Movie Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <h5 class="mb-4 card-title">Order Details</h5>

                        <div class="mb-3">
                            <label>Theatre Name</label>
                            <v-select v-model="selectedTheatre" :options="props.buyMovieDetails.show_times" :label="'theatre'"></v-select>
                        </div>
                        <div class="mb-3">
                            <label>Theatre Room</label>
                            <v-select v-model="selectedRoom" :options="rooms" :label="'theatre'"></v-select>
                        </div>
                        <div class="mb-3">
                            <label>Seats</label>
                            <v-select multiple v-model="selectedSeats" :options="seats" :label="'theatre'"></v-select>
                        </div>
                        <div class="mt-5 text-start">
                            <div class="mb-4">Summary</div>
                            <div class="mb-2"><span class="fw-bold me-3">Theatre:</span>{{ selectedTheatre?.theatre }}</div>
                            <div class="mb-2"><span class="fw-bold me-3">Room:</span>{{ selectedRoom }}</div>
                            <div class="mb-2"><span class="fw-bold me-3">Tickets:</span>{{ selectedSeats.length }}</div>
                            <div class="mb-4">
                                <span class="fw-bold me-3">Seats:</span
                                ><span class="me-3 badge badge-soft-secondary" v-for="(seat, index) in selectedSeats" :key="index">{{ seat }}</span>
                            </div>
                            <div class="mb-4 text-end">
                                <div class="mb-2 fw-bold me-3">Total</div>
                                <div>
                                    <h4>{{ selectedTheatre?.currency || "UGX" }} {{ useCurrencyFormat(totalPrice) }}</h4>
                                </div>
                            </div>
                            <div class="mt-5 text-sm-end mt-sm-0" @click="showCheckout = true">
                                <a class="btn btn-success"> <i class="mdi mdi-cart-arrow-right me-1"></i> Proceed </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
