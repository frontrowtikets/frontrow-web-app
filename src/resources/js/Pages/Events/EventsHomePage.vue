<script setup>
import HomeHeader from "../../Components/HomeHeader.vue";
import FooterSection from "../../Components/FooterSection.vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import EventCard from "../../Components/EventCard.vue";
import { router,Head } from "@inertiajs/vue3";
import { onMounted } from "vue";

import { ref } from "vue";

const props = defineProps({
    events: {
        type: Array,
        default: [],
    },
    categories:{
        type:Array
    }
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
    router.visit(`/home/event/${slugify(title)}/${id}`);
}
</script>
<template>
    <Head title="Frontrow - Events" />

    <b-container class="mt-5">
        <HomeHeader />

        <div style="margin-top: 22vh; margin-bottom: 10vh">
            <div class="col-12">
                <div class="mb-4 col-12 d-flex justify-content-between align-items-center">
                    <div class="">
                        <div class="mt-2">
                            <h5>Events</h5>
                        </div>
                    </div>
                    <div class="">
                        <b-dropdown variant="light" right>
                            <template v-slot:button-content >
                                Filter
                                <i class="mdi mdi-chevron-down"></i>
                            </template>
                            <b-dropdown-item>
                                <b-form-checkbox id="checkbox-1" name="checkbox-1" :value="true" :unchecked-value="false" checked>
                                    All
                                </b-form-checkbox>
                                <b-form-checkbox v-for="(cat,index) in props.categories" :key="`${index}_${cat.id}`" id="checkbox-1" name="checkbox-1" :value="true" :unchecked-value="false">
                                    {{ cat.name }}
                                </b-form-checkbox>
                            </b-dropdown-item>
                        </b-dropdown>
                    </div>
                </div>

                <b-container>
                    <div class="flex-wrap gap-4 pt-4 d-flex align-items-center justify-content-center">
                        <div v-for="(item, index) in paginatedItems" :key="index" class="col-xl-3 col-md-4 col-sm-6">
                            <EventCard
                                :eventName="item.title"
                                :eventImageLink="item.thumbnail_url"
                                :eventDate="item.start_date"
                                :eventLocation="item.location_name"
                                :eventId="item.id"
                                :eventTickets="item.event_tickets"
                                @view="viewEvent"
                            />
                        </div>
                    </div>
                    <div ref="eventListBottom"></div>
                    <div v-if="nextPageExists" class="mt-4 text-center text-success">
                        <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                    </div>
                    <div v-else class="mt-4 text-center text-primary">No More Data</div>

                    <!-- end row -->
                </b-container>
            </div>
        </div>
    </b-container>
    <FooterSection />
</template>
