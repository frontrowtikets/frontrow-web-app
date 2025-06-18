<script setup>
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import PageHeader from "@/js/Components/page-header.vue";
import { reactive, onMounted, computed, ref, watch } from "vue";
import IsUserAdmin from "../../Composables/IsUserAdmin.js";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import HomeHeader from "../../Components/HomeHeader.vue";
import FooterSection from "../../Components/FooterSection.vue";
import EventCheckout from "../../Components/EventCheckout.vue";
import { useWindowSize } from "@vueuse/core";
import YouTube from "vue3-youtube";

import moment from "moment";
import Swal from "sweetalert2";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

const props = defineProps(["eventDetails"]);
const state = reactive({
    items: [
        {
            text: "Back",
            // href: "javascript:void(0)"
        },
        {
            text: "Event",
            active: true,
        },
    ],
});

const { height, width } = useWindowSize();

const registerForEventModal = ref(false);
const buyTicketModal = ref(false);
const isPhoneNumberValid = ref(false);
const invalidPhoneNumberMsg = ref("");
const selectedTicket = ref(null);
const ticketQuantity = ref(1);
const showCheckout = ref(false);
const errorMessage = ref("");

const { isAdmin } = IsUserAdmin();

const currentUser = computed(() => {
    const theUser = usePage().props.auth.user;
    return theUser;
});

const selectedTickets = ref();
const ticketTotal = ref(0);

onMounted(() => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });

    selectedTickets.value = props.eventDetails.event_tickets.map((ticket) => {
        ticket.selectedQuantity = 0;
        return ticket;
    });
});

const cardSize = computed(() => {
    if (width.value > 768) {
        return 47;
    } else {
        return 100;
    }
});

watch(ticketQuantity, (newVal) => {
    if (newVal > selectedTicket.value.available_quantity) {
        ticketQuantity.value = 1;
    }
});

watch(
    selectedTickets,
    (newVal) => {
        let newTotal = 0;
        newVal.forEach((ticket) => {
            newTotal += Number(ticket.price * ticket.selectedQuantity);
        });
        ticketTotal.value = newTotal;
    },
    {
        deep: true,
    }
);

const theSetectedTickets = computed(() => {
    let filtered = [];
    if (selectedTickets.value) {
        filtered = selectedTickets.value.filter((ticket) => {
            return ticket.selectedQuantity > 0;
        });
    }

    return filtered;
});

const buttonText = computed(() => {
    if (props.eventDetails.access_type == "paid") {
        return "Buy Ticket";
    } else {
        if (props.eventDetails.reg_status == "pending") {
            return "Pending Approval";
        } else if (props.eventDetails.reg_status == "approved") {
            return "Get Ticket";
        } else {
            return "Register";
        }
    }
});

const form = useForm({
    review: "",
    event_id: props.eventDetails.id,
    user_id: usePage()?.props?.auth?.user?.id,
    submitted_by: usePage()?.props?.auth?.user?.name,
});

const eventRegisterForm = useForm({
    name: "",
    email: "",
    phone_number: "",
    terms: false,
    event_id: props.eventDetails.id,
});

function goback() {
    showCheckout.value = false;
    if (window.history.length > 1) {
        window.history.back();
    }
}

function goLogin() {
    router.visit("/login");
}

const submit = () => {
    form.post("/createeventreview", {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            router.reload();
        },
        onError: (err) => {
            const keysArray = Object.keys(err);
            Swal.fire({
                title: "Something Went Wrong",
                icon: "error",
                html: `<p style="font-size: 14px">${err[`${keysArray[0]}`]}</p>`,
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: true,
                confirmButtonText: "OK",
                confirmButtonColor: "#43ad60",
                allowOutsideClick: false,
                allowEscapeKey: false,
                closeOnClickOutside: false,
            }).then((result) => {
                if (result.value) {
                }
            });
        },
    });
};

function submitEventRegisterRequest() {
    if (
        eventRegisterForm["name"] != "" &&
        eventRegisterForm["email"] != "" &&
        eventRegisterForm["phone_number"] != "" &&
        eventRegisterForm["terms"] == true
    ) {
        errorMessage.value = "";

        eventRegisterForm.post(route("register_for_event"), {
            onFinish: () => {
                registerForEventModal.value = false;
                Swal.fire({
                    title: "Request Sent",
                    icon: "success",
                    html: `<p style="font-size: 14px">You have successfully submitted your request to attend the event</p>`,
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: true,
                    confirmButtonText: "OK",
                    confirmButtonColor: "#43ad60",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    closeOnClickOutside: false,
                }).then((result) => {
                    if (result.value) {
                        router.reload();
                    }
                });
            },
            onError: (err) => console.log(err),
        });
    } else {
        errorMessage.value = "All fields are required";
    }
}

function showEventRegModal() {
    eventRegisterForm["name"] = usePage().props.auth.user.name;
    eventRegisterForm["email"] = usePage().props.auth.user.email;
    registerForEventModal.value = true;
}

function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}
function buyTicket() {
    buyTicketModal.value = true;
}
function phoneNumber(val, phoneObj) {
    eventRegisterForm.phone_number = phoneObj["number"];
    isPhoneNumberValid.value = phoneObj.valid;
}
function checkValidity() {
    if (isPhoneNumberValid.value === false || typeof isPhoneNumberValid.value == "undefined") {
        invalidPhoneNumberMsg.value = "Phone Number is Invalid";
    } else {
        invalidPhoneNumberMsg.value = "";
    }
}

function checkoutMovie() {
    showCheckout.value = true;
}

function decreaseTicket(index) {
    if (selectedTickets.value[index].selectedQuantity !== 0) {
        selectedTickets.value[index].selectedQuantity -= 1;
    }
}

function increaseTicket(index) {
    selectedTickets.value[index].selectedQuantity += 1;
}

function getEventTicket() {
    router.visit("/mytickets");
}
</script>
<template>
    <section>
        <div v-scroll-spy>
            <b-container class="" style="margin-top: 16em">
                <HomeHeader />
                <PageHeader :title="props.eventDetails.title" :items="state.items" role="button" @click="goback" />

                <div v-if="showCheckout">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <EventCheckout :quantity="ticketQuantity" :selectedTickets="theSetectedTickets" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-else>
                    <!-- <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-semibold">Overview</h5>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="col">Start Date</th>
                                        <td scope="col">
                                            {{ moment(props.eventDetails.start_date).format("MMM Do YY") }} at {{ props.eventDetails.start_time }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">End Date</th>
                                        <td scope="col">
                                            {{ moment(props.eventDetails.end_date).format("MMM Do YY") }} at {{ props.eventDetails.start_time }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Type</th>
                                        <td>
                                            <span class="badge badge-soft-success" v-if="props.eventDetails.access_type == 'paid'">Paid Event</span>
                                            <span class="badge badge-soft-secondary" v-if="props.eventDetails.access_type == 'free'">Free Event</span>
                                            <span class="badge badge-soft-warning" v-if="props.eventDetails.access_type == 'invite-only'"
                                                >Invite Only</span
                                            >
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Location</th>
                                        <td>
                                            {{ props.eventDetails.location_name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="gap-2 hstack">
                            <div >
                                <button class="btn btn-soft-primary w-100" @click="buyTicket" v-if="props.eventDetails.access_type == 'paid'">
                                    Buy Ticket
                                </button>
                                <div v-else>
                                    <b-button variant="primary" class="mt-4" v-if="props.eventDetails.reg_status == 'pending'" disabled
                                        >Pending Approval</b-button
                                    >
                                    <b-button variant="primary" class="mt-4" v-else-if="props.eventDetails.reg_status == 'approved'"
                                        >Get Ticket</b-button
                                    >
                                    <button
                                        class="btn btn-soft-primary w-100"
                                        @click="showEventRegModal"
                                        v-else="props.eventDetails.access_type == 'paid'"
                                    >
                                        Register
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> -->
                    <!--end col-->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body border-bottom background-container"
                                :style="{ backgroundImage: `url(${props.eventDetails.banner_image_url})` }"></div>
                            <div class="card-body">
                                <div class="pt-4 flex-column justify-content-between d-flex flex-md-row col-12">
                                    <div class="mb-4 col-12 col-md-7 flex-column pe-md-5">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5 class="fw-semibold">Description</h5>
                                            </div>
                                            <div class="d-block d-md-none">
                                                <b-button variant="primary" href="#eventsdetailsfrom">{{ buttonText
                                                }}</b-button>
                                            </div>
                                        </div>
                                        <div class="flex-row mb-3 d-flex col-12 justify-content-between">
                                            <div class="col-5">
                                                <span class="badge badge-soft-primary me-3"
                                                    v-for="(category, index) in props.eventDetails.categories"
                                                    :key="index">{{ category.name }}</span>
                                            </div>
                                        </div>
                                        <p class="text-muted" v-html="props.eventDetails.description"></p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th scope="col">Start Date</th>
                                                        <td scope="col">
                                                            {{ moment(props.eventDetails.start_date).format("MMM Do YY")
                                                            }}
                                                            at
                                                            {{ props.eventDetails.start_time }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">End Date</th>
                                                        <td scope="col">
                                                            {{ moment(props.eventDetails.end_date).format("MMM Do YY")
                                                            }} at
                                                            {{ props.eventDetails.start_time }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Type</th>
                                                        <td>
                                                            <span class="badge badge-soft-success"
                                                                v-if="props.eventDetails.access_type == 'paid'">Paid
                                                                Event</span>
                                                            <span class="badge badge-soft-secondary"
                                                                v-if="props.eventDetails.access_type == 'free'">Free
                                                                Event</span>
                                                            <span class="badge badge-soft-warning"
                                                                v-if="props.eventDetails.access_type == 'invite-only'">Invite
                                                                Only</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Location</th>
                                                        <td>
                                                            {{ props.eventDetails.location_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Organized By</th>
                                                        <td>
                                                            {{ props.eventDetails.beneficiary.name }} ({{
                                                                props.eventDetails.beneficiary.phone_number }})
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div v-if="width > 768">
                                            <div class="mt-4 mb-3" v-if="props.eventDetails.trailer_url">
                                                <h5 class="mb-3 fw-semibold">Trailer:</h5>
                                                <YouTube :src="`${props.eventDetails.trailer_url}`" @ready="onReady"
                                                    ref="youtube" :width="390" :height="300" />
                                            </div>
                                        </div>
                                        <div v-else>
                                            <div class="mt-4 mb-3" v-if="props.eventDetails.trailer_url">
                                                <h5 class="mb-3 fw-semibold">Trailer:</h5>
                                                <YouTube :width="300" :height="180"
                                                    :src="`${props.eventDetails.trailer_url}`" @ready="onReady"
                                                    ref="youtube" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5" id="eventsdetailsfrom">
                                        <div>
                                            <!-- <b-button variant="primary" class="mt-4" @click="buyTicket"
                                            >Buy Ticket
                                        </b-button> -->

                                            <div v-if="props.eventDetails.access_type == 'paid'" class="mt-2 col-12">
                                                <h5>Available Tickets</h5>
                                                <div class="flex-wrap gap-3 mt-4 col-12 d-flex">
                                                    <div :style="{ width: cardSize + '%' }"
                                                        v-for="(field, index) in selectedTickets" :key="field.id">
                                                        <div class="text-center shadow-lg dotted-border card">
                                                            <div class="card-body">
                                                                <h5 class="font-size-15">
                                                                    <a href="javascript: void(0);" class="text-dark">
                                                                        <!-- ({{ field.available_quantity }}) -->
                                                                        {{ field.category }}
                                                                    </a>
                                                                </h5>
                                                                <p class="text-muted">{{ field.currency }}: {{
                                                                    useCurrencyFormat(field.price) }}</p>
                                                            </div>
                                                            <div class="bg-transparent card-footer border-top">
                                                                <div class="contact-links d-flex font-size-20">
                                                                    <div class="flex-fill pe-3"
                                                                        @click="decreaseTicket(index)">
                                                                        <a v-b-tooltip.hover.top title="Reduce Tickets"
                                                                            href="javascript: void(0);">
                                                                            <i class="bx bx-minus"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="flex-fill">
                                                                        <input style="font-size: 13px" type="number"
                                                                            class="form-control" :min="0" required
                                                                            v-model="field.selectedQuantity" />
                                                                    </div>
                                                                    <div class="flex-fill ps-3"
                                                                        @click="increaseTicket(index)">
                                                                        <a v-b-tooltip.hover.top title="Add Tickets"
                                                                            href="javascript: void(0);">
                                                                            <i class="bx bx-plus"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    class="pt-2 pb-2 mt-4 rounded ps-1 pe-1 w-100 d-flex justify-content-between align-items-center bg-light">
                                                    <div style="font-size: normal">Sub Total({{
                                                        props.eventDetails.event_tickets[0].currency }}):</div>
                                                    <div style="font-size: medium" class="fw-bold">{{
                                                        useCurrencyFormat(ticketTotal) }}</div>
                                                </div>
                                                <div class="mt-4 col-12">
                                                    <b-button variant="primary" class="col-12"
                                                        @click.prevent="checkoutMovie"
                                                        :disabled="theSetectedTickets.length === 0">Book Now</b-button>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div v-if="props.eventDetails.reg_status == 'pending'"
                                                    class="mt-4 mb-4 alert alert-danger fade show" role="alert">
                                                    Request Pending Approval
                                                </div>
                                                <b-button variant="primary" class="mt-4"
                                                    v-else-if="props.eventDetails.reg_status == 'approved'"
                                                    @click="getEventTicket">Get Ticket</b-button>
                                                <div v-else>
                                                    <h5 class="mb-3 fw-semibold">Register For Event</h5>

                                                    <form>
                                                        <div v-if="eventRegisterForm.errors.email"
                                                            class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                                                            role="alert">
                                                            {{ eventRegisterForm.errors.email }}
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                        <div v-if="errorMessage"
                                                            class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                                                            role="alert">
                                                            {{ errorMessage }}
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>

                                                        <div v-if="eventRegisterForm.errors.phone_number"
                                                            class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                                                            role="alert">
                                                            {{ eventRegisterForm.errors.phone_number }}
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                        <div v-if="eventRegisterForm.errors.terms"
                                                            class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                                                            role="alert">
                                                            {{ eventRegisterForm.errors.terms }}
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                        <div v-if="invalidPhoneNumberMsg"
                                                            class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                                                            role="alert">
                                                            {{ invalidPhoneNumberMsg }}
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="name">Name</label>
                                                            <input style="font-size: 13px" type="text"
                                                                class="form-control" id="name" placeholder="Name"
                                                                required v-model="eventRegisterForm.name" />
                                                            <InputError class="mt-2 mb-4 text-danger"
                                                                :message="eventRegisterForm.errors.name" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="email"> Email Address</label>
                                                            <input style="font-size: 13px" type="email"
                                                                class="form-control" id="email" required
                                                                autocomplete="username" placeholder="Enter email"
                                                                v-model="eventRegisterForm.email" />
                                                            <InputError class="mt-2 mb-4 text-danger"
                                                                :message="eventRegisterForm.errors.email" />
                                                        </div>

                                                        <div class="mb-4">
                                                            <label for="phone_number"> Phone Number</label>
                                                            <VueTelInput class="form-control"
                                                                inputOptions.required="true"
                                                                inputOptions.showDialCode="true" :rules="[isValidPhone]"
                                                                v-model="eventRegisterForm.phone_number"
                                                                @input="phoneNumber" @change="phoneNumber"
                                                                @blur="checkValidity" />
                                                            <small class="text-danger" v-if="invalidPhoneNumberMsg">{{
                                                                invalidPhoneNumberMsg }}</small>
                                                        </div>

                                                        <div class="">
                                                            <div class="mb-3 form-check form-check-left">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="formCheckRight1"
                                                                    v-model="eventRegisterForm.terms" />
                                                                <label class="form-check-label" for="formCheckRight1">
                                                                    Allow
                                                                    Terms & Conditions </label>
                                                                <InputError class="mt-2 mb-4 text-danger"
                                                                    :message="eventRegisterForm.errors.terms" />
                                                            </div>
                                                        </div>

                                                        <div class="mt-5 d-grid">
                                                            <button
                                                                class="btn btn-primary btn-block waves-effect waves-light"
                                                                type="submit"
                                                                @click.prevent="submitEventRegisterRequest"
                                                                :disabled="eventRegisterForm.processing">
                                                                <i class="align-middle bx bx-loader bx-spin font-size-16 me-2"
                                                                    v-if="eventRegisterForm.processing"></i><span>Register</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <h5 class="mt-5 mb-3 fw-semibold">Tickets</h5>
                            <div class="col-12 d-flex">
                                <div class="mb-3 col-lg-4">
                                    <label for="theatre">Category</label>
                                </div>

                                <div class="mb-3 text-center col-lg-2">
                                    <label for="screening_date">Remaining Tickets</label>
                                </div>

                                <div class="mb-3 col-lg-2 text-end">
                                    <label for="resume">Ticket Price</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div v-for="(field, index) in props.eventDetails.event_tickets" :key="field.id" class="mb-3 w-100 row">
                                    <div class="mb-3 col-lg-4">
                                        {{ field.category }}
                                    </div>

                                    <div class="mb-3 text-center col-lg-2">
                                        {{ field.available_quantity }}
                                    </div>

                                    <div class="mb-3 ms-4 text-end col-lg-2">{{ field.currency }}: {{ useCurrencyFormat(field.price) }}</div>
                                </div>
                            </div> -->

                                <div class="mt-5">
                                    <h5 class="pt-4">Reviews :</h5>

                                    <div class="mt-3 d-flex border-bottom"
                                        v-for="(review, index) in props.eventDetails.reviews"
                                        :key="`${index}_${review.submitted_by}`">
                                        <img :src="review.user.profile_photo_url"
                                            class="me-3 rounded-circle header-profile-user object-fit-cover"
                                            alt="img" />
                                        <div class="flex-grow-1">
                                            <h5 class="mt-0 font-size-15">{{ review.submitted_by }}</h5>
                                            <p class="text-muted">{{ review.review }}</p>
                                            <ul class="invisible list-inline float-sm-end">
                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);"> <i
                                                            class="far fa-thumbs-up me-1"></i>
                                                        Like </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);"> <i
                                                            class="far fa-comment-dots me-1"></i>
                                                        Comment </a>
                                                </li>
                                            </ul>
                                            <div class="text-muted">
                                                <i class="far fa-calendar-alt text-primary me-1"></i> {{
                                                    moment(review.created_at).fromNow() }}
                                            </div>
                                        </div>
                                    </div>
                                    <form v-if="usePage().props.auth.user">
                                        <div class="gap-4 mt-5 mb-5 col-12 c d-flex align-items-end">
                                            <div class="col-10 col-md-8">
                                                <textarea class="form-control" id="commentmessage-input"
                                                    placeholder="Your message..." rows="3"
                                                    v-model="form.review"></textarea>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary chat-send w-md"
                                                    @click.prevent="submit" :disabled="form.processing">
                                                    <span class="d-none d-sm-inline-block me-2"><i
                                                            class="align-middle bx bx-loader bx-spin font-size-16 me-2"
                                                            v-if="form.processing"></i><span>Submit</span></span>
                                                    <i class="mdi mdi-send"></i>
                                                </button>
                                            </div>

                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.review" />
                                        </div>
                                    </form>
                                    <div v-else class="mt-3 mb-3 text-center text-muted">
                                        <div><span class="text-primary" role="button" @click="goLogin">Sign in</span> to
                                            sumbmit a review</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <b-modal v-model="buyTicketModal" id="buyEventTicket" centered title="Buy Event Ticket" title-class="font-18" hide-footer>
                        <div>
                            <div class="mb-4"><span>Availbale</span>({{ selectedTicket?.available_quantity }})</div>
                            <div class="mb-3">
                                <label>Ticket Type</label>
                                <v-select v-model="selectedTicket" :options="props.eventDetails.event_tickets" :label="'category'"></v-select>
                            </div>
                            <div class="mb-4">
                                <label>Quantity</label>
                                <input
                                    class="form-control"
                                    type="number"
                                    id="formCheckRight1"
                                    v-model="ticketQuantity"
                                    :disabled="selectedTicket === null"
                                    :min="1"
                                    :max="selectedTicket?.available_quantity"
                                />
                            </div>
                            <div class="text-end">
                                <div class="mb-2 fw-bold me-3">Total</div>
                                <div>
                                    <h4>{{ selectedTicket?.currency || "UGX" }} {{ useCurrencyFormat(ticketTotal) }}</h4>
                                </div>
                            </div>
                            <div class="mt-5 d-grid">
                                <button
                                    class="btn btn-primary btn-block waves-effect waves-light"
                                    @click.prevent="checkoutMovie"
                                    :disabled="selectedTicket === null"
                                >
                                    <span>Proceed</span>
                                </button>
                            </div>
                        </div>
                    </b-modal> -->
                    </div>
                </div>
            </b-container>
            <div class="mt-5">
                <FooterSection />
            </div>
        </div>
    </section>
</template>
<style scoped>
.background-container {
    width: 100%;
    height: 300px;
    background-color: grey;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}

.dotted-border {
    border: 1px dotted #d3d3d3;
    padding: 10px;
    border-radius: 4px;
}
</style>
