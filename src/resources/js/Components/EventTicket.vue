<script setup>
import { defineProps, computed } from "vue";
import moment from "moment";
import { useQRCode } from "@vueuse/integrations/useQRCode";


const appURL = import.meta.env.VITE_APP_URL;

const props = defineProps([
    "event",
    "userDetails",
    "transactionDetails",
    "ticketId",
]);

const qrcode = useQRCode(`${appURL}/verify/event/ticket/${props.ticketId}/${props.transactionDetails.id}/${props.userDetails.id}`);

const screeningDate = computed(() => {
    const thedate = moment(props.event.start_date).format(
        "ddd, DD MMM YYYY"
    );
    return thedate;
});
const screeningDate2 = computed(() => {
    const thedate = moment(props.event.end_date).format(
        "ddd, DD MMM YYYY"
    );
    return thedate;
});
const startTime = computed(() =>{
    const starts = moment(props.event.start_time, "HH:mm:ss").format("h:mm A")
    return starts
}

);
const endTime = computed(() =>{
    const ends = moment(props.event.end_time, "HH:mm:ss").format("h:mm A");
    return ends
}

);
</script>

<template>
    <div class="container py-4" id="eventticket">
        <div class="ticket-container">
            <div class="purple-border">
                <div class="shadow ticket-main">
                    <div class="pt-4 pb-4 text-center logo-section"></div>

                    <div
                        class="p-3 text-center text-white ticket-header bg-secondary"
                    >
                        <h2 class="mb-0 cinema-name">
                            {{ props.event.title }}
                        </h2>
                        <p class="mb-0">
                            {{ props.event.location_name }}
                        </p>
                    </div>

                    <div class="p-4 ticket-body">


                        <div class="mb-4 row">
                            <div class="col-6">
                                <p class="mb-1 label">Start Date</p>
                                <p class="value">{{ screeningDate }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 label">End Date</p>
                                <p class="value">{{ screeningDate2 }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 label">Start Time</p>
                                <p class="value">{{ startTime }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 label">End Time</p>
                                <p class="value">{{ endTime }}</p>
                            </div>
                        </div>


                        <div class="mb-4 customer-info">
                            <p class="mb-1 label">Guest</p>
                            <p class="value">
                                {{ props.userDetails.full_name }}
                            </p>
                        </div>
                        <div class="text-center qr-section">
                            <img :src="qrcode" alt="QR Code" />
                            <div class="p-3 text-center stub-content">
                                <p class="mb-1 small">
                                    {{ props.event.title }}
                                </p>
                                <p class="mb-1 small">{{ screeningDate }}</p>
                                <p class="mb-0 small">
                                    Ticket #{{ props.ticketId }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.ticket-container {
    max-width: 400px;
    margin: 0 auto;
    font-family: "Inter", sans-serif;
}

.space_seats {
    margin-left: 30px;
}

.purple-border {
    border: 1px #01676c;
    border-radius: 20px;
    padding: 1px;
    background: linear-gradient(145deg, #01676c, #01676ca7);
    padding: 4px;
}

.ticket-main {
    background: white;
    border-radius: 16px;
    overflow: hidden;
}

.cinema-logo {
    width: 100px;
    height: 40px;
    margin-bottom: 1rem;
}

.cinema-name {
    font-size: 1.5rem;
    font-weight: 700;
}

.movie-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.label {
    font-size: 0.875rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0;
}

.value {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0;
}

.seats-container {
    border-radius: 8px;
    background-color: #f8f8f8;
}

.seats-line {
    font-size: 0.9rem;
    color: #333;
    /* line-height: 1.6; */
}

.qr-code {
    width: 120px;
    height: 120px;
    object-fit: contain;
}

.ticket-stub {
    margin-top: 2px;
    background: white;
    border-radius: 8px;
    position: relative;
}

.ticket-stub::before {
    content: "";
    position: absolute;
    top: -2px;
    left: 0;
    right: 0;
    height: 2px;
    background: repeating-linear-gradient(
        90deg,
        #ccc 0px,
        #ccc 5px,
        transparent 5px,
        transparent 10px
    );
}

@media print {
    .shadow,
    .shadow-sm {
        box-shadow: none !important;
    }

    .bg-secondary {
        background-color: #1149ab !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .bg-light {
        background-color: #f8f8f8 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .purple-border {
        border: 1px solid #6f42c1 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background: none;
    }

    .badge {
        border: 1px solid #666;
    }

    .container {
        padding: 0;
        margin: 0;
    }
}
</style>
