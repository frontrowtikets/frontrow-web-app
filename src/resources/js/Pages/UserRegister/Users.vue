<script setup>
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import Layout from "../../Layouts/main.vue";
import PageHeader from "../../Components/page-header.vue";
import { reactive } from "vue";

const props = defineProps(["users"]);

function viewUserDetails(id) {
    router.visit("/userdetails", {
        method: "get",
        data: { userID: id },
    });
}

const state = reactive({
    items: [
        {
            text: "User Register",
            // href: "javascript:void(0)"
        },
        {
            text: "Profile",
            active: true,
        },
    ],
});
</script>
<template>
    <Head title="User Register" />
    <Layout>
        <div>
            <PageHeader :title="'User Register'" :items="state.items" />

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Permissions</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in props.users" :key="index">
                                        <th scope="row" :style="{ backgroundColor: '#fff' }">
                                            <div v-if="user != null">
                                                <img :src="user.profile_photo_url" :alt="''" class="rounded-circle avatar-xs object-fit-cover" />
                                            </div>
                                        </th>
                                        <td :style="{ backgroundColor: '#fff' }">{{ user.name }}</td>
                                        <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.email }}</td>
                                        <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.division }}</td>
                                        <td :style="{ backgroundColor: '#fff' }" class="text-center">
                                            <div v-if="user.allPermissions.includes('admin')">
                                                <span class="badge text-bg-secondary">Administrator</span>
                                            </div>
                                            <div v-if="user.allPermissions.includes('ticket_buyer')">
                                                <span class="badge text-bg-success">Ticket Buyer</span>
                                            </div>
                                            <div v-if="user.allPermissions.includes('beneficiary')">
                                                <span class="badge text-bg-primary">Beneficiary</span>
                                            </div>
                                            <div v-if="user.allPermissions.includes('s_admin')">
                                                <span class="badge text-bg-warning">Super Admin</span>
                                            </div>

                                        </td>

                                        <td :style="{ backgroundColor: '#fff' }" class="text-end">
                                            <div class="d-flex justify-content-end">
                                                <div class="gap-1 mb-0 list-unstyled hstack">
                                                    <div data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View" @click="viewUserDetails(user.id)">
                                                        <div class="btn btn-sm btn-soft-primary"><i class="mdi mdi-eye-outline"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
