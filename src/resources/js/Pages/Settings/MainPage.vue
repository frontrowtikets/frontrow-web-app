<script setup>
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import Layout from "@/js/Layouts/vertical.vue";
import PageHeader from "@/js/Components/page-header.vue";
import {reactive } from 'vue';

const state = reactive({
    items: [
        {
          text: "Dashboard",
          href: "/",
        },
        {
          text: "Settings",
          active: true,
        },
      ],

})

</script>
<template>
    <Head title="Settings" />
    <Layout>
        <PageHeader title="Settings" :items="state.items" />

        <div>This is the settings</div>
    </Layout>


</template>