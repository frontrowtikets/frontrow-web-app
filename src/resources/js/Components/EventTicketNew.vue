<script setup>
import { useQRCode } from "@vueuse/integrations/useQRCode";
import smallImageUrl from "../../images/logos/small.png";
import { computed } from 'vue'
import moment from 'moment'


const props = defineProps([
    "event",
    "userDetails",
    "transactionDetails",
    "ticketId",
    "ticketAmount",
    "ticketCategory"
]);


const qrcode = useQRCode(`${props.ticketId}`);

const screeningDate = computed(() => {
    const thedate = moment(props.event?.start_date).format(
        "ddd, DD MMM YYYY"
    );
    return thedate;
});
const purchaseDate = computed(() => {
    const thedate = moment(props.transactionDetails?.created_at).format(
        "ddd, DD MMM YYYY"
    );
    return thedate;
});
const screeningDate2 = computed(() => {
    const thedate = moment(props.event?.end_date).format(
        "ddd, DD MMM YYYY"
    );
    return thedate;
});
const startTime = computed(() => {
    const starts = moment(props.event?.start_time, "HH:mm:ss").format("h:mm A")
    return starts
}

);
const endTime = computed(() => {
    const ends = moment(props.event?.end_time, "HH:mm:ss").format("h:mm A");
    return ends
}

);
</script>

<template>
    <div class="p-5 d-flex align-items-center justify-content-center" id="eventticket">
        <div class="ticket-outer p-4" style="width: 95%; border: 3px solid #3498db; border-radius: 10px; position: relative; overflow: hidden;">
            <!-- Category watermark (repeating) -->
            <div v-if="props.ticketCategory" class="ticket-watermark" aria-hidden="true">
                <div v-for="row in 8" :key="row" class="watermark-row">
                    <span v-for="col in 5" :key="col">{{ props.ticketCategory }}</span>
                </div>
            </div>
            <div class="mb-5 d-flex justify-content-between" style="position: relative; z-index: 2;">
                <div class="d-flex align-items-center">
                    <div><img :src="smallImageUrl" height="90" /></div>
                    <div>
                        <h2 class="fw-bold" style="color: #47a2de">FRONTROW</h2>
                        <h5 style="color: #70aad1">EVENT TICKET</h5>
                    </div>
                </div>
                <div class="" style="border: 1.5px solid #3498db; border-radius: 4px; background: #fff;">
                    <img :src="qrcode" alt="QR Code" />
                </div>
            </div>
            <div class="p-4 mb-5 d-flex" style="background-color: #79bbe8; border-radius: 15px; position: relative; z-index: 2;">
                <div class="flex-grow-1">
                    <div class="" style="font-size: medium">
                        <h3 class="mb-4 fw-bold text-dark">
                            {{ props.event?.title }}
                        </h3>
                        <p class="d-flex justify-content-between">
                            <strong>Date:</strong>
                            <span style="color: black">{{
                                screeningDate
                            }}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <strong>Time:</strong>
                            <span style="color: black">{{ startTime }} to {{ endTime }}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <strong>Venue:</strong>
                            <span style="color: black">{{
                                props.event?.location_name
                            }}</span>
                        </p>

                    </div>
                </div>
            </div>

            <div class="mb-5" style="border-top: 2px dashed #3498db; position: relative; z-index: 2;">
                <div class="p-4" style="font-size: medium;border: 1px solid #3498db; border-radius: 10px">
                    <div class="" style="width: 70%;">
                        <p class="d-flex justify-content-between">
                            <strong>Ticket ID:</strong>
                            <span style="color: black">{{ props.ticketId }}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <strong>Price:</strong>
                            <span style="color: black">
                                {{ props.transactionDetails?.currency }}
                                {{ props.ticketAmount }}
                            </span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <strong>Purchase Date:</strong>
                            <span style="color: black">{{ purchaseDate }}</span>
                        </p>
                    </div>

                </div>
            </div>
            <div class="mb-5" style="position: relative; z-index: 2;">
                <p class="fw-bold " style="font-size: medium; color: #47a2de">Terms & Conditions:</p>
                <ul class="text-muted small ps-3">
                    <li>
                        This ticket is valid only for the specified show time
                        and date.
                    </li>
                    <li>Please arrive at least 15 minutes before show time.</li>
                    <li>No refunds or exchanges are permitted.</li>
                    <li>
                        Please keep this ticket safe and present it at the
                        entrance.
                    </li>
                </ul>
            </div>
        </div>
    </div>

</template>

<style scoped>
.barcode {
    background-color: aqua;
}

.ticket-watermark {
    position: absolute;
    top: -20%;
    left: -20%;
    width: 140%;
    height: 140%;
    transform: rotate(-30deg);
    pointer-events: none;
    z-index: 1;
    user-select: none;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 30px;
}

.watermark-row {
    display: flex;
    gap: 40px;
    white-space: nowrap;
}

.watermark-row span {
    font-size: 3rem;
    font-weight: 900;
    text-transform: uppercase;
    color: rgba(52, 152, 219, 0.07);
    letter-spacing: 0.12em;
}

.watermark-row:nth-child(even) {
    margin-left: 80px;
}
</style>
