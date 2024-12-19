<script setup>
import { ref, onMounted } from "vue";

const props = defineProps(['rowSeats','rowSeatsNumber', 'reserved','theatre',"roomName"])


const rows = ref([]);

const seatsPerRow = ref(0);

const selectedSeats = ref([]);
const reservedSeats = ref([]);

onMounted(()=>{
    rows.value = props.rowSeats
    seatsPerRow.value = Number(props.rowSeatsNumber)
    reservedSeats.value = props.reserved
})
const toggleSeat = (seatId) => {
    const index = selectedSeats.value.indexOf(seatId);
    if (index > -1) {
        selectedSeats.value.splice(index, 1);
    } else {
        selectedSeats.value.push(seatId);
    }
};

// Determine seat status
const getSeatStatus = (seatId) => {
    if (reservedSeats.value.includes(seatId)) return "reserved";
    if (selectedSeats.value.includes(seatId)) return "selected";
    return "available";
};
</script>

<template>
    <div class="p-4 rounded bg-light">
        <div class="mb-4 text-center">
            <div class="w-100 bg-primary" style="height: 10px"></div>
            <p class="text-muted small">{{ props.theatre.theatre }}({{ props.roomName }})</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div
                    class="overflow-auto seat-container"
                    style="white-space: nowrap"
                >

                    <div
                        v-for="row in rows"
                        :key="row"
                        class="mb-2 d-flex align-items-center"
                        style="min-width: fit-content"
                    >
                        <span class="me-2 fw-bold" style="width: 30px">
                            {{ row }}
                        </span>


                        <button
                            v-for="seatNumber in seatsPerRow"
                            :key="`${row}${seatNumber}`"
                            :class="[
                                'btn m-1',
                                {
                                    'btn-danger disabled':
                                        getSeatStatus(`${row}${seatNumber}`) ===
                                        'reserved',
                                    'btn-success':
                                        getSeatStatus(`${row}${seatNumber}`) ===
                                        'selected',
                                    'btn-primary':
                                        getSeatStatus(`${row}${seatNumber}`) ===
                                        'available',
                                },
                            ]"
                            :disabled="
                                getSeatStatus(`${row}${seatNumber}`) ===
                                'reserved'
                            "
                            @click="toggleSeat(`${row}${seatNumber}`)"
                            style="width: 40px; height: 40px"
                        >
                            {{ seatNumber }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.seat-container {
    overflow-x: auto;
    display: block;
    scroll-behavior: smooth;
    scrollbar-width: thin;
    scrollbar-color: #888 #f1f1f1;
}

.btn.disabled {
    cursor: not-allowed;
}
</style>
