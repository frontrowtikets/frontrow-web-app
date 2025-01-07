<script setup>
import { Head } from "@inertiajs/vue3";
import { reactive,ref } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import icondata from "@/images/icondata.png";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";

const props = defineProps({
    transationDetails: {
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
            text: "My transationDetails",
            active: true,
        },
    ],
});

const myTransactionsBottom = ref(null);

const { paginatedItems, nextPageExists } = useInfiniteScroll("transationDetails", myTransactionsBottom);
</script>

<template>
    <Head title="My Transactions" />

    <DashboardLayout>
        <PageHeader title="My Transactions" :items="state.items" />
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div v-if="paginatedItems.length > 0">
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
                                <tr v-for="(item, index) in paginatedItems" :key="`${index}_${item.id}`">
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
                                    <td :style="{ backgroundColor: '#fff' }" class="text-end">{{ item.currency }} {{ useCurrencyFormat(item.amount) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div ref="myTransactionsBottom"></div>
                        <div v-if="nextPageExists" class="mt-4 text-center text-success">
                            <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                        </div>
                        <div v-else class="mt-4 text-center text-primary">No More Data</div>
                    </div>
                    <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                        <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                        <div>No Transactions Yet.</div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
