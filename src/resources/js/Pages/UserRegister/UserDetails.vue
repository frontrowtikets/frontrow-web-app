<script setup>
import PageHeader from "../../Components/page-header.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { reactive, computed, onMounted } from "vue";
import Layout from "../../Layouts/main.vue";
import logoDarkSm from "../../../images/logo.svg";
import moment from "moment";
import axios from "axios";
import Swal from "sweetalert2";
import makeUserBeneficiary from "../../Composables/makeUserBeneficiary.js";
import deactivateBeneficiary from "../../Composables/deactivateBeneficiary.js";

const props = defineProps({
    userDetails: Object,
});

//Default Layout
defineOptions({ layout: Layout });

//state
const state = reactive({
    items: [
        {
            text: "User Details",
            // href: "javascript:void(0)"
        },
        {
            text: "Profile",
            active: true,
        },
    ],
});

//computed
const isBeneficiary = computed(() => {
    if (props.userDetails.allPermissions.includes("beneficiary")) {
        return true;
    } else {
        return false;
    }
});

function revokePermission(permissionName) {
    const options = {
        headers: {
            "Content-Type": "multipart/form-data",
            Authorization: `Bearer ${usePage().props.auth.user.api_token}`,
        },
    };

    Swal.fire({
        title: "Revoke Permission?",
        icon: "info",
        html: `<p style="font-size: 14px">You are about to revoke this permission from ${props.userDetails.name}.</p>`,
        showCancelButton: true,
        focusConfirm: true,
        confirmButtonText: "Yes, Proceed",
        confirmButtonColor: "#43ad60",
        allowOutsideClick: false,
        allowEscapeKey: false,
        closeOnClickOutside: false,
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: "Please wait...",
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            axios
                .post("api/userRegister/revokePermission", { userEmail: props.userDetails.email, permission: permissionName }, options)
                .then((res) => {
                    if (res.data.results === "success") {
                        Swal.fire({
                            title: "Role Revoked.",
                            icon: "success",
                            html: `<p style="font-size: 14px">The permission has been successfully revoked.</p>`,
                            showCloseButton: false,
                            showCancelButton: false,
                            focusConfirm: true,
                            confirmButtonText: "OK",
                            confirmButtonColor: "#43ad60",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            closeOnClickOutside: false,
                        }).then((result) => {
                            if (result.value) {
                                Swal.close();
                                // router.visit("/staff_register");
                                router.reload({
                                    preserveState: false,
                                });
                            }
                        });
                    }
                })
                .catch((err) => {
                    console.log("Error:", err);
                    Swal.fire({
                        title: "Something Went Wrong",
                        icon: "error",
                        html: `<p style="font-size: 14px">There is something that went wrong and it is not your fault. Please, reach out to Support for help.</p>`,
                        showCloseButton: false,
                        showCancelButton: false,
                        focusConfirm: true,
                        confirmButtonText: "OK",
                        confirmButtonColor: "#43ad60",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        closeOnClickOutside: false,
                    }).then((result) => {
                        if (result.value) {
                            router.reload({
                                preserveState: false,
                            });
                        }
                    });
                });
        }
    });
}

function goBack() {
    router.visit("/userregister");
}
</script>

<template>
    <Head title="User Details" />

    <PageHeader :title="'User Details'" :items="state.items" @click="goBack" />
    <div class="row">
        <div class="col-xl-4">
            <div class="overflow-hidden card">
                <div class="bg-soft bg-primary">
                    <div class="row">
                        <div class="col-9">
                            <div class="p-3 text-primary">
                                <!-- <h5 class="text-primary">Welcome Back !</h5> -->
                            </div>
                        </div>
                        <div class="pt-3 pb-3 col-3 align-self-end pe-4">
                            <img src="@/images/FRONTROWLogo.svg" height="75" width="75" alt class="img-fluid" />
                        </div>
                    </div>
                </div>
                <div class="pt-0 card-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="mb-4 avatar-md profile-user-wid">
                                <img :src="props.userDetails.profile_photo_url" alt class="img-thumbnail rounded-circle" />
                            </div>
                            <div class="mt-4">
                                <h5 class="font-size-15 text-truncate">{{ props.userDetails.name }}</h5>
                                <p class="mb-0 text-muted text-truncate">{{ props.userDetails.division }}</p>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="pt-4">
                                <div class="fw-bold text-end text-muted">
                                    User Type:

                                    <div v-if="props.userDetails.user_type == 'ticket_buyer'">
                                        <span class="badge text-bg-warning">Ticket Buyer</span>
                                    </div>
                                    <div v-if="props.userDetails.user_type == 'beneficiary'">
                                        <span class="badge text-bg-primary">Beneficiary</span>
                                    </div>
                                    <div v-if="props.userDetails.user_type == 'admin'"><span class="badge text-bg-indigo">Admin</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4 card-title">Personal Information</h4>

                    <div class="mb-0 table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{ props.userDetails.name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>{{ props.userDetails.email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">User Type:</th>
                                    <td v-if="props.userDetails.user_type == 'ticket_buyer'">Ticket Buyer</td>
                                    <td v-if="props.userDetails.user_type == 'beneficiary'">Beneficiary</td>
                                    <td v-if="props.userDetails.user_type == 'admin'">Admin</td>
                                </tr>
                                <tr>
                                    <th scope="row">Beneficiary Status:</th>
                                    <td v-if="props.userDetails.beneficiary_status == 'inactive'">
                                        <span class="badge badge-soft-warning font-size-11">Inactive</span>
                                    </td>
                                    <td v-else-if="props.userDetails.beneficiary_status == 'deactivated'">
                                        <span class="badge badge-soft-danger font-size-11">Deactived</span>
                                    </td>
                                    <td v-else-if="props.userDetails.beneficiary_status == 'active'">
                                        <span class="badge badge-soft-success font-size-11">Active</span>
                                    </td>
                                    <td v-else>
                                        <span class="badge badge-soft-primary font-size-11">Not a Beneficiary</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">Events Created:</th>
                                    <td>0</td>
                                </tr>

                                <tr>
                                    <th scope="row">
                                        Account Created<span><small>(Date)</small></span> :
                                    </th>
                                    <td>{{ moment(props.userDetails.created_at).format(`Do MMM, YYYY`) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5 table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="flex-wrap mb-3 fw-bold col-2" style="word-wrap: normal">Permissions:</div>
                                        <div v-if="props.userDetails.hasOwnProperty('allPermissions')">
                                            <span
                                                role="button"
                                                v-for="(permission, index) in props.userDetails.allPermissions"
                                                :key="`${index}_${permission}`"
                                            >
                                                <span class="mb-3 badge badge-soft-primary font-size-11 me-4" @click="revokePermission(permission)"
                                                    >{{ permission }}<i class="bx bxs-x-circle text-danger ps-1 pe-1" role="button"></i
                                                ></span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="row">
                <div v-for="stat of statData" :key="stat.icon" class="col-md-4">
                    <Stat :icon="stat.icon" :title="stat.title" :value="stat.value" />
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="text-end" v-if="isBeneficiary === false">
                        <b-button variant="primary" @click="makeUserBeneficiary(props.userDetails.name, props.userDetails.id)">
                            Make User Beneficiary</b-button
                        >
                    </div>
                    <div class="text-end" v-if="isBeneficiary === true">
                        <b-button variant="danger" @click="deactivateBeneficiary(props.userDetails.name, props.userDetails.id)">
                            Deactivate Beneficiary</b-button
                        >
                    </div>

                    <div class="mb-0 table-responsive">
                        <div>
                            <div class="mt-5 mb-5 text-center">
                                <div class="mb-2"><i class="fas fa-ban text-muted" style=""></i></div>
                                No Reports Yet
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</template>
