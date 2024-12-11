<script setup>
import { Head, useForm, router } from "@inertiajs/vue3";
import { reactive } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import InputError from "@/js/Components/InputError.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import icondata from "@/images/icondata.png";

const state = reactive({
    items: [
        {
            text: "Dashboard",
            href: "javascript:void(0)",
        },
        {
            text: "Schedule Events",
            active: true,
        },
    ],
});
const form = useForm({
    beneficiary_id: "",
    title: "",
    description: "",
    location_name: "",
    gps_location: "",
    status: "",
    start_date: "",
    end_date: "",
    thumbnail_url: "",
    currency: "",
    access_type: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset(),
        onError: (err) => console.log(err),
    });
};
</script>




<template>
    <Head title="Schedule Events" />

    <DashboardLayout>
        <PageHeader title="Schedule Events" :items="state.items" />
        <div class="mt-4">
            <form>

                <div class="mb-3 col-12 col-md-8">
                    <label for="title" class="mb-2">Event Title</label>
                    <input style="font-size: 13px" type="text" class="form-control" id="title" placeholder="Title" required v-model="form.title" />
                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.title" />
                </div>





                <div class="mt-5 ">
                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit" @click="submit" :disabled="form.processing">
                        <i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="form.processing"></i><span>Schedule Event</span>
                    </button>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>
