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
    if (props.movieDetails.seatmap.length > 0) {
        setSavedSeatMap();
    }
});

//structured seatmap to be saved
const structuredSeatMap = computed(() => {
    const seatMap = [];

    //TODO: Reduce time complexity
    seatMapFields.value.forEach((field) => {
        if (field.theatre && field.room !== null) {
            const cleanSeatMap = {
                showTime: field.theatre,
                reserved: field.reserved,
                roomName: field.room,
                combinations: [],
            };
            field.seats.forEach((rowSeats) => {
                const rowSeatsCombinations = generateCombinations(rowSeats);
                cleanSeatMap.combinations = [...cleanSeatMap.combinations, ...rowSeatsCombinations];
            });
            //removing duplicate seats
            cleanSeatMap.combinations = [...new Set(cleanSeatMap.combinations)];
            seatMap.push(cleanSeatMap);
        }
    });

    return seatMap;
});
function setSavedSeatMap() {
    const seatMap = props.movieDetails.seatmap;
    const structuredSeatMap = [];
    //TODO: Reduce time complexity
    seatMap.forEach((item) => {
        const seatMapField = {
            theatre: item.showTime[0],
            room: item.room_name,
            seats: [],
            reserved: [],
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
    }));
}

function addTheatre() {
    const lastItem = seatMapFields.value[seatMapFields.value.length - 1];
    if (lastItem.theatre !== "" && lastItem.room !== null) {
        seatMapFields.value.push({
            theatre: "",
            room: null,
            seats: [
                {
                    row: "A",
                    seatCount: 10,
                },
            ],
            reserved: [],
        });
    }
}

function removeTheatre(index) {
    seatMapFields.value.splice(index, 1);
}

function addRow(index, seatmapIndex) {
    const lastItem = seatMapFields.value[seatmapIndex].seats[index];
    if (lastItem.row != "") {
        seatMapFields.value[seatmapIndex].seats.push({
            row: "",
            seatCount: 10,
        });
    }
}

function removeRow(index, seatmapIndex) {
    if (seatMapFields.value[seatmapIndex].seats.length !== 1) {
        seatMapFields.value[seatmapIndex].seats.splice(index, 1);
    }
}

function markReserved(seats, theSeatMapIndex) {
    const reservedSeats = seats.value;
    seatMapFields.value[theSeatMapIndex].reserved = [...seatMapFields.value[theSeatMapIndex].reserved, ...reservedSeats];
    console.log("thisss", seatMapFields.value[theSeatMapIndex].reserved);
}

function generateCombinations({ row, seatCount }) {
    if (!row || seatCount <= 0) {
        return [];
    }

    const combinations = [];
    for (let i = 1; i <= seatCount; i++) {
        combinations.push(`${row}${i}`);
    }

    return combinations;
}
function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}
function saveSeatMap() {
    const seatMap = structuredSeatMap.value;

    useInertiaFormSubmit(
        {
            seatMaps: seatMap,
        },
        "/saveseatmap",
        `/movie/${slugify(props.movieDetails.title)}/${props.movieDetails.id}`,
        "You are about to save changes",
        "Changes have been saved successfully"
    );
}
</script>
<template>
    <Head title="Seat Map" />
    <DashboardLayout>
        <PageHeader title="Seat Maps" :items="state.items" />
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div v-for="(theSeatMap, theSeatMapIndex) in seatMapFields" :key="`${theSeatMapIndex}_${theSeatMap.room}_${theSeatMapIndex}`">
                        <TheSeatMap
                            :rowData="theSeatMap.seats"
                            :reserved="theSeatMap.reserved"
                            :theatre="theSeatMap.theatre"
                            :roomName="theSeatMap?.room"
                            @markAsReserved="markReserved($event, theSeatMapIndex)"
                        />
                    </div>
                    <div>
                        <div class="mt-4 me-4">
                            <div v-for="(seatmap, seatmapIndex) in seatMapFields" :key="`${seatmapIndex}_${seatmap.theatre}_${seatmapIndex}`">
                                <div
                                    role="button"
                                    v-if="seatMapFields.length > 1"
                                    @click="removeTheatre(seatmapIndex)"
                                    class="mt-5 text-end text-danger"
                                >
                                    <i class="bx bx-trash-alt"></i>
                                </div>
                                <div class="gap-4 mb-4 justify-content-between d-flex">
                                    <div class="col-6">
                                        <label>Theatre <span class="text-danger">*</span></label>
                                        <v-select :options="props.movieDetails.show_times" v-model="seatmap.theatre" :label="'theatre'"></v-select>
                                    </div>
                                    <div class="col-6">
                                        <label>Room Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="roomname" v-model="seatmap.room" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="invisible"><i class="bx bxs-x-circle text-danger ps-1 pe-1" role="button"></i></div>

                                        <div class="col-5">
                                            <label>Row Label </label>
                                        </div>
                                        <div class="text-start col-5">
                                            <label>Number of Seats </label>
                                        </div>
                                        <div class="invisible">
                                            <b-button variant="primary"><i class="bx bxs-plus-circle"></i> Add</b-button>
                                        </div>
                                    </div>

                                    <div
                                        v-for="(field, index) in seatmap.seats"
                                        :key="`${index}_${field.row}`"
                                        class="flex-row mb-2 d-flex justify-content-between align-items-center"
                                    >
                                        <div @click="removeRow(index, seatmapIndex)">
                                            <i class="bx bxs-x-circle text-danger ps-1 pe-1" role="button"></i>
                                        </div>
                                        <div class="col-5">
                                            <select class="form-select form-control" id="movie_status" v-model="field.row">
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
                                        <div class="col-5">
                                            <input class="form-control" type="number" id="roomname" v-model="field.seatCount" />
                                        </div>
                                        <div>
                                            <b-button
                                                v-if="index === seatMapFields[seatmapIndex].seats.length - 1"
                                                variant="primary"
                                                @click="addRow(index, seatmapIndex)"
                                                ><i class="bx bxs-plus-circle"></i> Add</b-button
                                            >
                                            <b-button v-else variant="primary" class="invisible" @click="addRow(index, seatmapIndex)"
                                                ><i class="bx bxs-plus-circle"></i> Add</b-button
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="rounded col-2 d-flex align-items-center justify-content-center"
                                    style="background-color: #f6f6f9"
                                    role="button"
                                    @click="addTheatre"
                                    v-if="seatmapIndex === seatMapFields.length - 1"
                                >
                                    <div class="p-2 text-success fw-bold">Add Theatre</div>
                                </div>
                            </div>
                            <div class="mt-5 mb-5">
                                <b-button variant="primary" @click="saveSeatMap">Save Changes</b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
