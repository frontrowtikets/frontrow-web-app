<script setup>
import { Head } from "@inertiajs/vue3";
import { reactive, onMounted } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import icondata from "@/images/icondata.png";

const props = defineProps({
    eventCategories: {
        type: Array,
        default: [],
    },
    movieCategories: {
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
</script>

<template>
    <Head title="My Tickets" />

    <DashboardLayout>
        <PageHeader title="My Tickets" :items="state.items" />
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                        <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                        <div>No Tickets Yet.</div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
