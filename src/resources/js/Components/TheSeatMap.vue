<script setup>
import { ref, onMounted } from "vue";

const props = defineProps({
    // Change rowSeats to include seat counts
    rowData: {
        type: Array,
        required: true,
        // Expected format: [{ row: 'A', seatCount: 10 }, { row: 'B', seatCount: 15 }]
    },
    reserved: {
        type: Array,
        required: true,
    },
    theatre: {
        type: Object,
        required: true,
    },
    roomName: {
        type: String,
        required: true,
    },
});

const rows = ref([]);
const selectedSeats = ref([]);
const reservedSeats = ref([]);

onMounted(() => {
    rows.value = props.rowData;
    reservedSeats.value = props.reserved;
});

const toggleSeat = (seatId) => {
    const index = selectedSeats.value.indexOf(seatId);
    if (index > -1) {
        selectedSeats.value.splice(index, 1);
    } else {
        selectedSeats.value.push(seatId);
    }
};

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
            <p class="text-muted small">
                {{ props.theatre.theatre }}({{ props.roomName }})
            </p>
        </div>

        <div class="row">
            <div class="col-12">
                <div
                    class="overflow-auto seat-container"
                    style="white-space: nowrap"
                >
                    <div
                        v-for="rowInfo in rows"
                        :key="rowInfo.row"
                        class="mb-2 d-flex align-items-center"
                        style="min-width: fit-content"
                    >
                        <span class="me-2 fw-bold" style="width: 30px">
                            {{ rowInfo.row }}
                        </span>

                        <button
                            v-for="seatNumber in rowInfo.seatCount"
                            :key="`${rowInfo.row}${seatNumber}`"
                            :class="[
                                'btn m-1',
                                {
                                    'btn-danger disabled':
                                        getSeatStatus(
                                            `${rowInfo.row}${seatNumber}`
                                        ) === 'reserved',
                                    'btn-success':
                                        getSeatStatus(
                                            `${rowInfo.row}${seatNumber}`
                                        ) === 'selected',
                                    'btn-primary':
                                        getSeatStatus(
                                            `${rowInfo.row}${seatNumber}`
                                        ) === 'available',
                                },
                            ]"
                            :disabled="
                                getSeatStatus(`${rowInfo.row}${seatNumber}`) ===
                                'reserved'
                            "
                            @click="toggleSeat(`${rowInfo.row}${seatNumber}`)"
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
