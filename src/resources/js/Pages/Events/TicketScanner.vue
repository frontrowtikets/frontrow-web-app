<script setup>
import PageHeader from "@/js/Components/page-header.vue";
import { Head, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import { reactive, ref, computed } from "vue";
import { QrcodeStream } from "vue-qrcode-reader";
import axios from "axios";
import moment from "moment";

const props = defineProps({
    eventDetails: {
        type: Object,
        default: null,
    },
    event_id: {
        default: null,
    },
});

const state = reactive({
    items: [
        { text: "Events" },
        { text: "Ticket Scanner", active: true },
    ],
});

// Scanner state
const scannerActive = ref(true);
const cameraError = ref(null);
const isLoading = ref(false);

// Scanned ticket result
const scannedTicket = ref(null);
const scanResult = ref(null);
const scanMessage = ref("");

// Scan history for the session
const scanHistory = ref([]);
const showHistory = ref(false);

// Manual entry
const manualTicketId = ref("");
const showManualEntry = ref(false);

// Camera facing mode
const facingMode = ref("environment");

const cameraConstraints = computed(() => ({
    facingMode: facingMode.value,
}));

// Show scanner or result view on mobile
const showingResult = computed(() => scanResult.value !== null);

// Called when QR code is detected
async function onDetect(detectedCodes) {
    if (isLoading.value) return;

    const ticketId = detectedCodes[0]?.rawValue;
    if (!ticketId) return;

    await lookupTicket(ticketId);
}

async function lookupTicket(ticketId) {
    scannerActive.value = false;
    isLoading.value = true;
    scannedTicket.value = null;
    scanResult.value = null;

    try {
        const payload = { ticket_id: ticketId };
        if (props.event_id) {
            payload.event_id = props.event_id;
        }

        const response = await axios.post("/admin/scan-ticket/lookup", payload);

        scannedTicket.value = response.data.ticket;

        if (response.data.is_already_scanned) {
            scanResult.value = "already_scanned";
            scanMessage.value = `Already scanned at ${moment(response.data.scanned_at).format("DD MMM YYYY, h:mm A")}`;
            playSound("warning");
        } else if (response.data.event_ended) {
            scanResult.value = "event_ended";
            scanMessage.value = "This event has already ended.";
            playSound("warning");
        } else {
            scanResult.value = "success";
            scanMessage.value = "Valid ticket found. Ready to admit.";
            playSound("success");
        }
    } catch (error) {
        if (error.response?.status === 404) {
            scanResult.value = "not_found";
            scanMessage.value = "Invalid ticket. Not found in the system.";
            playSound("error");
        } else if (error.response?.status === 422) {
            scanResult.value = "wrong_event";
            scanMessage.value = error.response.data.message || "This ticket does not belong to this event.";
            playSound("error");
        } else {
            scanResult.value = "error";
            scanMessage.value = "Network error. Please try again.";
        }
    } finally {
        isLoading.value = false;
    }
}

async function admitTicket() {
    if (!scannedTicket.value) return;

    isLoading.value = true;
    try {
        const response = await axios.post("/admin/scan-ticket/mark-scanned", {
            ticket_id: scannedTicket.value.ticket_id,
        });

        if (response.data.status === "success") {
            scanResult.value = "admitted";
            scanMessage.value = "Ticket admitted successfully!";

            scanHistory.value.unshift({
                ticket_id: scannedTicket.value.ticket_id,
                name: scannedTicket.value.user_payment_detail?.full_name,
                category: scannedTicket.value.event_ticket?.category,
                time: moment().format("h:mm:ss A"),
            });

            playSound("success");
        }
    } catch (error) {
        if (error.response?.status === 409) {
            scanResult.value = "already_scanned";
            scanMessage.value = "This ticket was already scanned by another device.";
            playSound("warning");
        } else {
            scanMessage.value = "Failed to mark ticket. Try again.";
        }
    } finally {
        isLoading.value = false;
    }
}

function scanNext() {
    scannedTicket.value = null;
    scanResult.value = null;
    scanMessage.value = "";
    scannerActive.value = true;
    showManualEntry.value = false;
}

function manualLookup() {
    if (!manualTicketId.value.trim()) return;
    lookupTicket(manualTicketId.value.trim());
    manualTicketId.value = "";
}

function toggleCamera() {
    facingMode.value = facingMode.value === "environment" ? "user" : "environment";
}

function onCameraError(error) {
    if (error.name === "NotAllowedError") {
        cameraError.value = "Camera access denied. Please allow camera permissions in your browser settings.";
    } else if (error.name === "NotFoundError") {
        cameraError.value = "No camera found on this device.";
    } else {
        cameraError.value = `Camera error: ${error.message}`;
    }
}

function playSound(type) {
    try {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();
        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);
        gainNode.gain.value = 0.3;

        if (type === "success") {
            oscillator.frequency.value = 880;
        } else if (type === "warning") {
            oscillator.frequency.value = 440;
        } else {
            oscillator.frequency.value = 220;
        }
        oscillator.start();
        setTimeout(() => oscillator.stop(), 200);
    } catch (e) {
        // Audio not available
    }
}
</script>

<template>
    <DashboardLayout>

        <Head title="Ticket Scanner" />
        <PageHeader title="Ticket Scanner" :items="state.items" />

        <!-- Event context banner (compact on mobile) -->
        <div v-if="props.eventDetails" class="event-banner-strip">
            <i class="bx bx-calendar-event"></i>
            <div class="event-banner-text">
                <strong>{{ props.eventDetails.title }}</strong>
                <small>{{ moment(props.eventDetails.start_date).format("DD MMM YYYY") }} &middot; {{
                    props.eventDetails.location_name }}</small>
            </div>
        </div>

        <!-- Main scanner area -->
        <div class="scanner-page">

            <!-- Scanner View (hidden when showing result on mobile) -->
            <div class="scanner-section" :class="{ 'hide-on-mobile': showingResult }">
                <div class="scanner-card">
                    <!-- Camera error state -->
                    <div v-if="cameraError" class="camera-error">
                        <i class="bx bx-error-circle"></i>
                        <p>{{ cameraError }}</p>
                        <button class="btn-action btn-action--secondary" @click="cameraError = null">
                            Retry
                        </button>
                    </div>

                    <!-- QR Scanner -->
                    <div v-else class="scanner-viewport">
                        <QrcodeStream v-if="scannerActive" :constraints="cameraConstraints" @detect="onDetect"
                            @error="onCameraError">
                            <!-- Scan overlay/crosshair -->
                            <div class="scan-overlay">
                                <div class="scan-frame"></div>
                            </div>
                        </QrcodeStream>
                        <div v-else class="scanner-paused">
                            <i class="bx bx-pause-circle"></i>
                            <span>Scanner paused</span>
                        </div>
                    </div>

                    <!-- Scanner toolbar -->
                    <div class="scanner-toolbar">
                        <button class="toolbar-btn" @click="toggleCamera" title="Flip Camera">
                            <i class="bx bx-refresh"></i>
                            <span>Flip</span>
                        </button>
                        <button class="toolbar-btn" @click="showManualEntry = !showManualEntry" title="Manual Entry">
                            <i class="bx bx-keyboard"></i>
                            <span>Manual</span>
                        </button>
                        <button v-if="scanHistory.length > 0" class="toolbar-btn" @click="showHistory = !showHistory"
                            title="Scan History">
                            <i class="bx bx-history"></i>
                            <span>History ({{ scanHistory.length }})</span>
                        </button>
                    </div>

                    <!-- Manual entry (toggled) -->
                    <div v-if="showManualEntry" class="manual-entry">
                        <div class="manual-entry-input">
                            <input v-model="manualTicketId" type="text" placeholder="Enter ticket ID (e.g. FREXXXXXXXXXX)"
                                @keyup.enter="manualLookup" autofocus />
                            <button @click="manualLookup" :disabled="isLoading || !manualTicketId.trim()">
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Result View -->
            <div class="result-section" :class="{ 'show-on-mobile': showingResult }">

                <!-- Loading state -->
                <div v-if="isLoading" class="result-card result-card--loading">
                    <i class="bx bx-loader bx-spin"></i>
                    <p>Verifying ticket...</p>
                </div>

                <!-- No scan yet (desktop only) -->
                <div v-else-if="!scanResult" class="result-card result-card--empty">
                    <i class="bx bx-qr-scan"></i>
                    <p>Point camera at a ticket QR code</p>
                </div>

                <!-- Result display -->
                <div v-else class="result-card" :class="{
                    'result-card--success': scanResult === 'success',
                    'result-card--admitted': scanResult === 'admitted',
                    'result-card--warning': scanResult === 'already_scanned' || scanResult === 'event_ended',
                    'result-card--error': scanResult === 'not_found' || scanResult === 'wrong_event' || scanResult === 'error',
                }">
                    <!-- Status icon + message -->
                    <div class="result-status">
                        <div class="result-icon">
                            <i v-if="scanResult === 'success'" class="bx bx-check-circle"></i>
                            <i v-else-if="scanResult === 'admitted'" class="bx bx-check-double"></i>
                            <i v-else-if="scanResult === 'already_scanned' || scanResult === 'event_ended'"
                                class="bx bx-error"></i>
                            <i v-else class="bx bx-x-circle"></i>
                        </div>
                        <p class="result-message">{{ scanMessage }}</p>
                    </div>

                    <!-- Ticket details (when ticket found) -->
                    <div v-if="scannedTicket" class="ticket-info">
                        <div class="ticket-info-row">
                            <span class="ticket-label">Ticket ID</span>
                            <span class="ticket-value ticket-value--mono">{{ scannedTicket.ticket_id }}</span>
                        </div>
                        <div class="ticket-info-row">
                            <span class="ticket-label">Event</span>
                            <span class="ticket-value">{{ scannedTicket.event?.title }}</span>
                        </div>
                        <div v-if="scannedTicket.event_ticket?.category" class="ticket-info-row">
                            <span class="ticket-label">Category</span>
                            <span class="ticket-value">
                                <span class="category-badge">{{ scannedTicket.event_ticket?.category }}</span>
                            </span>
                        </div>
                        <div class="ticket-info-row">
                            <span class="ticket-label">Attendee</span>
                            <span class="ticket-value">{{ scannedTicket.user_payment_detail?.full_name }}</span>
                        </div>
                        <div class="ticket-info-row">
                            <span class="ticket-label">Email</span>
                            <span class="ticket-value">{{ scannedTicket.user_email }}</span>
                        </div>
                        <div class="ticket-info-row">
                            <span class="ticket-label">Amount</span>
                            <span class="ticket-value">{{ scannedTicket.payment_transaction?.currency }} {{
                                scannedTicket.total_amount }}</span>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="result-actions">
                        <button v-if="scanResult === 'success'" class="btn-action btn-action--admit"
                            @click="admitTicket" :disabled="isLoading">
                            <i class="bx bx-check-circle"></i>
                            Admit Ticket Holder
                        </button>
                        <button class="btn-action btn-action--next" @click="scanNext">
                            <i class="bx bx-qr-scan"></i>
                            Scan Next Ticket
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scan history (slide-up panel) -->
        <div v-if="showHistory && scanHistory.length > 0" class="history-panel">
            <div class="history-header">
                <h6>Admitted This Session ({{ scanHistory.length }})</h6>
                <button class="history-close" @click="showHistory = false">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="history-list">
                <div v-for="(scan, idx) in scanHistory" :key="idx" class="history-item">
                    <div class="history-item-main">
                        <span class="history-name">{{ scan.name }}</span>
                        <span class="history-category">{{ scan.category || '-' }}</span>
                    </div>
                    <div class="history-item-meta">
                        <span class="history-ticket">{{ scan.ticket_id }}</span>
                        <span class="history-time">{{ scan.time }}</span>
                    </div>
                </div>
            </div>
        </div>

    </DashboardLayout>
</template>

<style scoped>
/* ===== Event Banner ===== */
.event-banner-strip {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #e8f4fd;
    border: 1px solid #bee5eb;
    border-radius: 8px;
    padding: 10px 14px;
    margin-bottom: 16px;
    font-size: 0.85rem;
    color: #0c5460;
}

.event-banner-strip i {
    font-size: 1.4rem;
    flex-shrink: 0;
}

.event-banner-text {
    display: flex;
    flex-direction: column;
    gap: 1px;
    min-width: 0;
}

.event-banner-text strong {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.event-banner-text small {
    color: #6b8a94;
}

/* ===== Page Layout ===== */
.scanner-page {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* ===== Scanner Section ===== */
.scanner-card {
    background: #000;
    border-radius: 12px;
    overflow: hidden;
}

.scanner-viewport {
    width: 100%;
    position: relative;
    aspect-ratio: 4 / 3;
    overflow: hidden;
}

.scanner-viewport :deep(video) {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Scan overlay with crosshair frame */
.scan-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}

.scan-frame {
    width: 65%;
    aspect-ratio: 1;
    border: 3px solid rgba(255, 255, 255, 0.7);
    border-radius: 16px;
    box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.35);
    animation: scan-pulse 2s ease-in-out infinite;
}

@keyframes scan-pulse {
    0%, 100% { border-color: rgba(255, 255, 255, 0.7); }
    50% { border-color: rgba(52, 152, 219, 0.9); }
}

.scanner-paused {
    width: 100%;
    aspect-ratio: 4 / 3;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #1a1a1a;
    color: #888;
    font-size: 0.9rem;
}

.scanner-paused i {
    font-size: 2.5rem;
}

.camera-error {
    padding: 32px 20px;
    text-align: center;
    color: #e74c3c;
    background: #1a1a1a;
}

.camera-error i {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 12px;
}

.camera-error p {
    color: #ccc;
    font-size: 0.9rem;
    margin-bottom: 16px;
}

/* ===== Scanner Toolbar ===== */
.scanner-toolbar {
    display: flex;
    justify-content: center;
    gap: 4px;
    padding: 8px;
    background: #111;
}

.toolbar-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    padding: 8px 16px;
    background: none;
    border: none;
    color: #ccc;
    font-size: 0.7rem;
    cursor: pointer;
    border-radius: 8px;
    transition: background 0.2s;
    -webkit-tap-highlight-color: transparent;
}

.toolbar-btn:active {
    background: rgba(255, 255, 255, 0.1);
}

.toolbar-btn i {
    font-size: 1.3rem;
}

/* ===== Manual Entry ===== */
.manual-entry {
    padding: 12px;
    background: #1a1a1a;
}

.manual-entry-input {
    display: flex;
    gap: 8px;
}

.manual-entry-input input {
    flex: 1;
    padding: 12px 14px;
    border: 1px solid #333;
    border-radius: 8px;
    background: #222;
    color: #fff;
    font-size: 0.95rem;
    outline: none;
}

.manual-entry-input input:focus {
    border-color: #3498db;
}

.manual-entry-input input::placeholder {
    color: #666;
}

.manual-entry-input button {
    padding: 12px 18px;
    background: #3498db;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
}

.manual-entry-input button:disabled {
    opacity: 0.5;
}

/* ===== Result Section ===== */
.result-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.result-card--loading,
.result-card--empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 48px 20px;
    color: #999;
}

.result-card--loading i,
.result-card--empty i {
    font-size: 2.5rem;
    margin-bottom: 12px;
}

.result-card--empty {
    display: none;
}

/* ===== Result Status Banner ===== */
.result-status {
    padding: 20px;
    text-align: center;
}

.result-icon {
    font-size: 2.8rem;
    margin-bottom: 8px;
}

.result-message {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
}

.result-card--success .result-status {
    background: #d4edda;
    color: #155724;
}

.result-card--admitted .result-status {
    background: #d4edda;
    color: #155724;
}

.result-card--warning .result-status {
    background: #fff3cd;
    color: #856404;
}

.result-card--error .result-status {
    background: #f8d7da;
    color: #721c24;
}

/* ===== Ticket Info ===== */
.ticket-info {
    padding: 12px 16px;
}

.ticket-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.ticket-info-row:last-child {
    border-bottom: none;
}

.ticket-label {
    font-size: 0.8rem;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    font-weight: 600;
    flex-shrink: 0;
}

.ticket-value {
    font-size: 0.95rem;
    color: #1f2937;
    font-weight: 500;
    text-align: right;
    word-break: break-all;
    margin-left: 12px;
}

.ticket-value--mono {
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
}

.category-badge {
    display: inline-block;
    padding: 3px 10px;
    background: #3498db;
    color: #fff;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* ===== Action Buttons ===== */
.result-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 16px;
}

.btn-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 12px;
    font-size: 1.05rem;
    font-weight: 700;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
    transition: transform 0.1s, opacity 0.2s;
}

.btn-action:active {
    transform: scale(0.98);
}

.btn-action:disabled {
    opacity: 0.6;
}

.btn-action i {
    font-size: 1.3rem;
}

.btn-action--admit {
    background: #27ae60;
    color: #fff;
    min-height: 60px;
    font-size: 1.15rem;
}

.btn-action--next {
    background: #f0f0f0;
    color: #333;
}

.btn-action--secondary {
    background: #444;
    color: #fff;
    padding: 12px 24px;
}

/* ===== History Panel ===== */
.history-panel {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    margin-top: 16px;
    overflow: hidden;
}

.history-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    border-bottom: 1px solid #eee;
}

.history-header h6 {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 700;
    color: #333;
}

.history-close {
    background: none;
    border: none;
    font-size: 1.4rem;
    color: #999;
    cursor: pointer;
    padding: 4px;
    line-height: 1;
    -webkit-tap-highlight-color: transparent;
}

.history-list {
    max-height: 300px;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}

.history-item {
    padding: 10px 16px;
    border-bottom: 1px solid #f5f5f5;
}

.history-item:last-child {
    border-bottom: none;
}

.history-item-main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2px;
}

.history-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: #1f2937;
}

.history-category {
    font-size: 0.75rem;
    padding: 2px 8px;
    background: #e8f4fd;
    color: #2980b9;
    border-radius: 12px;
    font-weight: 600;
}

.history-item-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    color: #999;
}

.history-ticket {
    font-family: 'Courier New', monospace;
}

/* ===== Desktop: side-by-side layout ===== */
@media (min-width: 992px) {
    .scanner-page {
        flex-direction: row;
        align-items: flex-start;
    }

    .scanner-section {
        flex: 1;
        max-width: 500px;
    }

    .result-section {
        flex: 1;
    }

    .result-card--empty {
        display: flex;
    }

    .hide-on-mobile {
        display: block !important;
    }

    .scanner-viewport {
        aspect-ratio: 1;
    }
}

/* ===== Mobile: stacked, scanner hides when showing result ===== */
@media (max-width: 991px) {
    .scanner-section.hide-on-mobile {
        display: none;
    }

    .result-section {
        display: none;
    }

    .result-section.show-on-mobile {
        display: block;
    }

    .result-card--loading {
        display: flex;
    }
}

/* Small phone adjustments */
@media (max-width: 380px) {
    .toolbar-btn {
        padding: 8px 10px;
    }

    .toolbar-btn span {
        font-size: 0.65rem;
    }

    .result-icon {
        font-size: 2.2rem;
    }

    .result-message {
        font-size: 0.9rem;
    }

    .btn-action--admit {
        min-height: 54px;
        font-size: 1.05rem;
    }
}

/* Prevent user-select for UI elements on touch */
.scanner-toolbar,
.result-actions,
.toolbar-btn,
.btn-action {
    user-select: none;
    -webkit-user-select: none;
}
</style>
