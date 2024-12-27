<script setup>
import PageHeader from "@/js/Components/page-header.vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import { reactive, onMounted, computed, ref } from "vue";
import Swal from "sweetalert2";
import icondata from "@/images/icondata.png";
import useInertiaFormSubmit from "@/js/Composables/useInertiaFormSubmit.js";
import TheSeatMap from "@/js/Components/TheSeatMap.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

const props = defineProps(["movieDetails"]);

const state = reactive({
    items: [
        {
            text: "SeatMap",
            // href: "javascript:void(0)"
        },
        {
            text: "Movie Manager",
            active: true,
        },
    ],
});

const seatMapFields = reactive({
    theatre: null,
    room: null,
    from: "A",
    to: null,
    seatsPerRow: 10,
});

const rowData = [
    { row: "A", seatCount: 10 },
    { row: "B", seatCount: 35 },
    { row: "C", seatCount: 12 },
];
const theatre = {
    theatre: "theatre1",
};

const roomName = "Room 1";

const reservedSeats = ["A1"];
</script>
<template>
    <Head title="Seat Map" />
    <DashboardLayout>
        <PageHeader title="Seat Maps" :items="state.items" />
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div><TheSeatMap :rowData="rowData" :reserved="reservedSeats" :theatre="theatre" :roomName="roomName" /></div>
                    <div>
                        <div class="mt-4 me-4">
                            <div class="gap-4 mb-3 justify-content-between d-flex">
                                <div class="col-6">
                                    <label>Theatre</label>
                                    <v-select :options="props.movieDetails.show_times" v-model="seatMapFields.theatre" :label="'theatre'"></v-select>
                                </div>
                                <div class="col-6">
                                    <label>Room Name</label>
                                    <input class="form-control" type="text" id="roomname" v-model="seatMapFields.room" />
                                </div>
                            </div>
                                <div class="mb-3">
                                        <label>Rows </label>
                                        <div class="flex-row d-flex justify-content-between align-items-center">
                                            <div class="col-5">
                                                <select class="form-select form-control" id="movie_status" v-model="seatMapFields.from">
                                                    <option value="" disabled default>Select</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                    <option value="I">I</option>
                                                    <option value="J">J</option>
                                                    <option value="K">K</option>
                                                    <option value="L">L</option>
                                                    <option value="M">M</option>
                                                    <option value="N">N</option>
                                                    <option value="O">O</option>
                                                </select>
                                            </div>
                                            <div>to</div>
                                            <div class="col-5">
                                                <select class="form-select form-control" id="movie_status" v-model="seatMapFields.to">
                                                    <option value="" disabled default>Select</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                    <option value="I">I</option>
                                                    <option value="J">J</option>
                                                    <option value="K">K</option>
                                                    <option value="L">L</option>
                                                    <option value="M">M</option>
                                                    <option value="N">N</option>
                                                    <option value="O">O</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                            <!-- <div class="gap-3 d-flex col-12 justify-content-between">
                                <div class="col-9">
                                    <div class="mb-3">
                                        <label>Room Name</label>
                                        <input class="form-control" type="text" id="roomname" v-model="seatMapFields.room" />
                                    </div>


                                    <div class="mb-4">
                                        <label>Seats Per Row</label>
                                        <input class="form-control" type="text" id="roomname" v-model="seatMapFields.seatsPerRow" />
                                    </div>
                                </div>
                                <div
                                    class="rounded col-2 d-flex align-items-center justify-content-center"
                                    style="background-color: #f6f6f9"
                                    role="button"
                                    @click="generateSeatMap"
                                >
                                    <div class="text-success fw-bold">Add</div>
                                </div>
                            </div> -->
                            <div class="mt-5 mb-5">
                                <b-button variant="primary" @click="saveSeatMap">Save Changes</b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div></DashboardLayout
    >
</template>
