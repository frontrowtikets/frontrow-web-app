<script setup>
import { Head, usePage, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import PageHeader from "@/js/Components/page-header.vue";
import { reactive, onMounted, computed, ref, watch } from "vue";
import icondata from "@/images/icondata.png";
import IsUserBeneficiary from "../../Composables/IsUserBeneficiary.js";
import IsUserAdmin from "../../Composables/IsUserAdmin.js";
import useRequestBeneficiaryStatus from "../../Composables/useRequestBeneficiaryStatus.js";
import useScheduleMoviesPage from "../../Composables/useScheduleMoviesPage.js";
import useScheduleEventsPage from "../../Composables/useScheduleEventsPage";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import { useWindowSize } from "@vueuse/core";
import apexchart from "vue3-apexcharts";


const props = defineProps([
    "eventsChart",
    "moviesChart",
    "transactionsChart",
    "events",
    "movies",
    "allTransactions",
    "successTransactions",
    "failedTransactions",
    "myWallet"
]);
// onMounted(()=>{
//     if(usePage().props.auth.user.user_type === 'ticket_buyer'){
//     router.visit("/mytickets");
//     }
// })
const { height, width } = useWindowSize();

const state = reactive({});
const { isBeneficiary } = IsUserBeneficiary();
const { isAdmin } = IsUserAdmin();
const currentUser = computed(() => {
    const theUser = usePage().props.auth.user;
    return theUser;
});

const eventsChartOptions = ref({
    chart: {
        id: "eventsChat",
        toolbar: {
            show: false,
        },
    },

    xaxis: {
        categories: [],
        labels: {
            show: false,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        labels: {
            show: false,
        },
    },
    grid: {
        show: false,
    },
    colors: ["#0198A1"],
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [0, 100],
        },
    },
    dataLabels: {
        enabled: false,
        enabledOnSeries: undefined,
    },
});

const eventSeries = ref([
    {
        name: "Events",
        data: [],
    },
]);

const moviesChartOptions = ref({
    chart: {
        id: "moviesChat",
        toolbar: {
            show: false,
        },
    },

    xaxis: {
        categories: [1991, 1992, 1993, 1994, 1995, 1996],
        labels: {
            show: false,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        labels: {
            show: false,
        },
    },
    grid: {
        show: false,
    },
    colors: ["#0198A1"],
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [0, 100],
        },
    },
    dataLabels: {
        enabled: false,
        enabledOnSeries: undefined,
    },
});

const movieseries = ref([
    {
        name: "Moviesovies",
        data: [30, 40, 35, 50, 20, 30],
    },
]);

const transactionsChartOptions = ref({
    chart: {
        id: "transactionsChat",
        toolbar: {
            show: false,
        },
    },

    xaxis: {
        categories: [1991, 1992, 1993, 1994, 1995, 1996],
        labels: {
            show: false,
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        labels: {
            show: false,
        },
    },
    grid: {
        show: false,
    },
    colors: ["#0198A1"],
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [0, 100],
        },
    },
    dataLabels: {
        enabled: false,
        enabledOnSeries: undefined,
    },
});
const transactionsSeries = ref([
    {
        name: "Transactions",
        data: [0, 0, 0, 0, 0, 0],
    },
]);

watch(
    props.eventsChart,
    (newVal) => {
        const chartData = newVal;
        const months = [];
        const monthsRecords = [];
        chartData.map((eventData) => {
            months.push(eventData.month);
        });
        chartData.map((eventData) => {
            monthsRecords.push(eventData.records);
        });
        eventsChartOptions.value.xaxis.categories = months;
        eventSeries.value[0].data = monthsRecords;
    },
    {
        immediate: true,
    }
);

watch(
    props.moviesChart,
    (newVal) => {
        const chartData = newVal;
        const months = [];
        const monthsRecords = [];
        chartData.map((eventData) => {
            months.push(eventData.month);
        });
        chartData.map((eventData) => {
            monthsRecords.push(eventData.records);
        });
        moviesChartOptions.value.xaxis.categories = months;
        movieseries.value[0].data = monthsRecords;
    },
    {
        immediate: true,
    }
);

watch(
    props.transactionsChart,
    (newVal) => {
        const chartData = newVal;
        const months = [];
        const monthsRecords = [];
        chartData.map((eventData) => {
            months.push(eventData.month);
        });
        chartData.map((eventData) => {
            monthsRecords.push(eventData.records);
        });
        transactionsChartOptions.value.xaxis.categories = months;
        transactionsSeries.value[0].data = monthsRecords;
    },
    {
        immediate: true,
    }
);

function myWallet() {
    router.visit("/mywallet");
}
function allEvents() {
    router.visit("/allevents");
}
function allMovies() {
    router.visit("/allmovies");
}
function myTransaction() {
    router.visit("/mytransactions")
}
function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}

function viewMovie(movie) {
    router.visit(`/movie/${slugify(movie.title)}/${movie.id}`);
}
function viewEvent(event) {
    router.visit(`/event/${slugify(event.title)}/${event.id}`);
}
function goToTicketScanner() {
    router.visit("/ticket-scanner");
}
</script>
<template>

    <DashboardLayout>

        <Head title="Dashboard" />

        <PageHeader title="Dashboard" :items="state.items" />
        <div class="row">
            <div class="col-xl-4 d-flex align-items-stretch" Style="">
                <div class="card w-100">
                    <div class="card-body">
                        <div>
                            <div>
                                <!-- <img class="rounded-circle header-profile-user" :src="avatar1" alt="Header Avatar" /> -->
                                <img :src="usePage().props.auth.user.profile_photo_url" :alt="'p'"
                                    class="rounded-circle header-profile-user object-fit-cover" />
                            </div>

                            <div class="mt-2">
                                <h5>{{ usePage().props.auth.user.name }}</h5>
                                <p class="mb-1 text-muted">
                                    {{ usePage().props.auth.user.email }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border-top">
                        <div class="row">
                            <div class="col-12 text-end">
                                <div>
                                    <p class="mb-2 fw-medium">Wallet Balance :</p>
                                    <h4>UGX {{ props.myWallet ? useCurrencyFormat(props.myWallet.balance) : "0.00" }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-transparent card-footer border-top">
                        <div class="text-center">
                            <a @click="myWallet" class="btn btn-primary me-2 w-md">My Wallet</a>
                            <!-- <a href="#" class="btn btn-primary me-2 w-md">Deposit</a> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div>
                        <div class="row">
                            <div class="col-lg-9 col-sm-8">
                                <div class="p-4">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>FRONTROW Application Platform</p>

                                    <div class="text-muted">
                                        <p class="mb-1">
                                            <i class="align-middle mdi mdi-circle-medium text-primary me-1"></i>
                                            Book Tickets
                                        </p>
                                        <p class="mb-1">
                                            <i class="align-middle mdi mdi-circle-medium text-primary me-1"></i>
                                            Load wallet & make transactions.
                                        </p>
                                        <p class="mb-0">
                                            <i class="align-middle mdi mdi-circle-medium text-primary me-1"></i>
                                            Create Events & Manage Clients.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-4 align-self-center">
                                <div>
                                    <img src="@/images/profile-img.png" alt class="img-fluid d-block" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-muted">{{ isAdmin ? "Events" : "My Events" }}</div>

                                <div class="">
                                    <apexchart height="90%" width="100%" type="area" :options="eventsChartOptions"
                                        :series="eventSeries"></apexchart>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-muted">{{ isAdmin ? "Movies" : "My Movies" }}</div>

                                <div class="">
                                    <apexchart height="90%" width="100%" type="area" :options="moviesChartOptions"
                                        :series="movieseries"></apexchart>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-muted">{{ isAdmin ? "Transactions" : "My Transactions" }}</div>

                                <div class="">
                                    <apexchart height="90%" width="100%" type="area" :options="transactionsChartOptions"
                                        :series="transactionsSeries"></apexchart>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <!-- Admin Quick Actions -->
        <div v-if="isAdmin" class="row mb-3">
            <div class="col-md-4 col-sm-6">
                <div class="card" style="border-left: 4px solid #0198A1;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: #e6f7f8; flex-shrink: 0;">
                            <i class="bx bx-barcode font-size-24" style="color: #0198A1;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Verify Tickets</h6>
                            <p class="text-muted mb-0" style="font-size: 0.8rem;">Scan & verify event tickets</p>
                        </div>
                        <b-button variant="primary" size="sm" @click="goToTicketScanner">
                            Open Scanner
                        </b-button>
                    </div>
                </div>
            </div>
        </div>

        <div class="" :class="[width < 1440 ? 'col' : 'row']">
            <div class=" d-flex align-items-stretch" :class="[width < 1440 ? 'col-12' : 'col-4']">
                <div class="card w-100">
                    <div class="card-body w-100">
                        <h4 class="mb-4 card-title">{{ isAdmin ? "Transactions" : "My Transactions" }}</h4>
                        <b-tabs pills nav-class="rounded bg-light" content-class="mt-4">
                            <b-tab title="All" active>
                                <b-card-text class="mt-5">
                                    <table v-if="props.allTransactions.length > 0"
                                        class="table align-middle table-centered table-nowrap">
                                        <tbody>
                                            <tr v-for="data of props.allTransactions" :key="data.id">
                                                <td>
                                                    <div>
                                                        <h5 class="mb-1 font-size-14">{{ data.user.name }}</h5>
                                                        <p class="mb-0 text-muted">{{ data.currency }} {{
                                                            useCurrencyFormat(data.amount) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end">
                                                        <span v-if="(data.txn_status = 'pending')"
                                                            class="badge badge-soft-warning font-size-11">Pending</span>
                                                        <span v-else-if="(data.txn_status = 'paid')"
                                                            class="badge badge-soft-success font-size-11">Successful</span>
                                                        <span v-else-if="(data.txn_status = 'successful')"
                                                            class="badge badge-soft-success font-size-11">Successful</span>
                                                        <span v-else-if="(data.txn_status = 'failed')"
                                                            class="badge badge-soft-danger font-size-11">Failed</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div v-else class="d-flex flex-column align-items-center"
                                        style="padding-top: 9vh; padding-bottom: 30vh">
                                        <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                        <div>No Transactions Yet.</div>
                                    </div>
                                </b-card-text>
                            </b-tab>

                            <b-tab title="Successful">
                                <b-card-text class="mt-5">
                                    <table v-if="props.successTransactions.length > 0"
                                        class="table align-middle table-centered table-nowrap">
                                        <tbody>
                                            <tr v-for="data of props.successTransactions" :key="data.id">
                                                <td>
                                                    <div>
                                                        <h5 class="mb-1 font-size-14">{{ data.user.name }}</h5>
                                                        <p class="mb-0 text-muted">{{ data.currency }} {{
                                                            useCurrencyFormat(data.amount) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end">
                                                        <span v-if="(data.txn_status = 'pending')"
                                                            class="badge badge-soft-warning font-size-11">Pending</span>
                                                        <span v-else-if="(data.txn_status = 'paid')"
                                                            class="badge badge-soft-success font-size-11">Paid</span>
                                                        <span v-else-if="(data.txn_status = 'failed')"
                                                            class="badge badge-soft-danger font-size-11">Failed</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-else class="d-flex flex-column align-items-center"
                                        style="padding-top: 9vh; padding-bottom: 30vh">
                                        <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                        <div>No Transactions Yet.</div>
                                    </div>
                                </b-card-text>
                            </b-tab>
                            <b-tab title="Failed">
                                <b-card-text class="mt-5">
                                    <table v-if="props.failedTransactions.length > 0"
                                        class="table align-middle table-centered table-nowrap">
                                        <tbody>
                                            <tr v-for="data of props.failedTransactions" :key="data.id">
                                                <td>
                                                    <div>
                                                        <h5 class="mb-1 font-size-14">{{ data.user.name }}</h5>
                                                        <p class="mb-0 text-muted">{{ data.currency }} {{
                                                            useCurrencyFormat(data.amount) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end">
                                                        <span v-if="(data.txn_status = 'pending')"
                                                            class="badge badge-soft-warning font-size-11">Pending</span>
                                                        <span v-else-if="(data.txn_status = 'paid')"
                                                            class="badge badge-soft-success font-size-11">Paid</span>
                                                        <span v-else-if="(data.txn_status = 'failed')"
                                                            class="badge badge-soft-danger font-size-11">Failed</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v class="d-flex flex-column align-items-center"
                                        style="padding-top: 9vh; padding-bottom: 30vh">
                                        <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                        <div>No Transactions Yet.</div>
                                    </div>

                                </b-card-text>
                            </b-tab>
                        </b-tabs>

                        <div class="mt-4">
                            <a @click="myTransaction" class="btn btn-light me-2 w-md">See More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" d-flex align-items-stretch" :class="[width < 1440 ? 'col-12' : 'col-4']">
                <div class="card w-100">
                    <div class="card-body w-100">
                        <h4 class="mb-4 card-title">{{ isAdmin ? "Movies" : "My Movies" }}</h4>
                        <div v-if="isBeneficiary">
                            <div class="text-end"><b-button variant="primary" @click="useScheduleMoviesPage">Schedule
                                    Movie</b-button></div>

                            <div v-if="props.movies.length > 0" class="mt-5">
                                <div v-for="(movie, index) in props.movies" :key="`${movie.id}-${index}`"
                                    class="p-3 mb-3 rounded bg-light d-flex">
                                    <img :src="movie.thumbnail_url" alt="" class="rounded avatar-sm me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-2 font-size-15" role="button" @click="viewMovie(movie)">
                                            {{ movie.title }}
                                        </h5>
                                        <div class="flex-row gap-2 mb-1 d-flex" role="button">
                                            <div v-for="star in 5" :key="star" class="movie-item-star-icon-button"
                                                :class="star <= movie.overallRating ? 'text-warning' : 'text-grey'"
                                                :disabled="star === movie.overallRating" @click="updateRating(star)"
                                                @mouseover="() => (movie.overallRating = star)">
                                                <i class="bx bxs-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="dropdown">
                                            <button class="btn btn-soft-primary" type="button" id="dropdownMenuButton11"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton11">
                                                <li class="p-1 ps-3" role="button" @click="viewMovie(movie)">View
                                                    Details</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a @click="allMovies" class="btn btn-light me-2 w-md">See More</a>
                                </div>
                            </div>
                            <div v-else class="d-flex flex-column align-items-center"
                                style="padding-top: 15vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                <div>No Movies Yet.</div>
                            </div>
                        </div>
                        <div
                            v-else-if="currentUser.user_type === 'beneficiary' && currentUser.beneficiary_status === 'inactive'">
                            <div class="d-flex flex-column align-items-center"
                                style="padding-top: 20vh; padding-bottom: 30vh">
                                <div role="button" class="text-center"
                                    @click="useRequestBeneficiaryStatus(currentUser.id)">
                                    Beneficiary Status <span class="text-primary">Pending Approval</span>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div v class="d-flex flex-column align-items-center"
                                style="padding-top: 20vh; padding-bottom: 30vh">
                                <div role="button" class="text-center"
                                    @click="useRequestBeneficiaryStatus(currentUser.id)">
                                    You need to become a beneficiary to schedule Movies.<br />
                                    <span class="text-primary">Click Here</span> to submit your request.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" d-flex align-items-stretch" :class="[width < 1440 ? 'col-12' : 'col-4']">
                <div class="card w-100">
                    <div class="card-body w-100">
                        <h4 class="mb-4 card-title">{{ isAdmin ? "Events" : "My Events" }}</h4>
                        <div v-if="isBeneficiary">
                            <div class="text-end"><b-button variant="primary" @click="useScheduleEventsPage">Schedule
                                    Event</b-button></div>
                            <div v-if="props.events.length > 0" class="mt-5">
                                <div v-for="(event, index) in props.events" :key="`${event.id}-${index}`"
                                    class="p-3 mb-3 rounded bg-light d-flex">
                                    <img :src="event.thumbnail_url" alt="" class="rounded avatar-sm me-3" />
                                    <div class="flex-grow-1">
                                        <h5 class="mb-2 font-size-15" role="button" @click="viewEvent(event)">
                                            {{ event.title }}
                                        </h5>
                                        <p class="mb-0 text-muted"><i class="align-middle bx bx-map text-body"></i> {{
                                            event.location_name }}</p>
                                    </div>
                                    <div>
                                        <div class="dropdown">
                                            <button class="btn btn-soft-primary" type="button" id="dropdownMenuButton11"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton11">
                                                <li class="p-1 ps-3" role="button" @click="viewEvent(event)">View
                                                    Details</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a class="btn btn-light me-2 w-md" @click="allEvents">See More</a>
                                </div>
                            </div>
                            <div v-else class="d-flex flex-column align-items-center"
                                style="padding-top: 15vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                <div>No Events Yet.</div>
                            </div>
                        </div>
                        <div
                            v-else-if="currentUser.user_type === 'beneficiary' && currentUser.beneficiary_status === 'inactive'">
                            <div class="d-flex flex-column align-items-center"
                                style="padding-top: 20vh; padding-bottom: 30vh">
                                <div role="button" class="text-center"
                                    @click="useRequestBeneficiaryStatus(currentUser.id)">
                                    Beneficiary Status <span class="text-primary">Pending Approval</span>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="d-flex flex-column align-items-center"
                                style="padding-top: 20vh; padding-bottom: 30vh">
                                <div role="button" class="text-center"
                                    @click="useRequestBeneficiaryStatus(currentUser.id)">
                                    You need to become a beneficiary to schedule Events.<br />
                                    <span class="text-primary">Click Here</span> to submit your request.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
