<script setup>
import { computed, onMounted } from "vue";
import EventInvoice from "./EventInvoice.vue";
import EventTicket from "./EventTicket.vue";
import moment from "moment";
import Swal from "sweetalert2";
import html2pdf from "html2pdf.js";
import EventTicketNew from "./EventTicketNew.vue";


const props = defineProps([
    "ticketId",
    "status",
    "event",
    "userDetails",
    "transactionDetails",
    "ticketAmount"
]);


const showEndDateTime = computed(() => {
    const startDate = props?.event?.start_date;
    const endTime = props?.event?.end_time;
    return moment(`${startDate} ${endTime}`, "YYYY-MM-DD HH:mm");
});

const hasEnded = computed(() => {
    const currentTime = moment();
    return currentTime.isAfter(showEndDateTime.value);
});
function downloadInvoice() {
    Swal.fire({
        title: "Downloading...",
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    var element = document.getElementById("eventInvoicepdf");

    var options = {
        margin: 0.5,
        filename: "invoice.pdf",
        pagebreak: {
            after: "#break",
        },
        image: {
            type: "jpeg",
            quality: 5.0,
        },
        html2canvas: {
            scale: 1.0,
            useCORS: true,
        },
        jsPDF: {
            unit: "in",
            format: "a4",
            // orientation: "landscape",
            compress: true,
        },
    };
    html2pdf()
        .from(element)
        .set(options)
        .save()
        .then(() => {
            Swal.close();
        });
}

function downloadTicket(ticketId = null) {
    Swal.fire({
        title: "Downloading...",
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    var element = document.getElementById("eventticket");

    var options = {
        margin: 0.5,
        filename: `Event-Ticket-${ticketId}.pdf`,
        pagebreak: {
            after: "#break",
        },
        image: {
            type: "jpeg",
            quality: 1.0,
        },
        html2canvas: {
            scale: 3.0,
            useCORS: true,
            logging: false,
        },
        jsPDF: {
            unit: "in",
            format: "a4",
            // orientation: "landscape",
            compress: true,
        },
    };
    html2pdf()
        .from(element)
        .set(options)
        .save()
        .then(() => {
            Swal.close();
        });
}
</script>
<template>
    <div class="card2" :style="{
        backgroundImage: `url(${props?.event?.banner_image_url})`,
        backgroundSize: 'cover',
        backgroundPosition: 'center',
        backgroundRepeat: 'no-repeat',
    }">
        <div class="overlay">
            <div class="text">
                <div class="text-end">
                    <span v-if="hasEnded" class="badge text-bg-danger font-size-11">Expired</span>
                    <span v-else-if="(props.status = 'paid')" class="badge text-bg-success font-size-11">Active</span>
                </div>

                <span class="text-truncate">{{ props.event?.title }}</span>
                <small class="fw-light">{{ props.event?.location_name }}</small>
                <small class="fw-light">
                    {{
                        moment(props.event?.start_date).format(
                            " DD MMM YYYY"
                        )
                    }} - {{
                        moment(props.event?.end_date).format(
                            " DD MMM YYYY"
                        )
                    }}
                </small>
                <small class="fw-light">
                    From: {{
                        moment(props.event?.start_time, "HH:mm:ss").format("h:mm A")
                    }} to: {{ moment(props?.event?.end_time, "HH:mm:ss").format("h:mm A") }}
                </small>
            </div>
        </div>
        <div class="icons">
            <a class="btn" @click="downloadTicket(props.ticketId)">
                <svg y="0" xmlns="http://www.w3.org/2000/svg" x="0" width="100" viewBox="0 0 100 100"
                    preserveAspectRatio="xMidYMid meet" height="100" class="svg-icon">
                    <path stroke-width="8" stroke-linejoin="round" stroke-linecap="round" fill="none"
                        d="M31.8,64.5a14.5,14.5,0,0,1-3.2-28.7,17.5,17.5,0,0,1-.4-4,18.2,18.2,0,0,1,36-3.6h.3a18.2,18.2,0,0,1,3.7,36M39.1,75.4,50,86.3m0,0L60.9,75.4M50,86.3V42.7">
                    </path>
                </svg>
            </a>
            <a class="invisible btn" href="#">
                <svg class="svg-icon" viewBox="0 0 20 20">
                    <path
                        d="M4.317,16.411c-1.423-1.423-1.423-3.737,0-5.16l8.075-7.984c0.994-0.996,2.613-0.996,3.611,0.001C17,4.264,17,5.884,16.004,6.88l-8.075,7.984c-0.568,0.568-1.493,0.569-2.063-0.001c-0.569-0.569-0.569-1.495,0-2.064L9.93,8.828c0.145-0.141,0.376-0.139,0.517,0.005c0.141,0.144,0.139,0.375-0.006,0.516l-4.062,3.968c-0.282,0.282-0.282,0.745,0.003,1.03c0.285,0.284,0.747,0.284,1.032,0l8.074-7.985c0.711-0.71,0.711-1.868-0.002-2.579c-0.711-0.712-1.867-0.712-2.58,0l-8.074,7.984c-1.137,1.137-1.137,2.988,0.001,4.127c1.14,1.14,2.989,1.14,4.129,0l6.989-6.896c0.143-0.142,0.375-0.14,0.516,0.003c0.143,0.143,0.141,0.374-0.002,0.516l-6.988,6.895C8.054,17.836,5.743,17.836,4.317,16.411">
                    </path>
                </svg>
            </a>
            <div class="dropdown dropup">
                <div class="text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg y="0" xmlns="http://www.w3.org/2000/svg" x="0" width="100" viewBox="0 0 100 100"
                        preserveAspectRatio="xMidYMid meet" height="100" class="svg-icon">
                        <path stroke-width="8" stroke-linejoin="round" stroke-linecap="round" fill="none"
                            d="M21.9,50h0M50,50h0m28.1,0h0M25.9,50a4,4,0,1,1-4-4A4,4,0,0,1,25.9,50ZM54,50a4,4,0,1,1-4-4A4,4,0,0,1,54,50Zm28.1,0a4,4,0,1,1-4-4A4,4,0,0,1,82.1,50Z">
                        </path>
                    </svg>
                </div>
                <ul class="dropdown-menu dropdown-menu-top">
                    <li>
                        <a class="dropdown-item" role="button" @click="downloadTicket(props.ticketId)">Download
                            Ticket</a>
                    </li>
                    <!-- <li>
                        <a
                            class="dropdown-item"
                        role="button"
                            @click="downloadInvoice"
                            >Download Invoice</a
                        >
                    </li> -->
                </ul>
            </div>
        </div>
        <div class="d-none">
            <EventInvoice :event="props.event" :userDetails="props.userDetails"
                :transactionDetails="props.transactionDetails" />
        </div>
        <div class="d-none">
            <EventTicketNew :ticketId="props.ticketId" :event="props.event" :userDetails="props.userDetails"
                :transactionDetails="props.transactionDetails" :ticketAmount="props.ticketAmount" />
        </div>
    </div>
</template>
<style scoped>
.card2 {
    width: 250px;
    height: 200px;
    border-radius: 15px;
    background: rgba(149, 149, 149, 0.103);
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

.card2::before {
    content: "";
    height: 100px;
    width: 100px;
    position: absolute;
    top: -40%;
    left: -20%;
    border-radius: 50%;
    border: 35px solid rgba(149, 149, 149, 0.103);
    transition: all 0.8s ease;
    filter: blur(0.5rem);
}

.overlay {
    position: relative;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.4);
    backdrop-filter: blur(10px);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 15px;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.3);
}

.text {
    flex-grow: 1;
    padding: 15px;
    display: flex;
    flex-direction: column;
    color: aliceblue;
    font-weight: 900;
    font-size: 1.2em;
    z-index: 1;
    text-shadow: 0 0 8px rgba(0, 0, 0, 0.7);
}

.subtitle {
    font-size: 0.6em;
    font-weight: 300;
    color: rgba(240, 248, 255, 0.691);
}

.icons {
    display: flex;
    justify-items: center;
    align-items: center;
    width: 250px;
    border-radius: 0px 0px 15px 15px;
    overflow: hidden;
    background-color: #013f43;
}

.btn {
    border: none;
    width: 84px;
    height: 35px;
    background-color: #013f4389;
    display: flex;
    align-items: center;
    justify-content: center;
}

.svg-icon {
    width: 25px;
    height: 25px;
    stroke: #f6f6f6;
}

.card:hover::before {
    width: 140px;
    height: 140px;
    top: -30%;
    left: 50%;
    filter: blur(0rem);
}

/* Add these new styles for the dropdown */
.dropdown {
    position: absolute;
    right: 10%;
}

.dropdown-menu-top {
    bottom: 100%;
    top: auto !important;
    background-color: rgb(234, 235, 235);
    left: 100px;
    margin-bottom: 0.5rem;
}

/* Ensure dropdown is visible above the card */
.dropdown-menu {
    z-index: 1000;
}
</style>
