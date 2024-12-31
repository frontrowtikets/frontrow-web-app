<script setup>
import PageHeader from "@/js/Components/page-header.vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import { reactive, onMounted, computed, ref } from "vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";
import Swal from "sweetalert2";
import icondata from "@/images/icondata.png";
import useInertiaFormSubmit from "@/js/Composables/useInertiaFormSubmit.js";

const props = defineProps({});

const state = reactive({
    items: [
        {
            text: "Movies",
            // href: "javascript:void(0)"
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
                            <div class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                <div>No tickets yet.</div>
                            </div>
                        </b-tab>
                    </b-tabs>

                </div>
            </div>
        </div></DashboardLayout
    >
</template>
