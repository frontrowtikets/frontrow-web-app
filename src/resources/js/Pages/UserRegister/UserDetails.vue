<script setup>
import PageHeader from "../../Components/page-header.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { reactive, computed, onMounted } from "vue";
import Layout from "../../Layouts/main.vue";
import logoDarkSm from "../../../images/logo.svg";
import moment from "moment";
import axios from "axios";
import Swal from "sweetalert2";

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
const isSuperAdmin = computed(() => {
    if (usePage().props.auth.user.allPermissions.includes("admin")) {
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
                        html: `<p style="font-size: 14px">There is something that went wrong and it is not your fault. Please, reach out to ICT for help.</p>`,
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

function makeUserAdmin() {
    const options = {
        headers: {
            "Content-Type": "multipart/form-data",
            Authorization: `Bearer ${usePage().props.auth.user.api_token}`,
        },
    };

    Swal.fire({
        title: "Are you sure?",
        icon: "info",
        html: `<p style="font-size: 14px">You are to make ${props.userDetails.name} an Administrator.</p>`,
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
                .post("api/userRegister/makeUserAdmin", { userEmail: props.userDetails.email }, options)
                .then((res) => {
                    if (res.data.results === "success") {
                        Swal.fire({
                            title: "Operation Successful.",
                            icon: "success",
                            html: `<p style="font-size: 14px">The have successfully made ${props.userDetails.name} an Administrator.</p>`,
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
                        html: `<p style="font-size: 14px">There is something that went wrong and it is not your fault. Please, reach out to ICT for help.</p>`,
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
</script>

<template>
    <Head title="User Details" />

    <PageHeader :title="'User Details'" :items="state.items" @click="goBack" />
    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-soft bg-primary">
                    <div class="row">
                        <div class="col-9">
                            <div class="text-primary p-3">
                                <!-- <h5 class="text-primary">Welcome Back !</h5> -->
                            </div>
                        </div>
                        <div class="col-3 align-self-end pt-3 pb-3 pe-4">
                            <img src="@/images/FRONTROWLogo.svg" height="75" width="75" alt class="img-fluid" />
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img :src="props.userDetails.profile_photo_url" alt class="img-thumbnail rounded-circle" />
                            </div>
                            <div class="mt-4">
                                <h5 class="font-size-15 text-truncate">{{ props.userDetails.name }}</h5>
                                <p class="text-muted mb-0 text-truncate">{{ props.userDetails.division }}</p>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="pt-4">
                                <div class="fw-bold text-end text-muted">
                                    Role:
                                    <div v-if="props.userDetails.allPermissions.includes('admin')">
                                        <span class="badge text-bg-warning">Administrator</span>
                                    </div>
                                    <div>
                                        <span class="badge text-bg-success">Normal User</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-end" v-if="isSuperAdmin">
                                <div class="btn btn-primary btn-sm mt-2" @click="makeUserAdmin">
                                    Make User Admin
                                    <i class="mdi mdi-arrow-right ms-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Personal Information</h4>

                    <div class="table-responsive mb-0">
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
                                    <th scope="row">Division:</th>
                                    <td>{{ props.userDetails.division }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">Number of reports made :</th>
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

                    <div class="table-responsive mt-5">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-bold mb-3 flex-wrap col-2" style="word-wrap: normal">Permissions:</div>
                                        <div v-if="props.userDetails.hasOwnProperty('allPermissions')">
                                            <span role="button" v-for="(permission, index) in props.userDetails.allPermissions" :key="`${index}_${permission}`">
                                                <span class="badge badge-soft-primary font-size-11 me-4 mb-3" @click="revokePermission(permission)"
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
            <div class="">
                <div class="">
                    <UnicefStaffLoginActivity />
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Environmental Reports Made</h4>
                    <div class="table-responsive mb-0">
                        <div>
                            <div class="text-center mt-5 mb-5">
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
