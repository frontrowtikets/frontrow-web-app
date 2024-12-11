<script setup>
import { Head } from "@inertiajs/vue3";
import {reactive} from "vue";
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
          text: "Movies",
          active: true,
        },
      ],
});

</script>

<template>
    <Head title="My Movies" />

    <DashboardLayout>
        <PageHeader title="My Movies" :items="state.items" />
    <div>Movies</div>
    </DashboardLayout>
</template>
