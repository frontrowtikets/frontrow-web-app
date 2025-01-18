<script setup>
import { Head, router } from "@inertiajs/vue3";
import { reactive, onMounted, ref } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import icondata from "@/images/icondata.png";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";

const props = defineProps({
    transactions: {
        type: Array,
        default: [],
    },
});

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
});

const series = ref([
    {
        type: "area",
        name: "Deposit",
        data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47],
    },
    {
        type: "area",
        name: "Withdraw",
        data: [28, 41, 52, 42, 13, 18, 29, 18, 36, 51, 55, 35],
    },
    {
        type: "line",
        name: "Balance",
        data: [45, 52, 38, 24, 33, 65, 45, 75, 54, 18, 28, 10],
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

function myTransaction(){
    router.visit("/mytransactions")
}
</script>

<template>
    <Head title="My Wallet" />

    <DashboardLayout>
        <PageHeader title="My Wallet" :items="state.items" />
        <div class="col-12">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body border-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <p class="mb-2 text-muted">Available Balance</p>
                                        <h5>UGX 9148.23</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top">
                            <p class="mb-4 text-muted">In this month</p>
                            <div class="text-center">
                                <div class="d-flex justify-content-between">
                                    <div class="col-sm-4">
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
                                    </div>
                                    <div class="col-sm-4">
                                        <div>
                                            <div class="mb-2 font-size-24 text-primary">
                                                <i class="bx bx-send"></i>
                                            </div>

                                            <p class="mb-2 text-muted">Deposit</p>
                                            <h5>UGX 654.42</h5>

                                            <div class="mt-3">
                                                <a href="#" class="btn btn-primary btn-sm w-md">Deposit</a>
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

                                                    <div v-else><span class="badge text-bg-indigo">Other</span></div>
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
        </div>
    </DashboardLayout>
</template>
