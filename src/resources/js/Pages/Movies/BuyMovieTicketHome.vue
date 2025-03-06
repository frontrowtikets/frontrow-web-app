<script setup>
import { reactive, onMounted, computed, ref } from "vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import HomeHeader from "../../Components/HomeHeader.vue";
import FooterSection from "../../Components/FooterSection.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import MovieCheckout from "./MovieCheckout.vue";
import PageHeader from "../../Components/page-header.vue";
import { useWindowSize } from "@vueuse/core";
import TheSeatMap from "@/js/Components/TheSeatMap.vue";
import icondata from "@/images/icondata.png";

const props = defineProps(["buyMovieDetails", "myWallet"]);

const state = reactive({
    items: [
        {
            text: "Buy Ticket",
        },
        {
            text: "Checkout",
            active: true,
        },
    ],
});
const { height } = useWindowSize();

const rooms = ref(["Room 1", "Room 2", "Room 3", "Room 4"]);

const seats = ref(["A6", "A7", "A8", "A9", "B4", "B5", "C5"]);
const selectedTheatre = ref(null);
const selectedRoom = ref("");
const selectedSeats = ref([]);
const showCheckout = ref(false);

const seatMapFields = ref([
    {
        theatre: "",
        room: null,
        seats: [
            {
                row: "A",
                seatCount: 10,
            },
        ],
        reserved: [],
    },
]);

const selectedTheatres = ref([]);

const cleanedSelectedSeats = computed(()=>{
    const cleaned = selectedTheatres.value.filter((selectedItem)=>selectedItem.selectedSeats.length > 0)
    return cleaned;
})

onMounted(() => {
    if (props.buyMovieDetails.seatmap.length > 0) {
        setSavedSeatMap();
    }
});

const totalPrice = computed(() => {
    if (props.buyMovieDetails.seatmap.length > 0) {
        if (selectedTheatres.value.length > 0) {
            const total = selectedTheatres.value.reduce((sum, item) => sum + item.selectedSeats.length * item.theatre.ticket_price, 0);
            return total;
        } else {
            return 0;
        }
    } else {
        if (selectedSeats.value.length > 0 && selectedTheatre) {
            const total = selectedTheatre.value?.ticket_price * selectedSeats.value.length;
            return total;
        } else {
            return 0;
        }
    }
});

function goback() {
    if (window.history.length > 1) {
        window.history.back();
    }
}

function setSavedSeatMap() {
    const seatMap = props.buyMovieDetails.seatmap;
    const structuredSeatMap = [];
    //TODO: Reduce time complexity
    seatMap.forEach((item) => {
        const seatMapField = {
            theatre: item.showTime[0],
            room: item.room_name,
            roomId: item.id,
            seats: [],
            reserved: [],
            seatmapId: item.id,
        };
        item.showTimeSeats.forEach((seat) => {
            if (seat.seat_status == "reserved") {
                seatMapField.reserved.push(seat.seat_number);
            }
        });

        const transformedSeatMap = transformSeats(item.showTimeSeats);
        seatMapField.seats = transformedSeatMap;
        structuredSeatMap.push(seatMapField);
    });
    seatMapFields.value = structuredSeatMap;
}

function transformSeats(seats) {
    const groupedSeats = seats.reduce((acc, seat) => {
        const row = seat.seat_number[0];

        if (!acc[row]) {
            acc[row] = [];
        }

        acc[row].push(seat);

        return acc;
    }, {});

    return Object.entries(groupedSeats).map(([row, seats]) => ({
        row: row,
        seatCount: seats.length,
        id: seats.id,
    }));
}

function getSelectedSeats(seats, theatre, roomId, roomName) {
    const index = selectedTheatres.value.findIndex((item) => item.roomID === roomId);
    if (index !== -1) {
        selectedTheatres.value[index].selectedSeats = seats;
    } else {
        selectedTheatres.value.push({ selectedSeats: seats, roomID: roomId, theatre, roomName });
    }
}
function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}
function movieDetails() {
    router.visit(`/home/movie/${slugify(props.buyMovieDetails.title)}/${props.buyMovieDetails.id}`);
}
</script>
<template>
    <Head title="checkout" />

    <b-container class="" style="margin-top: 16em">
        <HomeHeader />
        <PageHeader :title="props.buyMovieDetails.title" :items="state.items" role="button" @click="showCheckout = false" />
        <div v-if="showCheckout">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <MovieCheckout
                            :paymentDetails="cleanedSelectedSeats"
                            :currency="selectedTheatre?.currency"
                            :total="totalPrice"
                            :movieId="props.buyMovieDetails.id"
                            :myWallet="props.myWallet"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="row">
            <div class="col-xl-8 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="w-100 d-flex justify-content-between">
                            <b-button variant="light" disabled><h5 class="">Select seats to Proceed</h5></b-button>

                            <div class="" @click="movieDetails">
                                <a class="btn btn-light"> <i class="mdi mdi-eye-outline"></i> View Movie Details </a>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div v-if="props.buyMovieDetails.seatmap.length > 0">
                                <div
                                    v-for="(theSeatMap, theSeatMapIndex) in seatMapFields"
                                    :key="`${theSeatMapIndex}_${theSeatMap.room}_${theSeatMapIndex}`"
                                >
                                    <TheSeatMap
                                        :rowData="theSeatMap.seats"
                                        :reserved="theSeatMap.reserved"
                                        :theatre="theSeatMap.theatre"
                                        :roomName="theSeatMap?.room"
                                        :roomId="theSeatMap?.roomId"
                                        :showMarkReservedButton="false"
                                        @selectedSeats="getSelectedSeats"
                                    />
                                </div>
                            </div>

                            <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                <div>No Seat Map</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <h5 class="mb-4 card-title">Order Details</h5>

                        <div class="mt-5 text-start">
                            <div v-if="props.buyMovieDetails.seatmap.length > 0">
                                <div v-if="cleanedSelectedSeats.length > 0">
                                    <div class="mb-4">Summary</div>
                                    <div v-for="(item, index) in cleanedSelectedSeats" :key="`${item.roomId}_${index}`">
                                        <div class="mb-2"><span class="fw-bold me-3">Theatre:</span>{{ item?.theatre.theatre }}</div>
                                        <div class="mb-2"><span class="fw-bold me-3">Room:</span>{{ item?.roomName }}</div>
                                        <div class="mb-2"><span class="fw-bold me-3">Tickets:</span>{{ item?.selectedSeats.length }}</div>
                                        <div class="mb-4">
                                            <span class="fw-bold me-3">Seats:</span
                                            ><span
                                                class="me-3 badge badge-soft-secondary"
                                                v-for="(seat, index) in item?.selectedSeats"
                                                :key="index"
                                                >{{ seat }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="pt-5 pb-5 mb-5 text-center">
                                    <span class="">Select seats to book</span>
                                </div>
                            </div>
                            <div v-else>
                                <div class="pt-5 pb-5 mb-5 text-center">
                                    <span class="">Movie has no seat map</span>
                                </div>
                                <!-- <div class="mb-3">
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
                                </div> -->
                            </div>

                            <div class="mb-4 text-center">
                                <div class="mb-2 fw-bold me-3">Total</div>
                                <div>
                                    <h4>{{ selectedTheatre?.currency || "UGX" }} {{ useCurrencyFormat(totalPrice) }}</h4>
                                </div>
                            </div>
                            <div class="mt-5 d-flex justify-content-center mt-sm-0 " @click="totalPrice > 0 ? (showCheckout = true) : null">
                                <a class="btn btn-success flex-fill"> <i class="mdi mdi-cart-arrow-right me-1"></i> Proceed </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </b-container>
    <div class="mt-5">
        <FooterSection />
    </div>
</template>
