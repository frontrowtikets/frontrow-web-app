<script setup>
import { reactive, onMounted, computed, ref, watch } from "vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import MovieCheckout from "./MovieCheckout.vue";
import PageHeader from "../../Components/page-header.vue";
import { useWindowSize } from "@vueuse/core";
import TheSeatMap from "@/js/Components/TheSeatMap.vue";
import icondata from "@/images/icondata.png";
import moment from "moment";

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
const { height,width } = useWindowSize();

const rooms = ref(["Room 1", "Room 2", "Room 3", "Room 4"]);

const seats = ref(["A6", "A7", "A8", "A9", "B4", "B5", "C5"]);
const selectedTheatre = ref(null);
const selectedRoom = ref("");
const selectedSeats = ref([]);
const showCheckout = ref(false);
const showTimeSelected = ref(false);
const selectedShowTimeIndex = ref(0);

const selectedTheatres = ref([]);

const cleanedSelectedSeats = computed(() => {
    const cleaned = selectedTheatres.value.filter((selectedItem) => selectedItem.selectedSeats.length > 0);
    return cleaned;
});

const selectedShowtime = computed(()=>{
    return   [props.buyMovieDetails.seatmap[selectedShowTimeIndex.value]];
})

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

onMounted(() => {

    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });

    if (props.buyMovieDetails.seatmap.length > 0) {
        setSavedSeatMap();
    }
});
watch(selectedShowTimeIndex,(newval)=>{
setSavedSeatMap();
})

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

function setSavedSeatMap() {
    const seatMap = selectedShowtime.value;
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
function movieDetails() {
    router.visit(`/movie/${slugify(props.buyMovieDetails.title)}/${props.buyMovieDetails.id}`);
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

function viewDetails() {
    router.visit(`/movie/${props.buyMovieDetails.title}/${props.buyMovieDetails.id}`);
}

function getSelectedSeats(seats, theatre, roomId, roomName) {
    const index = selectedTheatres.value.findIndex((item) => item.roomID === roomId);
    if (index !== -1) {
        selectedTheatres.value[index].selectedSeats = seats;
    } else {
        selectedTheatres.value.push({ selectedSeats: seats, roomID: roomId, theatre, roomName });
    }
}
function goToSelectSeats(theIndex) {
    selectedShowTimeIndex.value = theIndex;
    showTimeSelected.value = true;

}
</script>
<template>
    <Head title="checkout" />

    <DashboardLayout>
        <PageHeader :title="props.buyMovieDetails.title" :items="state.items" role="button" @click="showCheckout = false" />
        <div v-if="showTimeSelected">
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
                                <b-button variant="light" disabled><div style="font-weight: bold">Select seats to Proceed</div></b-button>

                                <div class="" @click="showTimeSelected = false">
                                    <a class="btn btn-light"> <i class="bx bx-left-arrow-alt me-3"></i> Back </a>
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
                                </div>

                                <div class="mb-4 text-center">
                                    <div class="mb-2 fw-bold me-3">Sub Total</div>
                                    <div>
                                        <h4>{{ selectedTheatre?.currency || "UGX" }} {{ useCurrencyFormat(totalPrice) }}</h4>
                                    </div>
                                </div>
                                <div class="mt-5 mt-sm-0 d-flex justify-content-center" @click="totalPrice > 0 ? (showCheckout = true) : null">
                                    <a class="btn btn-success flex-fill"> <i class="mdi mdi-cart-arrow-right me-1"></i> Proceed </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="col-12 d-flex align-items-stretch">
                <div class="pb-5 card w-100">
                    <div class="mb-5 card-body">
                        <div class="pb-4 w-100 d-flex justify-content-between align-items-center">
                            <div class="card-title" v-if="width>424">Select Showtime to proceed</div>
                            <div class="" @click="movieDetails">
                                <a class="btn btn-light"> <i class="mdi mdi-eye-outline" v-if="width>424"></i> View Details </a>
                            </div>
                        </div>
                        <div>
                            <div
                                v-if="props.buyMovieDetails.show_times.length == 0"
                                class="d-flex flex-column align-items-center"
                                style="padding-top: 9vh; padding-bottom: 30vh"
                            >
                                <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                <div>Movie has no show times</div>
                            </div>
                            <div v-else class="flex-wrap gap-4 mt-4 mb-5 d-flex">
                                <div
                                    role="button"
                                    v-for="(theShowtime, theShowtimeIndex) in props.buyMovieDetails.seatmap"
                                    :key="`${theShowtimeIndex}_${theShowtime.id}_${theShowtimeIndex}`"
                                    @click="goToSelectSeats(theShowtimeIndex)"
                                >
                                    <div class="">
                                        <div class="border shadow-none card">
                                            <div class="p-3 card-body bg-hover" role="button">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="avatar-xs me-3" @click="viewMovieDetails">
                                                        <div class="bg-transparent rounded avatar-title">
                                                            <i class="bx bx-play-circle font-size-24 text-secondary"></i>
                                                        </div>
                                                    </div>
                                                    <div style="color: black; font-weight: bold" class="text-muted">
                                                        {{ moment(theShowtime.showTime[0].screening_date).format("ddd, DD MMM YYYY") }} At
                                                        {{ theShowtime.showTime[0].start_time }}
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <label>Theatre :</label>
                                                    <span class="ms-3"> {{ theShowtime.showTime[0].theatre }}</span>
                                                </div>
                                                <div class="mt-1">
                                                    <label>Show Room :</label>
                                                    <span class="ms-3"> {{ theShowtime.room_name }}</span>
                                                </div>
                                                <div class="mt-1">
                                                    <label>Ticket Price :</label>
                                                    <span class="ms-3">
                                                        {{ theShowtime.showTime[0].currency }}
                                                        {{ useCurrencyFormat(theShowtime.showTime[0].ticket_price) }}</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
<style lang="css" scoped>
.bg-hover:hover {
    background-color: #01b4bd12;
}
</style>
