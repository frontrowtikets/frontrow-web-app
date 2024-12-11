<script setup>
import { Head } from "@inertiajs/vue3";
import { reactive } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import icondata from "@/images/icondata.png";

const state = reactive({
    items: [
        {
            text: "Dashboard",
            href: "javascript:void(0)",
        },
        {
            text: "Settings",
            active: true,
        },
    ],
});
</script>

<template>
    <Head title="Settings" />

    <DashboardLayout>
        <PageHeader title="Settings" :items="state.items" />
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <b-tabs>
                        <b-tab active title="Events">
                            <div class="mt-5">
                                <div class="col-12 col-md-6">
                                    <h6>Categories</h6>
                                    <div class="mt-2 w-100">
                                        <span>Add Event Category</span>
                                    </div>
                                </div>
                            </div>
                        </b-tab>
                        <b-tab title="Movies">
                            <div class="mt-5">
                                <h6>Categories</h6>
                                <div class="mt-2 w-100">
                                    <span>Add Movie Category</span>
                                </div>
                            </div>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
