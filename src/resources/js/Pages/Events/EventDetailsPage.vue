<script setup>
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import PageHeader from "@/js/Components/page-header.vue";
import { reactive, onMounted, computed, ref } from "vue";
import IsUserBeneficiary from "../../Composables/IsUserBeneficiary.js";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import useInertiaFormSubmit from "../../Composables/useInertiaFormSubmit.js";
import RegisterForEvent from "../../Components/RegisterForEvent.vue";
import moment from "moment";
import Swal from "sweetalert2";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

const props = defineProps(["eventDetails"]);
const state = reactive({});


const registerForEventModal = ref(false);
const currentUser = computed(() => {
    const theUser = usePage().props.auth.user;
    return theUser;
});

const form = useForm({
    review: "",
    event_id: props.eventDetails.id,
    user_id: usePage().props.auth.user.id,
    submitted_by: usePage().props.auth.user.name,
});



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

function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}
function buyTicket() {
    router.visit(`/event/buy-ticket/${slugify(props.eventDetails.title)}/${props.eventDetails.id}`);
}
</script>
<template>
    <Head :title="props.eventDetails.title" />
    <DashboardLayout>
        <PageHeader :title="props.eventDetails.title" :items="state.items" />
        <div class="row">
            <div class="col-xl-3">
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
                            <button class="btn btn-soft-primary w-100" @click="buyTicket" v-if="props.eventDetails.access_type == 'paid'">
                                Buy Ticket
                            </button>
                            <button
                                class="btn btn-soft-primary w-100"
                                @click="registerForEventModal = true"
                                v-else="props.eventDetails.access_type == 'paid'"
                            >
                                Register
                            </button>

                            <button class="btn btn-soft-danger w-100" v-if="props.eventDetails.beneficiary_id == currentUser.id">Edit</button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img
                                :src="props.eventDetails.beneficiary.profile_photo_url"
                                :alt="'p'"
                                class="mx-auto rounded-circle header-profile-user object-fit-cover d-block"
                            />
                            <h5 class="mt-3 mb-1">{{ props.eventDetails.beneficiary.name }}</h5>
                        </div>

                        <ul class="mt-4 list-unstyled">
                            <li>
                                <div class="d-flex">
                                    <i class="bx bx-phone text-primary fs-4"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-2 fs-14">Phone</h6>
                                        <p class="mb-0 text-muted fs-14">{{ props.eventDetails.beneficiary.phone_number }}</p>
                                    </div>
                                </div>
                            </li>
                            <li class="mt-3">
                                <div class="d-flex">
                                    <i class="bx bx-mail-send text-primary fs-4"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-2 fs-14">Email</h6>
                                        <p class="mb-0 text-muted fs-14">{{ props.eventDetails.beneficiary.email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li class="mt-3">
                                <div class="d-flex">
                                    <i class="bx bx-globe text-primary fs-4"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-2 fs-14">Website</h6>
                                        <p class="mb-0 text-muted fs-14 text-break">www.frontrow.com</p>
                                    </div>
                                </div>
                            </li>
                            <li class="mt-3">
                                <div class="d-flex">
                                    <i class="bx bx-support text-primary fs-4"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-2 fs-14">Support</h6>
                                        <p class="mb-0 text-muted fs-14">support@frontrow.com</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-4" v-if="props.eventDetails.beneficiary_id == currentUser.id">
                            <a href="#!" class="rounded btn btn-soft-primary btn-hover w-100"><i class="mdi mdi-eye"></i> Tickets Sold</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-9">
                <div class="card">
                    <div
                        class="card-body border-bottom background-container"
                        :style="{ backgroundImage: `url(${props.eventDetails.banner_image_url})` }"
                    ></div>
                    <div class="card-body">
                        <div class="flex-row d-flex col-12 justify-content-between">
                            <div class="col-5">
                                <span class="badge badge-soft-primary me-3" v-for="(category, index) in props.eventDetails.categories" :key="index">{{
                                    category.name
                                }}</span>
                            </div>
                        </div>

                        <h5 class="mt-5 mb-3 fw-semibold">Description</h5>
                        <p class="text-muted" v-html="props.eventDetails.description"></p>

                        <h5 class="mt-5 mb-3 fw-semibold">Tickets</h5>
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
                        </div>

                        <b-button variant="primary" class="mt-4" @click="buyTicket" v-if="props.eventDetails.access_type == 'paid'"
                            >Buy Ticket
                        </b-button>
                        <b-button variant="primary" class="mt-4" @click="registerForEventModal = true" v-else>Register</b-button>

                        <div class="mt-5">
                            <h5 class="mb-4">Reviews :</h5>

                            <div
                                class="mt-3 d-flex border-bottom"
                                v-for="(review, index) in props.eventDetails.reviews"
                                :key="`${index}_${review.submitted_by}`"
                            >
                                <img
                                    :src="review.user.profile_photo_url"
                                    class="me-3 rounded-circle header-profile-user object-fit-cover"
                                    alt="img"
                                />
                                <div class="flex-grow-1">
                                    <h5 class="mt-0 font-size-15">{{ review.submitted_by }}</h5>
                                    <p class="text-muted">{{ review.review }}</p>
                                    <ul class="invisible list-inline float-sm-end">
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);"> <i class="far fa-thumbs-up me-1"></i> Like </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);"> <i class="far fa-comment-dots me-1"></i> Comment </a>
                                        </li>
                                    </ul>
                                    <div class="text-muted">
                                        <i class="far fa-calendar-alt text-primary me-1"></i> {{ moment(review.created_at).fromNow() }}
                                    </div>
                                </div>
                            </div>
                            <form>
                                <div class="gap-4 mt-5 mb-5 col-12 c d-flex align-items-end">
                                    <div class="col-10 col-md-8">
                                        <textarea
                                            class="form-control"
                                            id="commentmessage-input"
                                            placeholder="Your message..."
                                            rows="3"
                                            v-model="form.review"
                                        ></textarea>
                                    </div>
                                    <div>
                                        <button
                                            type="submit"
                                            class="btn btn-primary chat-send w-md"
                                            @click.prevent="submit"
                                            :disabled="form.processing"
                                        >
                                            <span class="d-none d-sm-inline-block me-2"
                                                ><i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="form.processing"></i
                                                ><span>Submit</span></span
                                            >
                                            <i class="mdi mdi-send"></i>
                                        </button>
                                    </div>

                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.review" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <RegisterForEvent
            :showModal="registerForEventModal"
            />
        </div>
    </DashboardLayout>
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
</style>
