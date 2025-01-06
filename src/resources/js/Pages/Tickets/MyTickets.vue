<script setup>
import { Head } from "@inertiajs/vue3";
import { reactive, onMounted } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import icondata from "@/images/icondata.png";
import MovieTicketCard from "@/js/Components/MovieTicketCard.vue";


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

onMounted(() => {});
function allEvents(){
    router.visit('/allevents')
}

function allMovies(){
    router.visit('allmovies')
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

                                <div v-if="props.movieTickets.length > 0">
                                    <div class="flex-wrap gap-5 mt-5 d-flex justify-content-center">
                                        <MovieTicketCard v-for="(ticket, index) in props.movieTickets"  :key="`${index}_${ticket.id}`"
                                        :ticketId="ticket.ticket_id"
                                        :status="ticket.ticket_status"
                                        :movie="ticket?.movie"
                                        :theatre="ticket?.theatre"
                                        :userDetails="ticket?.user_payment_detail"
                                        :transactionDetails="ticket?.payment_transaction"
                                        :seatDetails="ticket?.show_time_seats"
                                        />
                                    </div>
                                </div>
                                <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                    <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                    <div>No Movie Tickets Yet.</div>
                                </div>
                            </b-tab>
                            <b-tab :title="'Event Tickets'">
                                <div class="mt-4 text-end">
                                    <b-button class="btn btn-soft-primary" @click="allEvents">More Events</b-button>
                                </div>
                                <div v-if="props.eventTickets.length > 0"></div>
                                <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                    <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                    <div>No Event Tickets Yet.</div>
                                </div>
                            </b-tab>
                        </b-tabs>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
