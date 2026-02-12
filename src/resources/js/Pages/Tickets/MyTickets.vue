<script setup>
import { Head, router } from "@inertiajs/vue3";
import { reactive, onMounted, ref } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import icondata from "@/images/icondata.png";
import MovieTicketCard from "@/js/Components/MovieTicketCard.vue";
import EventTicketCard from "@/js/Components/EventTicketCard.vue";


import { useInfiniteScroll } from "@/js/Composables/useInfiniteScroll.js";

const props = defineProps({
    movieTickets: {
        type: Array,
        default: [],
    },
    eventTickets: {
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
            text: "My Tickets",
            active: true,
        },
    ],
    eventCategories: [],
    newTags: [],
    movieCategories: [],
    newMovieTags: [],
});

const movieTicketsBottom = ref(null);
const movieEventsBottom = ref(null);

const { paginatedItems, nextPageExists } = useInfiniteScroll("movieTickets", movieTicketsBottom);
const { paginatedItems: eventpaginatedItems, nextPageExists: eventNextPageExists } = useInfiniteScroll("eventTickets", movieEventsBottom);

onMounted(() => {});
function allEvents() {
    router.visit("/allevents");
}

function allMovies() {
    router.visit("allmovies");
}
</script>

<template>
    <Head title="My Tickets" />

    <DashboardLayout>
        <PageHeader title="My Tickets" :items="state.items" />
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <b-tabs>
                            <b-tab active :title="'Movie Tickets'">
                                <div class="mt-4 text-end">
                                    <b-button class="btn btn-soft-primary" @click="allMovies">More Movies</b-button>
                                </div>


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
                                    <div>No Movie Tickets Yet.</div>
                                    <div ref="movieTicketsBottom"></div>
                                </div>
                            </b-tab>
                            <b-tab :title="'Event Tickets'">
                                <div class="mt-4 text-end">
                                    <b-button class="btn btn-soft-primary" @click="allEvents">More Events</b-button>
                                </div>
                                <div v-if="eventpaginatedItems.length > 0">
                                    <div class="flex-wrap gap-5 mt-5 d-flex justify-content-center">
                                        <EventTicketCard
                                            v-for="(ticket, index) in eventpaginatedItems"
                                            :key="`${index}_${ticket.id}`"
                                            :ticketId="ticket.ticket_id"
                                            :status="ticket.ticket_status"
                                            :event="ticket?.event"
                                            :userDetails="ticket?.user_payment_detail"
                                            :transactionDetails="ticket?.payment_transaction"
                                            :ticketAmount="ticket?.total_amount"
                                            :ticketCategory="ticket?.event_ticket?.category"
                                        />
                                    </div>
                                    <div>
                                        <div ref="movieEventsBottom"></div>
                                        <div v-if="eventNextPageExists" class="mt-4 text-center text-success">
                                            <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                        </div>
                                        <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                    </div>
                                </div>
                                <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                    <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                    <div>No Event Tickets Yet.</div>
                                    <div ref="movieEventsBottom"></div>
                                </div>
                            </b-tab>
                        </b-tabs>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
