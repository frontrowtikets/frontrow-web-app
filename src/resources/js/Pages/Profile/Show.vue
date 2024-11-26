<script setup>
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { ref } from "vue";
import InputError from "@/js/Components/InputError.vue";
import Layout from "@/js/Layouts/vertical.vue";
import PageHeader from "@/js/Components/page-header.vue";
import { Head, Link, router, useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    user: Object,
});

//Default Layout
defineOptions({ layout: Layout });

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const confirmingSessionLogout = ref(false);
const updataPasswordInput = ref(null);
const currentPasswordInput = ref(null);
const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const form = useForm({
    password: "",
});

const updataPasswordform = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

// const updateProfileInfomationForm = useForm({
//     _method: "PUT",
//     name: props.user.name,
//     email: props.user.email,
//     photo: null,
// });

//methods
// Confirm Account deletion
function confirmDeleteAccount() {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, delete",
    }).then((result) => {
        if (result.value) {
            confirmingUserDeletion.value = true;
            setTimeout(() => passwordInput.value.focus(), 250);
        }
    });
}

const deleteUser = () => {
    form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onSuccess: () => showSuccessModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const showSuccessModal = () => {
    Swal.fire("Account Deleted!", "Your account has been deleted!", "success");
};

const cancleDeletion = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};

const confirmBrowserSessionLogout = () => {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to logout of other browser sessions, proceed?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, proceed",
    }).then((result) => {
        if (result.value) {
            confirmingSessionLogout.value = true;
            setTimeout(() => passwordInput.value.focus(), 250);
        }
    });
};
const cancleSessionLogout = () => {
    confirmingSessionLogout.value = false;
    form.reset();
};

const logoutOtherBrowserSessions = () => {
    form.delete(route("other-browser-sessions.destroy"), {
        preserveScroll: true,
        onSuccess: () => confirmSessionLogout(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};
const confirmSessionLogout = () => {
    confirmingSessionLogout.value = false;
    form.reset();
    Swal.fire("Logged Out!", "Your have successfully Logged Out of other browsers!", "success");
};
const updatePassword = () => {
    updataPasswordform.put(route("user-password.update"), {
        errorBag: "updatePassword",
        preserveScroll: true,
        onSuccess: () => updataPasswordform.reset(),
        onError: () => {
            if (updataPasswordform.errors.password) {
                updataPasswordform.reset("password", "password_confirmation");
                updataPasswordInput.value.focus();
            }

            if (updataPasswordform.errors.current_password) {
                updataPasswordform.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <Head title="Profile" />

    <PageHeader :title="'My Profile'" :items="items" />
    <div class="column">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="card-title">Profile Information</h4> -->
                    <!-- <p class="card-title-desc">Update your account's profile information and email address.</p> -->
                    <b-tabs>
                        <b-tab active>
                            <template v-slot:title>
                                <span class="d-inline-block d-sm-none">
                                    <i class="far fa-user"></i>
                                </span>
                                <span class="d-none d-sm-inline-block ms-3 me-3">Profile Information</span>
                            </template>
                            <div v-if="$page.props.jetstream.canUpdateProfileInformation" class="mt-5">
                                <UpdateProfileInformationForm :user="$page.props.auth.user" />
                            </div>
                        </b-tab>
                       
                    </b-tabs>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Password</h4>
                    <p class="card-title-desc">Ensure your account is using a long, random password to stay secure.</p>
                    <form>
                        <div class="alert alert-primary" role="alert" v-if="updataPasswordform.processing">Updating...</div>
                        <div class="alert alert-success" v-if="updataPasswordform.recentlySuccessful" role="alert">Your Password has been updated!</div>
                        <div class="col-md-6 mb-4">
                            <label for="current_password">Current Password</label>
                            <b-form-input
                                id="current_password"
                                ref="currentPasswordInput"
                                v-model="updataPasswordform.current_password"
                                type="password"
                                class="mt-1 block w-full"
                                autocomplete="current-password"
                            />
                            <InputError :message="updataPasswordform.errors.current_password" class="mt-2" />
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password">New Password</label>
                            <b-form-input id="password" ref="updataPasswordInput" v-model="updataPasswordform.password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <InputError :message="updataPasswordform.errors.password" class="mt-2" />
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation">Confirm Password</label>
                            <b-form-input id="password_confirmation" v-model="updataPasswordform.password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <InputError :message="updataPasswordform.errors.password_confirmation" class="mt-2" />
                        </div>
                        <b-button variant="primary" @click="updatePassword" :disabled="updataPasswordform.processing">Update</b-button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Browser Sessions</h4>
                    <p class="card-title-desc">Manage and log out your active sessions on other browsers and devices.</p>
                    <div v-if="props.sessions.length > 0" class="space-y-6">
                        <div v-for="(session, i) in props.sessions" :key="i" class="d-flex items-center mb-4 gap-3">
                            <div class="">
                                <i v-if="session.agent.is_desktop" class="fas fa-desktop"></i>

                                <i v-else class="fas fa-tablet-alt"></i>
                            </div>

                            <div class="ml-3">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ session.agent.platform ? session.agent.platform : "Unknown" }} - {{ session.agent.browser ? session.agent.browser : "Unknown" }}
                                </div>

                                <div>
                                    <div class="text-xs text-gray-500">
                                        {{ session.ip_address }},

                                        <span v-if="session.is_current_device" class="text-success font-semibold">This device</span>
                                        <span v-else>Last active {{ session.last_active }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form v-if="confirmingSessionLogout">
                        <div class="mb-4 col-md-6">
                            <b-form-input ref="passwordInput" autocomplete="current-password" id="input-md" v-model="form.password" placeholder="Enter password" type="password"></b-form-input>
                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <b-button variant="primary" @click="logoutOtherBrowserSessions" class="mr-4">Confirm</b-button>
                            <b-button variant="danger" @click="cancleSessionLogout">Cancel</b-button>
                        </div>
                    </form>
                    <b-button v-else variant="primary" @click="confirmBrowserSessionLogout">Log out Other Browser Sessions</b-button>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Delete Account</h4>
                    <p class="card-title-desc col-md-12 col-lg-8">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to
                        retain.
                    </p>
                    <form v-if="confirmingUserDeletion">
                        <div class="mb-4 col-md-6">
                            <b-form-input ref="passwordInput" autocomplete="current-password" id="input-md" v-model="form.password" placeholder="Enter password" type="password"></b-form-input>
                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <b-button variant="danger" @click="deleteUser" class="mr-4">Confirm</b-button>
                            <b-button variant="success" @click="cancleDeletion">Cancel</b-button>
                        </div>
                    </form>
                    <b-button v-else variant="danger" @click="confirmDeleteAccount">Delete Account</b-button>
                </div>
            </div>
        </div>
    </div>

    <!-- <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Profile
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateProfileInformationForm :user="$page.props.auth.user" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <UpdatePasswordForm class="mt-10 sm:mt-0" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                    <TwoFactorAuthenticationForm
                        :requires-confirmation="confirmsTwoFactorAuthentication"
                        class="mt-10 sm:mt-0"
                    />

                    <SectionBorder />
                </div>

                <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0" />

                <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                    <SectionBorder />

                    <DeleteUserForm class="mt-10 sm:mt-0" />
                </template>
            </div>
        </div>
    </AppLayout> -->
</template>
