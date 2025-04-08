<script setup>
import PageHeader from "@/js/Components/page-header.vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import { reactive, onMounted, onUnmounted, computed, ref } from "vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import EventCard from "../../Components/EventCard.vue";
import icondata from "@/images/icondata.png";

const props = defineProps({
    events: {
        type: Object,
        required: true,
    },
});

const state = reactive({
    items: [
        {
            text: "Dashboard",
        },
        {
            text: "Events",
            active: true,
        },
    ],
});

const eventListBottom = ref(null);

onMounted(()=>{
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
})

const { paginatedItems, nextPageExists } = useInfiniteScroll("events", eventListBottom);
function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}
function viewEvent(title, id) {
    router.visit(`/event/${slugify(title)}/${id}`);
}
</script>
<template>
    <Head title="Events" />
    <DashboardLayout>
        <PageHeader title="Events" :items="state.items" />
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <b-container>
                        <div class="flex-wrap gap-4 d-flex align-items-center justify-content-center">
                            <div v-for="(item, index) in paginatedItems" :key="index" class="col-xl-3 col-md-4 col-sm-6">
                                <EventCard
                                    :eventName="item.title"
                                    :eventImageLink="item.thumbnail_url"
                                    :eventDate="item.start_date"
                                    :eventLocation="item.location_name"
                                    :eventId="item.id"
                                    :eventTickets = "item.event_tickets"
                                    @view="viewEvent"
                                />
                            </div>
                        </div>
                        <div ref="eventListBottom"></div>
                        <div v-if="nextPageExists" class="mt-4 text-center text-success">
                            <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                        </div>
                        <div v-else class="mt-4 text-center text-primary">No More Data</div>
                    </b-container>
                </div>
            </div>
        </div></DashboardLayout
    >
</template>
