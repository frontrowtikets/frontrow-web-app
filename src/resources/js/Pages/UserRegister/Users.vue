<script setup>
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import Layout from "../../Layouts/main.vue";
import PageHeader from "../../Components/page-header.vue";
import { reactive, onMounted, ref } from "vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import Swal from "sweetalert2";
import icondata from "@/images/icondata.png";
import makeUserBeneficiary from "../../Composables/makeUserBeneficiary.js";
import deactivateBeneficiary from "../../Composables/deactivateBeneficiary.js";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    userNames: {
        type: Array,
        required: true,
    },
    seededPermissions: {
        type: Array,
        required: true,
    },
    inactiveDeneficiaries: {
        type: Object,
        required: true,
    },
    deactiveDeneficiaries: {
        type: Object,
        required: true,
    },
});

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
    assignPermissionModal: false,
    assignPermissions: {
        permissions: [],
        user: null,
    },
    assignPermissionsLoader: false,
    activePermissions: [],
});
const usersTableBottom = ref(null);
const beneficiaryRequestsTableBottom = ref(null);
const deactivatedTableBottom = ref(null);

const { paginatedItems, nextPageExists } = useInfiniteScroll("users", usersTableBottom);
const { paginatedItems: inactivepaginatedItems, nextPageExists: inactivenextPageExists } = useInfiniteScroll(
    "inactiveDeneficiaries",
    beneficiaryRequestsTableBottom
);
const { paginatedItems: deactivepaginatedItems, nextPageExists: deactivenextPageExists } = useInfiniteScroll(
    "deactiveDeneficiaries",
    deactivatedTableBottom
);

onMounted(() => {
    props.seededPermissions.forEach((permission) => {
        //beneficiary permissions are not assigned directly
        if (permission.name !== "beneficiary") {
            state.activePermissions.push(permission.name);
        }
    });
});

function viewUserDetails(id) {
    router.visit("/userdetails", {
        method: "get",
        data: { userID: id },
    });
}

/**
 * Asiging Permissions
 */
function assignPermission() {
    state.assignPermissionsLoader = true;
    const options = {
        headers: {
            "Content-Type": "multipart/form-data",
            Authorization: `Bearer ${usePage().props.auth.user.api_token}`,
        },
    };

    axios
        .post("api/userRegister/assignPermissions", { permissions: state.assignPermissions }, options)
        .then((res) => {
            console.log(res);

            state.assignPermissionsLoader = false;
            state.assignPermissionModal = false;
            state.assignPermissions = {
                permissions: [],
                user: null,
            };

            Swal.fire({
                title: "Assignment Successful",
                icon: "success",
                html: `<p style="font-size: 14px">You have successfully assigned Permissions.</p>`,
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
                    router.reload();
                }
            });
        })
        .catch((err) => {
            state.assignPermissionsLoader = false;

            if (err.response.data.message.includes("already exists for guard")) {
                Swal.fire({
                    title: "Something Went Wrong",
                    icon: "error",
                    html: `<p style="font-size: 14px">${err.response.data.message}</p>`,
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
            } else {
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
            }
        });
}
</script>
<template>
    <Head title="User Register" />
    <Layout>
        <div>
            <PageHeader :title="'User Register'" :items="state.items" />

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4 d-flex justify-content-end">
                            <div><b-button variant="primary" class="" @click="state.assignPermissionModal = true">Assign Permissions</b-button></div>
                        </div>
                        <b-tabs>
                            <b-tab title="Users" active>
                                <div class="mt-5 table-responsive" v-if="paginatedItems.length > 0">
                                    <table class="table align-middle table-nowrap table-striped dt-responsive nowrap w-100 table-container">
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
                                            <tr v-for="(user, index) in paginatedItems" :key="`${index}_${user.email}`">
                                                <th scope="row" :style="{ backgroundColor: '#fff' }">
                                                    <div v-if="user != null">
                                                        <img
                                                            :src="user.profile_photo_url"
                                                            :alt="''"
                                                            class="rounded-circle avatar-xs object-fit-cover"
                                                        />
                                                    </div>
                                                </th>
                                                <td :style="{ backgroundColor: '#fff' }">{{ user.name }}</td>
                                                <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.email }}</td>
                                                <td :style="{ backgroundColor: '#fff' }" class="text-center">
                                                    <div v-if="user.user_type == 'ticket_buyer'">
                                                        <span class="badge text-bg-warning">Ticket Buyer</span>
                                                    </div>
                                                    <div v-if="user.user_type == 'beneficiary'">
                                                        <div><span class="badge text-bg-primary">Beneficiary</span></div>
                                                        <div v-if="user.beneficiary_status === 'inactive'">
                                                            <span class="badge badge-soft-danger">Inactive</span>
                                                        </div>
                                                        <div v-if="user.beneficiary_status === 'deactivated'">
                                                            <span class="badge badge-soft-secondary">Deactivated</span>
                                                        </div>
                                                    </div>
                                                    <div v-if="user.user_type == 'admin'"><span class="badge text-bg-indigo">Admin</span></div>
                                                </td>
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
                                                            <div
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                aria-label="View"
                                                                @click="viewUserDetails(user.id)"
                                                            >
                                                                <div class="btn btn-sm btn-soft-primary"><i class="mdi mdi-eye-outline"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div ref="usersTableBottom"></div>
                                    <div v-if="nextPageExists" class="mt-4 text-center text-success">
                                        <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                    </div>
                                    <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                </div>
                                <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                    <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                    <div>No Registered Users.</div>
                                    <div ref="usersTableBottom"></div>
                                </div>
                            </b-tab>
                            <b-tab title="Beneficiary Requests">
                                <div class="mt-5 table-responsive" v-if="inactivepaginatedItems?.length > 0">
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
                                            <tr v-for="(user, index) in inactivepaginatedItems" :key="index">
                                                <th scope="row" :style="{ backgroundColor: '#fff' }">
                                                    <div v-if="user != null">
                                                        <img
                                                            :src="user.profile_photo_url"
                                                            :alt="''"
                                                            class="rounded-circle avatar-xs object-fit-cover"
                                                        />
                                                    </div>
                                                </th>
                                                <td :style="{ backgroundColor: '#fff' }">{{ user.name }}</td>
                                                <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.email }}</td>
                                                <td :style="{ backgroundColor: '#fff' }" class="text-center">
                                                    <div v-if="user.user_type == 'ticket_buyer'">
                                                        <span class="badge text-bg-warning">Ticket Buyer</span>
                                                    </div>
                                                    <div v-if="user.user_type == 'beneficiary'">
                                                        <div><span class="badge text-bg-primary">Beneficiary</span></div>
                                                        <div v-if="user.beneficiary_status === 'inactive'">
                                                            <span class="badge badge-soft-danger">Inactive</span>
                                                        </div>
                                                        <div v-if="user.beneficiary_status === 'deactivated'">
                                                            <span class="badge badge-soft-secondary">Deactivated</span>
                                                        </div>
                                                    </div>
                                                    <div v-if="user.user_type == 'admin'"><span class="badge text-bg-indigo">Admin</span></div>
                                                </td>
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
                                                            <div
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                aria-label="View"
                                                                @click="viewUserDetails(user.id)"
                                                            >
                                                                <div class="btn btn-sm btn-soft-primary"><i class="mdi mdi-eye-outline"></i></div>
                                                            </div>
                                                            <div
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                aria-label="View"
                                                                @click="makeUserBeneficiary(user.name, user.id)"
                                                            >
                                                                <div class="btn btn-sm btn-soft-success"><i class="bx bx-check-square"></i></div>
                                                            </div>
                                                            <div
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                aria-label="View"
                                                                @click="deactivateBeneficiary(user.name, user.id)"
                                                            >
                                                                <div class="btn btn-sm btn-soft-danger"><i class="dripicons-cross"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div ref="beneficiaryRequestsTableBottom"></div>
                                    <div v-if="inactivenextPageExists" class="mt-4 text-center text-success">
                                        <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                    </div>
                                    <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                </div>
                                <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                    <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                    <div>No Beneficiaries Requests.</div>
                                    <div ref="beneficiaryRequestsTableBottom"></div>
                                </div>
                            </b-tab>
                            <b-tab title="Deactivated ">
                                <div class="mt-5 table-responsive" v-if="deactivepaginatedItems?.length > 0">
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
                                            <tr v-for="(user, index) in deactivepaginatedItems" :key="index">
                                                <th scope="row" :style="{ backgroundColor: '#fff' }">
                                                    <div v-if="user != null">
                                                        <img
                                                            :src="user.profile_photo_url"
                                                            :alt="''"
                                                            class="rounded-circle avatar-xs object-fit-cover"
                                                        />
                                                    </div>
                                                </th>
                                                <td :style="{ backgroundColor: '#fff' }">{{ user.name }}</td>
                                                <td :style="{ backgroundColor: '#fff' }" class="text-center">{{ user.email }}</td>
                                                <td :style="{ backgroundColor: '#fff' }" class="text-center">
                                                    <div v-if="user.user_type == 'ticket_buyer'">
                                                        <span class="badge text-bg-warning">Ticket Buyer</span>
                                                    </div>
                                                    <div v-if="user.user_type == 'beneficiary'">
                                                        <div><span class="badge text-bg-primary">Beneficiary</span></div>
                                                        <div v-if="user.beneficiary_status === 'inactive'">
                                                            <span class="badge badge-soft-danger">Inactive</span>
                                                        </div>
                                                        <div v-if="user.beneficiary_status === 'deactivated'">
                                                            <span class="badge badge-soft-secondary">Deactivated</span>
                                                        </div>
                                                    </div>
                                                    <div v-if="user.user_type == 'admin'"><span class="badge text-bg-indigo">Admin</span></div>
                                                </td>
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
                                                            <div
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                aria-label="View"
                                                                @click="viewUserDetails(user.id)"
                                                            >
                                                                <div class="btn btn-sm btn-soft-primary"><i class="mdi mdi-eye-outline"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div ref="deactivatedTableBottom"></div>
                                    <div v-if="deactivenextPageExists" class="mt-4 text-center text-success">
                                        <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                    </div>
                                    <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                </div>
                                <div v-else class="d-flex flex-column align-items-center" style="padding-top: 9vh; padding-bottom: 30vh">
                                    <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                    <div>No Deactivated beneficiaries.</div>
                                    <div ref="deactivatedTableBottom"></div>
                                </div>
                            </b-tab>
                        </b-tabs>
                    </div>
                </div>
            </div>
            <b-modal
                v-model="state.assignPermissionModal"
                id="assignRolePermission"
                title="Assign Permissions"
                title-class="font-18"
                centered
                hide-footer
            >
                <div class="mt-3 mb-4">
                    <label for="contract_end">User to Assign to:</label>
                    <v-select v-model="state.assignPermissions.user" multiple :label="'name'" :options="props.userNames"></v-select>
                </div>

                <div class="mb-5">
                    <label for="address">Permission:</label>
                    <v-select multiple v-model="state.assignPermissions.permissions" :options="state.activePermissions"></v-select>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    <b-button variant="primary" @click="assignPermission" :disabled="state.assignPermissionsLoader"
                        ><i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="state.assignPermissionsLoader"></i>Assign</b-button
                    >
                </div>
            </b-modal>
        </div>
    </Layout>
</template>
<style lang="css" scoped>
.table-container {
    max-height: 100px;
    overflow-y: scroll;
    scrollbar-width: none;
}

.table-container::-webkit-scrollbar {
    display: none;
}

table {
    width: 100%;
    border-collapse: collapse;
}
</style>
