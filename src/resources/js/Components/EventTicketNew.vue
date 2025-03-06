<script setup>
import { useQRCode } from "@vueuse/integrations/useQRCode";
import smallImageUrl from "../../images/logos/small.png";
import {computed} from 'vue'
import moment from 'moment'


const props = defineProps([
    "event",
    "userDetails",
    "transactionDetails",
    "ticketId",
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
const startTime = computed(() =>{
    const starts = moment(props.event?.start_time, "HH:mm:ss").format("h:mm A")
    return starts
}

);
const endTime = computed(() =>{
    const ends = moment(props.event?.end_time, "HH:mm:ss").format("h:mm A");
    return ends
}

);
</script>

<template>
    <div class="p-5 d-flex align-items-center justify-content-center" id="eventticket">
        <div
            class="p-4"
            style="width: 95%; border: 3px solid #3498db; border-radius: 10px"
        >
            <div class="mb-5 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <div><img :src="smallImageUrl" height="90" /></div>
                    <div>
                        <h2 class="fw-bold" style="color: #47a2de">FRONTROW</h2>
                        <h5 style="color: #70aad1">EVENT TICKET</h5>
                    </div>
                </div>
                <div
                    class=""
                    style="border: 1.5px solid #3498db; border-radius: 4px"
                >
                    <img :src="qrcode" alt="QR Code" />
                </div>
            </div>
            <div
                class="p-4 mb-5 d-flex"
                style="background-color: #79bbe8; border-radius: 15px"
            >
                <div class="me-4">
                    <div
                        class=""
                        style="
                            background-color: gray;
                            width: 200px;
                            height: 250px;
                            border-radius: 15px;
                        "
                    >
                        <img :src="props.event?.thumbnail_url" style="object-fit: cover;"/>
                    </div>
                </div>
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

            <div class="mb-5"   style="border-top: 2px dashed #3498db;">
                <div class="p-4" style="font-size: medium;border: 1px solid #3498db; border-radius: 10px">
                    <div class="" style="width: 70%;">
                        <p class="d-flex justify-content-between">
                        <strong>Ticket ID:</strong>
                        <span style="color: black">{{ props.ticketId }}</span>
                    </p>
                    <p class="d-flex justify-content-between">
                        <strong>Price:</strong>
                        <span style="color: black">{{ props.transactionDetails?.currency }} {{ props.transactionDetails.amount }}</span>
                    </p>
                    <p class="d-flex justify-content-between">
                        <strong>Purchase Date:</strong>
                        <span style="color: black">{{ purchaseDate }}</span>
                    </p>
                    </div>

                </div>
            </div>
              <div class="mb-5">
                <p class="fw-bold " style="font-size: medium; color: #47a2de" >Terms & Conditions:</p>
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
</style>
