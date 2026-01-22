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
    const filename = `Event_Invoice_${props.ticketId}.pdf`;
    var options = {
        margin: 0.5,
        filename: filename,
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

function downloadTicket() {
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
    const filename = `Event-Ticket-${props.ticketId}.pdf`;
    var options = {
        margin: 0.5,
        filename: filename,
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

const formatDate = (dateStr) => {
    return moment(dateStr).format("DD MMM YYYY");
};

onMounted(() => {
    console.log("EventTicketList mounted");
    console.log("Props:", props);
});
</script>

<template>
    <tr class="ticket-row">
        <!-- Event Banner & Title -->
        <td class="event-cell">
            <div class="event-info">
                <img :src="props.event?.banner_image_url" :alt="props.event?.title" class="event-banner" />
                <div class="event-details">
                    <h6 class="event-title">{{ props.event?.title }}</h6>
                    <small class="text-muted">{{ props.event?.location_name }}</small>
                </div>
            </div>
        </td>

        <!-- Ticket ID -->
        <td class="ticket-id-cell">
            <span class="ticket-id">#{{ props.ticketId }}</span>
        </td>

        <!-- Event Date & Time -->
        <td class="datetime-cell">
            <div class="datetime-info">
                <div class="event-date">
                    {{ moment(props.event?.start_date).format("DD MMM YYYY") }} -
                    {{ moment(props.event?.end_date).format("DD MMM YYYY") }}
                </div>
                <div class="event-time">
                    {{ moment(props.event?.start_time, "HH:mm:ss").format("h:mm A") }} -
                    {{ moment(props.event?.end_time, "HH:mm:ss").format("h:mm A") }}
                </div>
            </div>
        </td>

        <!-- Amount -->
        <td class="amount-cell">
            <span class="amount">
                {{ props?.transactionDetails?.currency }} {{ props.ticketAmount || '0.00' }}
            </span>
        </td>

        <!-- Customer Name -->
        <td class="ticket-id-cell">
            <span class="ticket-id">{{ props.userDetails?.full_name }}</span>
        </td>

        <!-- Status -->
        <td class="status-cell">
            <span v-if="hasEnded" class="badge badge-expired">Expired</span>
            <span v-else-if="(props.status === 'paid')" class="badge badge-active">Active</span>
            <span v-else class="badge badge-pending">{{ props.status }}</span>
        </td>

        <!-- Transaction Date -->
        <td class="ticket-id-cell">
            <span class="ticket-id">{{ formatDate(props.transactionDetails?.created_at) }}</span>
        </td>

        <!-- Actions -->
        <td class="actions-cell">
            <div class="action-buttons">
                <div class="dropdown">
                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <svg class="btn-icon" viewBox="0 0 100 100">
                            <path stroke-width="8" stroke-linejoin="round" stroke-linecap="round" fill="none"
                                d="M21.9,50h0M50,50h0m28.1,0h0M25.9,50a4,4,0,1,1-4-4A4,4,0,0,1,25.9,50ZM54,50a4,4,0,1,1-4-4A4,4,0,0,1,54,50Zm28.1,0a4,4,0,1,1-4-4A4,4,0,0,1,82.1,50Z">
                            </path>
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" role="button" @click="downloadTicket">
                                <svg class="dropdown-icon" viewBox="0 0 100 100">
                                    <path stroke-width="8" stroke-linejoin="round" stroke-linecap="round" fill="none"
                                        d="M31.8,64.5a14.5,14.5,0,0,1-3.2-28.7,17.5,17.5,0,0,1-.4-4,18.2,18.2,0,0,1,36-3.6h.3a18.2,18.2,0,0,1,3.7,36M39.1,75.4,50,86.3m0,0L60.9,75.4M50,86.3V42.7">
                                    </path>
                                </svg>
                                Download Ticket
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" role="button" @click="downloadInvoice">
                                <svg class="dropdown-icon" viewBox="0 0 100 100">
                                    <path stroke-width="8" stroke-linejoin="round" stroke-linecap="round" fill="none"
                                        d="M31.8,64.5a14.5,14.5,0,0,1-3.2-28.7,17.5,17.5,0,0,1-.4-4,18.2,18.2,0,0,1,36-3.6h.3a18.2,18.2,0,0,1,3.7,36M39.1,75.4,50,86.3m0,0L60.9,75.4M50,86.3V42.7">
                                    </path>
                                </svg>
                                Download Invoice
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </td>

        <!-- Hidden components for PDF generation -->
        <td class="d-none">
            <EventInvoice :event="props.event" :userDetails="props.userDetails"
                :transactionDetails="props.transactionDetails" />
        </td>
        <td class="d-none">
            <EventTicketNew :ticketId="props.ticketId" :event="props.event" :userDetails="props.userDetails"
                :transactionDetails="props.transactionDetails" :ticketAmount="props.ticketAmount" />
        </td>
    </tr>
</template>

<style scoped>
.ticket-row {
    border-bottom: 1px solid #e5e7eb;
    transition: background-color 0.2s ease;
}

.ticket-row:hover {
    background-color: #f9fafb;
}

/* Event cell */
.event-cell {
    padding: 12px 16px;
    min-width: 250px;
}

.event-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.event-banner {
    width: 50px;
    height: 75px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.event-details {
    flex-grow: 1;
    min-width: 0;
}

.event-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 4px 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Ticket ID cell */
.ticket-id-cell {
    padding: 12px 16px;
    min-width: 120px;
}

.ticket-id {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #4b5563;
    font-size: 0.9rem;
}

/* Date and time cell */
.datetime-cell {
    padding: 12px 16px;
    min-width: 180px;
}

.datetime-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.event-date {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.9rem;
}

.event-time {
    font-size: 0.8rem;
    color: #6b7280;
}

/* Amount cell */
.amount-cell {
    padding: 12px 16px;
    text-align: right;
    min-width: 100px;
}

.amount {
    font-weight: 700;
    color: #059669;
    font-size: 1rem;
}

/* Status cell */
.status-cell {
    padding: 12px 16px;
    min-width: 100px;
}

.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    display: inline-block;
}

.badge-expired {
    background-color: #fef2f2;
    color: #dc2626;
    border: 1px solid #fca5a5;
}

.badge-active {
    background-color: #f0fdf4;
    color: #16a34a;
    border: 1px solid #86efac;
}

.badge-pending {
    background-color: #fef3c7;
    color: #d97706;
    border: 1px solid #fcd34d;
}

/* Actions cell */
.actions-cell {
    padding: 12px 16px;
    min-width: 120px;
}

.action-buttons {
    display: flex;
    gap: 6px;
    align-items: center;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-sm {
    padding: 6px 8px;
    font-size: 0.8rem;
}

.btn-primary {
    background-color: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background-color: #2563eb;
    transform: translateY(-1px);
}

.btn-secondary {
    background-color: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background-color: #4b5563;
}

.btn-icon {
    width: 16px;
    height: 16px;
    stroke: currentColor;
}

/* Dropdown styles */
.dropdown {
    position: relative;
}

.dropdown-menu {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    padding: 4px 0;
    min-width: 180px;
    z-index: 1000;
}

.dropdown-menu-end {
    right: 0;
    left: auto;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    color: #374151;
    text-decoration: none;
    font-size: 0.85rem;
    transition: background-color 0.2s ease;
    cursor: pointer;
}

.dropdown-item:hover {
    background-color: #f9fafb;
    color: #1f2937;
}

.dropdown-icon {
    width: 14px;
    height: 14px;
    stroke: currentColor;
}

/* Responsive styles */
@media (max-width: 1024px) {
    .event-cell {
        min-width: 200px;
    }

    .event-banner {
        width: 40px;
        height: 60px;
    }

    .event-title {
        font-size: 0.85rem;
    }

    .datetime-cell {
        min-width: 150px;
    }
}

@media (max-width: 768px) {
    .ticket-row {
        font-size: 0.85rem;
    }

    .event-cell,
    .datetime-cell,
    .ticket-id-cell {
        min-width: auto;
        padding: 8px 12px;
    }

    .event-banner {
        width: 35px;
        height: 50px;
    }

    .action-buttons {
        gap: 4px;
    }

    .btn-sm {
        padding: 4px 6px;
    }

    .btn-icon {
        width: 14px;
        height: 14px;
    }
}

/* Table header styles (if you want to add a header row) */
.table-header {
    background-color: #f8fafc;
    border-bottom: 2px solid #e5e7eb;
}

.table-header th {
    padding: 16px;
    font-weight: 600;
    color: #374151;
    text-align: left;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}
</style>