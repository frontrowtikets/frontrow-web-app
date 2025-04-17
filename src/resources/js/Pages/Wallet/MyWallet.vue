<script setup>
import { Head, router, useForm, usePage } from "@inertiajs/vue3";
import { reactive, onMounted, ref } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import icondata from "@/images/icondata.png";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import { Money3Component } from "v-money3";
import axios from "axios";
import moment from "moment";
import { useWindowSize } from "@vueuse/core";

const props = defineProps({
    transactions: {
        type: Array,
        default: [],
    },
    myWallet: {
        type: Object,
    },
    monthlyTransactionCounts: {
        type: Array,
        default: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    },
});
const { height, width } = useWindowSize();

const walletModal = ref(false);
const paymentRedirectURL = ref(null);
const showPaymentPage = ref(false);
const isProcessing = ref(false);
const responseError = ref("");

const state = reactive({
    items: [
        {
            text: "Dashboard",
            href: "javascript:void(0)",
        },
        {
            text: "My Wallet",
            active: true,
        },
    ],
    config: {
        masked: false,
        prefix: "",
        suffix: "",
        thousands: ",",
        decimal: ".",
        precision: 2,
        disableNegative: false,
        disabled: false,
        min: null,
        max: null,
        allowBlank: false,
        minimumNumberOfCharacters: 0,
        shouldRound: true,
        focusOnRight: false,
    },
});

const form = useForm({
    amount: 0.0,
});

const series = ref([
    {
        type: "area",
        name: "Transactions",
        data: props.monthlyTransactionCounts,
    },
]);

const chartOptions = ref({
    chart: {
        toolbar: {
            show: false,
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "smooth",
        width: 2,
        dashArray: [0, 0, 3],
    },
    fill: {
        type: "solid",
        opacity: [0.15, 0.05, 1],
    },
    xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    },
    colors: ["#f1b44c", "#3452e1", "#50a5f1"],
});

onMounted(() => {});

function myTransaction() {
    router.visit("/mytransactions");
}

async function submitDeposit() {
    const details = { ticketType: "wallet", amount: form["amount"], userId: usePage().props.auth.user.id };
    localStorage.setItem("paymentDetails", JSON.stringify(details));
    if (form["amount"] > 0) {
        isProcessing.value = true;
        const details = {
            amount: form["amount"],
            description: "Wallet Deposit",
            email: usePage().props.auth.user.email,
            phone: usePage().props.auth.user.phone_number,
            first_name: usePage().props.auth.user.name,
            last_name: usePage().props.auth.user.name,
        };
        await axios
            .post("/api/v1/payments/makepayment", details, {
                headers: {
                    Accept: "application/json",
                },
            })
            .then((res) => {
                if (res.status == 200) {
                    paymentRedirectURL.value = res.data;
                }
            })
            .then(() => {
                if (paymentRedirectURL.value) {
                    showPaymentPage.value = true;
                } else {
                    responseError.value = "Oops!,Please try again";
                    isProcessing.value = false;
                }
            })
            .catch((err) => {
                responseError.value = err;
                isProcessing.value = false;
            });
    }
}
</script>

<template>
    <Head title="My Wallet" />

    <DashboardLayout>
        <PageHeader title="My Wallet" :items="state.items" />
        <div v-if="showPaymentPage" class="card">
            <div class="card-body border-top">
                <div class="payment-container">
                    <iframe id="payment_page" ref="paymentPageIframe" :src="paymentRedirectURL" style="width: 100%; height: 100%"></iframe>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="col-12">
                <div class="row">
                    <div class="col-4" :class="[width < 1440 ? 'col-12' : 'col-4']">
                        <div class="card">
                            <div class="card-body border-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div>
                                            <p class="mb-2 text-muted">Available Balance</p>
                                            <h5>UGX {{ props.myWallet ? useCurrencyFormat(props.myWallet.balance) : "0.00" }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <p class="mb-4 text-muted">Topup</p>
                                <div class="text-center">
                                    <div class="d-flex justify-content-between">
                                        <!-- <div class="col-sm-4">
                                        <div class="mt-4 mt-sm-0">
                                            <div class="mb-2 font-size-24 text-primary">
                                                <i class="bx bx-wallet"></i>
                                            </div>

                                            <p class="mb-2 text-muted">Withdraw</p>
                                            <h5>UGX 824.34</h5>

                                            <div class="mt-3">
                                                <a href="#" class="btn btn-primary btn-sm w-md">Withdraw</a>
                                            </div>
                                        </div>
                                    </div> -->
                                        <div class="col-sm-4">
                                            <div>
                                                <div class="mb-2 font-size-24 text-primary">
                                                    <i class="bx bx-send"></i>
                                                </div>

                                                <p class="mb-2 text-muted">Last Deposit</p>
                                                <p>{{ props.myWallet ? moment(props.myWallet.updated_at).format("ddd, DD MMM YYYY") : "Never" }}</p>

                                                <div class="mt-3">
                                                    <a @click="walletModal = true" class="btn btn-primary btn-sm w-md">Deposit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3 card-title">Overview</h4>

                                <div>
                                    <apexchart
                                        class="apex-charts"
                                        type="line"
                                        :height="240"
                                        dir="ltr"
                                        :series="series"
                                        :options="chartOptions"
                                    ></apexchart>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-4 card-title">Transactions</h4>

                            <ul class="nav nav-tabs nav-tabs-custom">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">All</a>
                                </li>
                            </ul>

                            <div class="mt-4">
                                <div class="table-responsive">
                                    <div v-if="props.transactions.length > 0">
                                        <table class="table align-middle table-nowrap table-striped dt-responsive nowrap w-100 table-container">
                                            <thead>
                                                <tr>
                                                    <th>Reference</th>
                                                    <th class="text-center">Payment Type</th>
                                                    <th class="text-center">status</th>
                                                    <th class="text-end">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in props.transactions" :key="`${index}_${item.id}`">
                                                    <td :style="{ backgroundColor: '#fff' }">{{ item.txn_ref }}</td>
                                                    <td :style="{ backgroundColor: '#fff' }" class="text-center">
                                                        <div v-if="item.txn_type == 'ticket_purchase'">
                                                            <span class="badge text-bg-success">Ticket Purchase</span>
                                                        </div>

                                                        <div v-else-if="item.txn_type == 'movie_ticket'">
                                                            <span class="badge text-bg-success">Movie Ticket</span>
                                                        </div>
                                                        <div v-else-if="item.txn_type == 'event_ticket'">
                                                            <span class="badge text-bg-success">Event Ticket</span>
                                                        </div>

                                                        <div v-else><span class="badge text-bg-primary">Other</span></div>
                                                    </td>
                                                    <td :style="{ backgroundColor: '#fff' }" class="text-center">
                                                        <div v-if="item.txn_status == 'pending'">
                                                            <span class="badge text-bg-warning">Peding</span>
                                                        </div>
                                                        <div v-if="item.txn_status == 'paid'">
                                                            <span class="badge text-bg-success">Paid</span>
                                                        </div>
                                                        <div v-if="item.txn_status == 'cancelled'">
                                                            <span class="badge text-bg-danger">Cancelled</span>
                                                        </div>
                                                        <div v-if="item.txn_status == 'failed'">
                                                            <span class="badge text-bg-warning">Failed</span>
                                                        </div>
                                                    </td>
                                                    <td :style="{ backgroundColor: '#fff' }" class="text-end">
                                                        {{ item.currency }} {{ useCurrencyFormat(item.amount) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div ref="myTransactionsBottom"></div>
                                        <div class="mt-4 text-center">
                                            <a @click="myTransaction" class="btn btn-light me-2 w-md">See More</a>
                                        </div>
                                    </div>
                                    <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                        <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                        <div>No Transactions Yet.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <b-modal v-model="walletModal" id="EventRegister" centered title="Deposit to Wallet" title-class="font-18" hide-footer>
                    <div>
                        <form>
                            <div v-if="form.errors.amount" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                {{ form.errors.amount }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <div v-if="responseError" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                {{ responseError }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <div class="mt-4 mb-3 col-12 row">
                                <div class="mb-3 col-3">
                                    <label for="currency">Currency</label>
                                    <select class="form-select form-control" id="currency" disabled>
                                        <option value="UGX" :selected="true">UGX</option>
                                    </select>
                                </div>

                                <div class="mb-4 col-8">
                                    <label for="">Amount</label>
                                    <Money3Component class="form-control" v-model="form.amount" v-bind="state.config"></Money3Component>
                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.name" />
                                </div>
                            </div>

                            <div class="mt-4 d-grid">
                                <button
                                    class="btn btn-primary btn-block waves-effect waves-light"
                                    type="submit"
                                    @click.prevent="submitDeposit"
                                    :disabled="isProcessing"
                                >
                                    <i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="isProcessing"></i><span>Make Deposit</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </b-modal>
            </div>
        </div>
    </DashboardLayout>
</template>
<style lang="css">
.payment-container {
    width: 100%;
    height: 100vh;
    position: relative;
}

.payment_page {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
    overflow: hidden;
}
</style>
