<script setup>
import PageHeader from "@/js/Components/page-header.vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import { reactive, onMounted, computed, ref } from "vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import Swal from "sweetalert2";
import icondata from "@/images/icondata.png";
import useInertiaFormSubmit from "@/js/Composables/useInertiaFormSubmit.js";

const props = defineProps({
    attendanceList: {
        type: Object,
        required: true,
    },
    attendanceRequests: {
        type: Object,
        required: true,
    },
    declinedRequests: {
        type: Object,
        required: true,
    },
    event_id: {
        required: true,
    },
    event_type: {
        required: true,
    },
    event_title: {
        required: true,
    },
});

const state = reactive({
    items: [
        {
            text: "Events",
            // href: "javascript:void(0)"
        },
        {
            text: "Manage Event",
            active: true,
        },
    ],
});
const eventRegisterForm = useForm({
    name: "",
    email: "",
    phone_number: "",
    terms: false,
    event_id: props.event_id,
});

const attendenceListBottom = ref(null);
const attendenceRequestsListBottom = ref(null);
const attendenceDeclinedListBottom = ref(null);
const registerForEventModal = ref(false);

const { paginatedItems, nextPageExists } = useInfiniteScroll("attendanceList", attendenceListBottom);
const { paginatedItems: requestspaginatedItems, nextPageExists: requestsPageExists } = useInfiniteScroll(
    "attendanceRequests",
    attendenceRequestsListBottom
);
const { paginatedItems: declinedpaginatedItems, nextPageExists: declinedPageExists } = useInfiniteScroll(
    "declinedRequests",
    attendenceDeclinedListBottom
);

function submitEventRegisterRequest() {
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
}
function showEventRegModal() {
    registerForEventModal.value = true;
}

function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}

function acceptRequest(userID) {
    useInertiaFormSubmit(
        {
            attendace_id: userID,
        },
        "/event/acceptinvitation",
        "reload",
        "You are about to accept this invitation",
        "Invitation accepted successfully"
    );
    router.reload();
}
function declineRequest(userID) {
    useInertiaFormSubmit(
        {
            attendace_id: userID,
        },
        "/event/declineinvitation",
        "reload",
        "You are about about to decline this invitation",
        "Invitation declined successfully"
    );
    router.reload();
}
</script>
<template>
    <Head title="Manage Event" />
    <DashboardLayout>
        <PageHeader title="Manage Event" :items="state.items" />
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 d-flex justify-content-end" v-if="props.event_type != 'paid'">
                        <div><b-button variant="primary" class="" @click="showEventRegModal">Register Attendee</b-button></div>
                    </div>
                    <b-tabs>
                        <b-tab title="Tickets Sold" active>
                            <div class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                <div>No tickets yet.</div>
                            </div>
                        </b-tab>
                        <b-tab title="Attendance List" v-if="props.event_type != 'paid'">
                            <div class="mt-5 table-responsive" v-if="paginatedItems.length > 0">
                                <table class="table align-middle table-nowrap table-striped dt-responsive nowrap w-100 table-container">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone Number</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(user, index) in paginatedItems" :key="`${index}_${user.email}`">
                                            <th scope="row" :style="{ backgroundColor: '#fff' }">
                                                <div v-if="user.user != null">
                                                    <img
                                                        :src="user.user.profile_photo_url"
                                                        :alt="''"
                                                        class="rounded-circle avatar-xs object-fit-cover"
                                                    />
                                                </div>
                                            </th>
                                            <td :style="{ backgroundColor: '#fff' }">{{ user.user.name }}</td>
                                            <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.email }}</td>
                                            <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.user.phone_number }}</td>

                                            <td :style="{ backgroundColor: '#fff' }" class="text-center">
                                                <div v-if="user.reg_status == 'approved'">
                                                    <span class="badge text-bg-success">Approved</span>
                                                </div>
                                                <div v-if="user.reg_status == 'pending'">
                                                    <span class="badge text-bg-warning">Pending Approval</span>
                                                </div>
                                                <div v-if="user.reg_status == 'declined'">
                                                    <span class="badge text-bg-danger">Declined</span>
                                                </div>
                                            </td>

                                            <td :style="{ backgroundColor: '#fff' }" class="text-end">
                                                <div class="d-flex justify-content-end">
                                                    <div class="gap-1 mb-0 list-unstyled hstack">
                                                        <div
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            aria-label="View"
                                                            @click="declineRequest(user.id)"
                                                        >
                                                            <div class="btn btn-sm btn-soft-danger"><i class="dripicons-cross"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div ref="usersTableBottom"></div>
                                <div v-if="nextPageExists" class="mt-4 text-center text-success">
                                    <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                </div>
                                <div v-else class="mt-4 text-center text-primary">No More Data</div>
                            </div>
                            <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                <div>No attendance yet.</div>
                            </div>
                        </b-tab>
                        <b-tab title="Attendance Requests" v-if="props.event_type != 'paid'">
                            <div class="mt-5 table-responsive" v-if="requestspaginatedItems.length > 0">
                                <table class="table align-middle table-nowrap table-striped dt-responsive nowrap w-100 table-container">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone Number</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(user, index) in requestspaginatedItems" :key="`${index}_${user.email}`">
                                            <th scope="row" :style="{ backgroundColor: '#fff' }">
                                                <div v-if="user.user != null">
                                                    <img
                                                        :src="user.user.profile_photo_url"
                                                        :alt="''"
                                                        class="rounded-circle avatar-xs object-fit-cover"
                                                    />
                                                </div>
                                            </th>
                                            <td :style="{ backgroundColor: '#fff' }">{{ user.user.name }}</td>
                                            <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.email }}</td>
                                            <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.user.phone_number }}</td>

                                            <td :style="{ backgroundColor: '#fff' }" class="text-center">
                                                <div v-if="user.reg_status == 'approved'">
                                                    <span class="badge text-bg-success">Approved</span>
                                                </div>
                                                <div v-if="user.reg_status == 'pending'">
                                                    <span class="badge text-bg-warning">Pending Approval</span>
                                                </div>
                                                <div v-if="user.reg_status == 'declined'">
                                                    <span class="badge text-bg-danger">Declined</span>
                                                </div>
                                            </td>

                                            <td :style="{ backgroundColor: '#fff' }" class="text-end">
                                                <div class="d-flex justify-content-end">
                                                    <div class="gap-1 mb-0 list-unstyled hstack">
                                                        <div
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            aria-label="View"
                                                            @click="acceptRequest(user.id)"
                                                        >
                                                            <div class="btn btn-sm btn-soft-success"><i class="bx bx-check-square"></i></div>
                                                        </div>
                                                        <div
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            aria-label="View"
                                                            @click="declineRequest(user.id)"
                                                        >
                                                            <div class="btn btn-sm btn-soft-danger"><i class="dripicons-cross"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div ref="usersTableBottom"></div>
                                <div v-if="requestsPageExists" class="mt-4 text-center text-success">
                                    <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                </div>
                                <div v-else class="mt-4 text-center text-primary">No More Data</div>
                            </div>
                            <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                <div>No attendance requests yet.</div>
                            </div>
                        </b-tab>
                        <b-tab title="Declined" v-if="props.event_type != 'paid'">
                            <div class="mt-5 table-responsive" v-if="declinedpaginatedItems.length > 0">
                                <table class="table align-middle table-nowrap table-striped dt-responsive nowrap w-100 table-container">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Phone Number</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(user, index) in declinedpaginatedItems" :key="`${index}_${user.email}`">
                                            <th scope="row" :style="{ backgroundColor: '#fff' }">
                                                <div v-if="user.user != null">
                                                    <img
                                                        :src="user.user.profile_photo_url"
                                                        :alt="''"
                                                        class="rounded-circle avatar-xs object-fit-cover"
                                                    />
                                                </div>
                                            </th>
                                            <td :style="{ backgroundColor: '#fff' }">{{ user.user.name }}</td>
                                            <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.email }}</td>
                                            <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.user.phone_number }}</td>
                                            <td :style="{ backgroundColor: '#fff' }" class="text-center">
                                                <div v-if="user.reg_status == 'approved'">
                                                    <span class="badge text-bg-success">Approved</span>
                                                </div>
                                                <div v-if="user.reg_status == 'pending'">
                                                    <span class="badge text-bg-warning">Pending Approval</span>
                                                </div>
                                                <div v-if="user.reg_status == 'declined'">
                                                    <span class="badge text-bg-danger">Declined</span>
                                                </div>
                                            </td>

                                            <td :style="{ backgroundColor: '#fff' }" class="text-end">
                                                <div class="d-flex justify-content-end">
                                                    <div class="gap-1 mb-0 list-unstyled hstack">
                                                        <div
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            aria-label="View"
                                                            @click="acceptRequest(user.id)"
                                                        >
                                                            <div class="btn btn-sm btn-soft-success"><i class="bx bx-check-square"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                 <div ref="usersTableBottom"></div>
                                <div v-if="declinedPageExists" class="mt-4 text-center text-success">
                                    <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                </div>
                                <div v-else class="mt-4 text-center text-primary">No More Data</div>
                            </div>
                            <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                <div>No attendance yet.</div>
                            </div>
                        </b-tab>
                    </b-tabs>
                    <b-modal v-model="registerForEventModal" id="EventRegister" centered title="Register For Event" title-class="font-18" hide-footer>
                        <div>
                            <form>
                                <div
                                    v-if="eventRegisterForm.errors.email"
                                    class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                                    role="alert"
                                >
                                    {{ eventRegisterForm.errors.email }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div
                                    v-if="eventRegisterForm.errors.phone_number"
                                    class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                                    role="alert"
                                >
                                    {{ eventRegisterForm.errors.phone_number }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div
                                    v-if="eventRegisterForm.errors.terms"
                                    class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                                    role="alert"
                                >
                                    {{ eventRegisterForm.errors.terms }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div v-if="invalidPhoneNumberMsg" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ invalidPhoneNumberMsg }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input
                                        style="font-size: 13px"
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        placeholder="Name"
                                        required
                                        v-model="eventRegisterForm.name"
                                    />
                                    <InputError class="mt-2 mb-4 text-danger" :message="eventRegisterForm.errors.name" />
                                </div>

                                <div class="mb-3">
                                    <label for="email"> Email Address</label>
                                    <input
                                        style="font-size: 13px"
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        required
                                        autocomplete="username"
                                        placeholder="Enter email"
                                        v-model="eventRegisterForm.email"
                                    />
                                    <InputError class="mt-2 mb-4 text-danger" :message="eventRegisterForm.errors.email" />
                                </div>

                                <div class="mb-4">
                                    <label for="phone_number"> Phone Number</label>
                                    <VueTelInput
                                        class="form-control"
                                        :inputOptions.required="true"
                                        :inputOptions.showDialCode="true"
                                        :rules="[isValidPhone]"
                                        v-model="eventRegisterForm.phone_number"
                                        @input="phoneNumber"
                                        @change="phoneNumber"
                                        @blur="checkValidity"
                                    />
                                    <small class="text-danger" v-if="invalidPhoneNumberMsg">{{ invalidPhoneNumberMsg }}</small>
                                </div>

                                <div class="">
                                    <div class="mb-3 form-check form-check-left">
                                        <input class="form-check-input" type="checkbox" id="formCheckRight1" v-model="eventRegisterForm.terms" />
                                        <label class="form-check-label" for="formCheckRight1"> Allow Terms & Conditions </label>
                                        <InputError class="mt-2 mb-4 text-danger" :message="eventRegisterForm.errors.terms" />
                                    </div>
                                </div>

                                <div class="mt-5 d-grid">
                                    <button
                                        class="btn btn-primary btn-block waves-effect waves-light"
                                        type="submit"
                                        @click.prevent="submitEventRegisterRequest"
                                        :disabled="eventRegisterForm.processing"
                                    >
                                        <i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="eventRegisterForm.processing"></i
                                        ><span>Register</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </b-modal>
                </div>
            </div>
        </div></DashboardLayout
    >
</template>
