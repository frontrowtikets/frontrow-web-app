<script setup>
import { Head, useForm, router } from "@inertiajs/vue3";
import { reactive, ref, watch, computed } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import Stepper from "@/js/Components/Stepper.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import Swal from "sweetalert2";
import axios from "axios";
import moment from "moment";

const props = defineProps({
    events: { type: Array, default: () => [] },
    createdTickets: { type: Array, default: null },
    createdEventId: { default: null },
    createdEventTitle: { type: String, default: "" },
    isNewUser: { type: Boolean, default: false },
    userName: { type: String, default: "" },
});

const state = reactive({
    items: [
        { text: "Admin" },
        { text: "Create Ticket", active: true },
    ],
});

// Form state
const form = useForm({
    event_id: "",
    customer_name: "",
    customer_email: "",
    customer_phone: "",
    event_ticket_id: "",
    quantity: 1,
    payment_reference: "",
    payment_method: "admin_manual",
    amount: 0,
});

// Local state
const selectedEvent = ref(null);
const selectedTicketType = ref(null);
const ticketTypes = ref([]);
const userSearchQuery = ref("");
const userSearchResults = ref([]);
const selectedUser = ref(null);
const isSearchingUser = ref(false);
const isLoadingTicketTypes = ref(false);
const submissionSuccess = ref(false);
const createdTicketsLocal = ref([]);

const paymentMethods = [
    { label: "Admin / Manual", value: "admin_manual" },
    { label: "Cash", value: "cash" },
    { label: "Mobile Money", value: "mobile_money" },
    { label: "Bank Transfer", value: "bank_transfer" },
];

// Generate default payment reference
function generatePaymentReference() {
    form.payment_reference = "ADMIN-" + Date.now();
}

// Computed: total amount based on ticket price * quantity
const calculatedAmount = computed(() => {
    if (!selectedTicketType.value) return 0;
    return selectedTicketType.value.price * form.quantity;
});

// Watch: when event changes, load ticket types
watch(selectedEvent, async (event) => {
    if (!event) {
        ticketTypes.value = [];
        selectedTicketType.value = null;
        form.event_id = "";
        return;
    }
    form.event_id = event.id;

    // Use eager-loaded ticket types if available
    if (event.event_tickets && event.event_tickets.length > 0) {
        ticketTypes.value = event.event_tickets;
    } else {
        isLoadingTicketTypes.value = true;
        try {
            const res = await axios.get(`/admin/event-ticket-types/${event.id}`);
            ticketTypes.value = res.data;
        } catch (e) {
            ticketTypes.value = [];
        } finally {
            isLoadingTicketTypes.value = false;
        }
    }
    selectedTicketType.value = null;
    form.event_ticket_id = "";
});

// Watch: when ticket type changes
watch(selectedTicketType, (tt) => {
    if (tt) {
        form.event_ticket_id = tt.id;
        form.amount = tt.price * form.quantity;
    } else {
        form.event_ticket_id = "";
        form.amount = 0;
    }
});

// Watch: when quantity changes
watch(() => form.quantity, (qty) => {
    if (selectedTicketType.value) {
        form.amount = selectedTicketType.value.price * qty;
    }
});

// Watch: when a user is selected from search
watch(selectedUser, (user) => {
    if (user) {
        form.customer_name = user.name || "";
        form.customer_email = user.email || "";
        form.customer_phone = user.phone_number || "";
    }
});

// User search with debounce
let searchTimeout = null;
watch(userSearchQuery, (query) => {
    clearTimeout(searchTimeout);
    if (!query || query.length < 2) {
        userSearchResults.value = [];
        return;
    }
    searchTimeout = setTimeout(async () => {
        isSearchingUser.value = true;
        try {
            const res = await axios.get("/admin/search-user", { params: { q: query } });
            userSearchResults.value = res.data;
        } catch (e) {
            userSearchResults.value = [];
        } finally {
            isSearchingUser.value = false;
        }
    }, 400);
});

function selectUser(user) {
    selectedUser.value = user;
    userSearchQuery.value = "";
    userSearchResults.value = [];
}

function clearSelectedUser() {
    selectedUser.value = null;
    form.customer_name = "";
    form.customer_email = "";
    form.customer_phone = "";
}

// Format currency
function formatCurrency(val) {
    return Number(val).toLocaleString();
}

function slugify(title) {
    return title.toLowerCase().replace(/[^a-z0-9]+/g, "-").replace(/(^-|-$)/g, "");
}

// Submit form
const isSubmitting = ref(false);

function submitForm() {
    if (isSubmitting.value || form.processing) return;

    Swal.fire({
        title: "Create Tickets?",
        html: `<p>This will create <strong>${form.quantity}</strong> ticket(s) for <strong>${form.customer_name}</strong>.</p>`,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#013F43",
        confirmButtonText: "Yes, Create",
    }).then((result) => {
        if (result.isConfirmed) {
            isSubmitting.value = true;
            form.post("/admin/create-ticket", {
                onSuccess: () => {
                    // Success is handled by watching props.createdTickets
                },
                onError: (errors) => {
                    const firstError = Object.values(errors)[0];
                    Swal.fire({
                        title: "Error",
                        text: firstError,
                        icon: "error",
                    });
                },
                onFinish: () => {
                    isSubmitting.value = false;
                },
            });
        }
    });
}

function resetWizard() {
    form.reset();
    selectedEvent.value = null;
    selectedTicketType.value = null;
    selectedUser.value = null;
    userSearchQuery.value = "";
    submissionSuccess.value = false;
    createdTicketsLocal.value = [];
    generatePaymentReference();
}

// React to props.createdTickets (set after form POST via Inertia)
watch(() => props.createdTickets, (tickets) => {
    if (tickets && tickets.length > 0) {
        createdTicketsLocal.value = tickets;
        submissionSuccess.value = true;
    }
}, { immediate: true });

generatePaymentReference();
</script>

<template>
    <DashboardLayout>

        <Head title="Admin - Create Ticket" />
        <PageHeader title="Create Event Ticket" :items="state.items" />

        <!-- Success State -->
        <div v-if="submissionSuccess" class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bx bx-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="mb-2">Tickets Created Successfully!</h4>
                        <p class="text-muted mb-4">
                            {{ createdTicketsLocal.length }} ticket(s) created
                            <span v-if="props.isNewUser"> for new user <strong>{{ props.userName }}</strong></span>
                            <span v-else> for <strong>{{ props.userName }}</strong></span>
                        </p>

                        <div class="table-responsive mb-4">
                            <table class="table table-sm table-bordered" style="max-width: 400px; margin: 0 auto;">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Ticket ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(ticket, idx) in createdTicketsLocal" :key="ticket.id">
                                        <td>{{ idx + 1 }}</td>
                                        <td class="font-monospace">{{ ticket.ticket_id }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn-primary" @click="resetWizard">
                                <i class="bx bx-plus me-1"></i> Create More Tickets
                            </button>
                            <a v-if="props.createdEventId" :href="`/eventmanager/${slugify(props.createdEventTitle)}/${props.createdEventId}`"
                                class="btn btn-outline-secondary">
                                <i class="bx bx-list-ul me-1"></i> View in Event Manager
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wizard -->
        <div v-else class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <Stepper :steps="['Select Event', 'Customer', 'Ticket & Payment', 'Review']">
                            <template #default="{ currentStep }">

                                <!-- STEP 1: Select Event -->
                                <div v-if="currentStep === 1">
                                    <h5 class="mb-4">Select Event</h5>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Event</label>
                                        <v-select v-model="selectedEvent" :options="props.events" label="title"
                                            placeholder="Search for an event..." :reduce="e => e">
                                            <template #option="event">
                                                <div>
                                                    <strong>{{ event.title }}</strong>
                                                    <br />
                                                    <small class="text-muted">
                                                        {{ moment(event.start_date).format("DD MMM YYYY") }}
                                                        &middot; {{ event.location_name }}
                                                    </small>
                                                </div>
                                            </template>
                                        </v-select>
                                    </div>

                                    <!-- Event preview -->
                                    <div v-if="selectedEvent" class="alert alert-light border mt-3">
                                        <h6 class="mb-2">{{ selectedEvent.title }}</h6>
                                        <div class="row text-muted small">
                                            <div class="col-sm-6">
                                                <i class="bx bx-calendar me-1"></i>
                                                {{ moment(selectedEvent.start_date).format("DD MMM YYYY") }}
                                                - {{ moment(selectedEvent.end_date).format("DD MMM YYYY") }}
                                            </div>
                                            <div class="col-sm-6">
                                                <i class="bx bx-map me-1"></i>
                                                {{ selectedEvent.location_name }}
                                            </div>
                                        </div>
                                        <div class="mt-2 small">
                                            <strong>Ticket types:</strong>
                                            <span v-if="isLoadingTicketTypes">Loading...</span>
                                            <span v-else-if="ticketTypes.length === 0" class="text-danger">No ticket
                                                types configured</span>
                                            <span v-else>
                                                <span v-for="(tt, i) in ticketTypes" :key="tt.id">
                                                    {{ tt.category }} ({{ tt.currency }} {{ formatCurrency(tt.price)
                                                    }})<span v-if="i < ticketTypes.length - 1">, </span>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- STEP 2: Customer Details -->
                                <div v-if="currentStep === 2">
                                    <h5 class="mb-4">Customer Details</h5>

                                    <!-- User search -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Search Existing Customer</label>
                                        <div class="position-relative">
                                            <input v-model="userSearchQuery" type="text" class="form-control"
                                                placeholder="Search by name, email, or phone..."
                                                :disabled="!!selectedUser" />
                                            <div v-if="isSearchingUser"
                                                class="position-absolute end-0 top-50 translate-middle-y pe-3">
                                                <i class="bx bx-loader bx-spin"></i>
                                            </div>
                                        </div>

                                        <!-- Search results dropdown -->
                                        <div v-if="userSearchResults.length > 0" class="list-group mt-1 shadow-sm">
                                            <button v-for="user in userSearchResults" :key="user.id"
                                                class="list-group-item list-group-item-action"
                                                @click="selectUser(user)">
                                                <div class="d-flex justify-content-between">
                                                    <strong>{{ user.name }}</strong>
                                                    <small class="text-muted">{{ user.email }}</small>
                                                </div>
                                                <small class="text-muted">{{ user.phone_number }}</small>
                                            </button>
                                        </div>

                                        <!-- Selected user badge -->
                                        <div v-if="selectedUser" class="mt-2">
                                            <span class="badge bg-info text-dark p-2">
                                                Existing user: {{ selectedUser.name }} ({{ selectedUser.email }})
                                                <button type="button" class="btn-close btn-close-sm ms-2"
                                                    @click="clearSelectedUser" style="font-size: 0.6rem;"></button>
                                            </span>
                                        </div>
                                    </div>

                                    <hr />
                                    <p class="text-muted small mb-3">
                                        <span v-if="selectedUser">Edit details if needed, or leave as-is.</span>
                                        <span v-else>Enter the customer's details below. A new account will be
                                            created.</span>
                                    </p>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Full Name <span
                                                    class="text-danger">*</span></label>
                                            <input v-model="form.customer_name" type="text" class="form-control"
                                                placeholder="e.g. John Doe"
                                                :class="{ 'is-invalid': form.errors.customer_name }" />
                                            <div class="invalid-feedback">{{ form.errors.customer_name }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input v-model="form.customer_email" type="email" class="form-control"
                                                placeholder="e.g. john@example.com"
                                                :class="{ 'is-invalid': form.errors.customer_email }" />
                                            <div class="invalid-feedback">{{ form.errors.customer_email }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <input v-model="form.customer_phone" type="text" class="form-control"
                                                placeholder="e.g. +256700000000"
                                                :class="{ 'is-invalid': form.errors.customer_phone }" />
                                            <div class="invalid-feedback">{{ form.errors.customer_phone }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- STEP 3: Ticket & Payment -->
                                <div v-if="currentStep === 3">
                                    <h5 class="mb-4">Ticket & Payment Details</h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Ticket Type <span
                                                    class="text-danger">*</span></label>
                                            <v-select v-model="selectedTicketType" :options="ticketTypes"
                                                label="category" placeholder="Select ticket type..."
                                                :reduce="t => t">
                                                <template #option="tt">
                                                    <div class="d-flex justify-content-between w-100">
                                                        <span>{{ tt.category }}</span>
                                                        <strong>{{ tt.currency }} {{ formatCurrency(tt.price)
                                                            }}</strong>
                                                    </div>
                                                </template>
                                                <template #selected-option="tt">
                                                    {{ tt.category }} - {{ tt.currency }} {{ formatCurrency(tt.price)
                                                    }}
                                                </template>
                                            </v-select>
                                            <div v-if="form.errors.event_ticket_id" class="text-danger small mt-1">
                                                {{ form.errors.event_ticket_id }}
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label fw-bold">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <input v-model.number="form.quantity" type="number" class="form-control"
                                                min="1" max="50"
                                                :class="{ 'is-invalid': form.errors.quantity }" />
                                            <div class="invalid-feedback">{{ form.errors.quantity }}</div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label fw-bold">Total Amount</label>
                                            <div class="form-control bg-light">
                                                {{ selectedTicketType?.currency || 'UGX' }} {{
                                                    formatCurrency(calculatedAmount) }}
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Payment Method</label>
                                            <v-select v-model="form.payment_method" :options="paymentMethods"
                                                label="label" :reduce="m => m.value"
                                                placeholder="Select payment method..." />
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Payment Reference</label>
                                            <input v-model="form.payment_reference" type="text" class="form-control"
                                                placeholder="Auto-generated or enter PesaPal ref"
                                                :class="{ 'is-invalid': form.errors.payment_reference }" />
                                            <small class="text-muted">Auto-generated. Override with real reference if
                                                available.</small>
                                            <div class="invalid-feedback">{{ form.errors.payment_reference }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- STEP 4: Review & Create -->
                                <div v-if="currentStep === 4">
                                    <h5 class="mb-4">Review & Confirm</h5>

                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light" style="width: 35%;">Event</th>
                                                    <td>{{ selectedEvent?.title || '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Event Date</th>
                                                    <td>
                                                        {{ selectedEvent ?
                                                            moment(selectedEvent.start_date).format("DD MMM YYYY") :
                                                            '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Customer Name</th>
                                                    <td>
                                                        {{ form.customer_name || '-' }}
                                                        <span v-if="!selectedUser"
                                                            class="badge bg-warning text-dark ms-2">New User</span>
                                                        <span v-else
                                                            class="badge bg-info text-dark ms-2">Existing User</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Email</th>
                                                    <td>{{ form.customer_email || '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Phone</th>
                                                    <td>{{ form.customer_phone || '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Ticket Type</th>
                                                    <td>{{ selectedTicketType?.category || '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Quantity</th>
                                                    <td>{{ form.quantity }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Total Amount</th>
                                                    <td class="fw-bold">
                                                        {{ selectedTicketType?.currency || 'UGX' }}
                                                        {{ formatCurrency(calculatedAmount) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Payment Method</th>
                                                    <td>{{
                                                        paymentMethods.find(m => m.value ===
                                                            form.payment_method)?.label || form.payment_method
                                                    }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Payment Reference</th>
                                                    <td class="font-monospace small">{{ form.payment_reference }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-grid mt-4">
                                        <button class="btn btn-success btn-lg" @click="submitForm"
                                            :disabled="form.processing">
                                            <i v-if="form.processing"
                                                class="bx bx-loader bx-spin me-2"></i>
                                            <i v-else class="bx bx-check-circle me-2"></i>
                                            Create {{ form.quantity }} Ticket(s)
                                        </button>
                                    </div>
                                </div>

                            </template>
                        </Stepper>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<style scoped>
.font-monospace {
    font-family: 'Courier New', monospace;
}

.list-group-item-action:hover {
    background-color: #f0f9ff;
}
</style>
