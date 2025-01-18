<script setup>
import PageHeader from "@/js/Components/page-header.vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import { reactive, onMounted, computed, ref } from "vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import Swal from "sweetalert2";
import icondata from "@/images/icondata.png";
import useInertiaFormSubmit from "@/js/Composables/useInertiaFormSubmit.js";
import MovieTicketCard from "@/js/Components/MovieTicketCard.vue";


const props = defineProps({
    movieTickets:{
         type: Object,
        required: true,
    }
});

const movieTicketsBottom = ref(null);
const { paginatedItems, nextPageExists } = useInfiniteScroll("movieTickets", movieTicketsBottom);


const state = reactive({
    items: [
        {
            text: "Movies",
        },
        {
            text: "Manage Movie",
            active: true,
        },
    ],
});
</script>
<template>
    <Head title="Manage Movie" />
    <DashboardLayout>
        <PageHeader title="Manage Movie" :items="state.items" />
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <b-tabs>
                        <b-tab title="Tickets Sold" active>
                            <div v-if="paginatedItems.length > 0">
                                    <div class="flex-wrap gap-5 mt-5 d-flex justify-content-center">
                                        <MovieTicketCard
                                            v-for="(ticket, index) in paginatedItems"
                                            :key="`${index}_${ticket.id}`"
                                            :ticketId="ticket.ticket_id"
                                            :status="ticket.ticket_status"
                                            :movie="ticket?.movie"
                                            :theatre="ticket?.theatre"
                                            :userDetails="ticket?.user_payment_detail"
                                            :transactionDetails="ticket?.payment_transaction"
                                            :seatDetails="ticket?.show_time_seats"
                                        />
                                    </div>
                                    <div>
                                        <div ref="movieTicketsBottom"></div>
                                        <div v-if="nextPageExists" class="mt-4 text-center text-success">
                                            <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                        </div>
                                        <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                    </div>
                                </div>
                            <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                <div>No tickets yet.</div>
                            </div>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div></DashboardLayout
    >
</template>
