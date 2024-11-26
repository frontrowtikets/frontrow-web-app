<script setup>
import Layout from "@/js/Layouts/auth.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { onMounted, reactive, onBeforeMount, ref } from "vue";
import InputError from "@/js/Components/InputError.vue";
import { computed } from "vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    canResetPassword: Boolean,
    status: String,
});

//data
const state = reactive({
    slide: 0,
    sliding: null,
    accountActive: false,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

//methods

onMounted(() => {});
//submiting login credentials
const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => {
            form.reset("password");
            //getting account status
            const requestParams = new URLSearchParams(window.location.search);
            const isAccountActive = requestParams.get("accountActive");
            state.accountActive = isAccountActive;
        },
    });
};
</script>

<template>
    <Head title="Login" />

    <Layout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="overflow-hidden card">
                    <div class="bg-soft bg-success">
                        <div class="row">
                            <div class="col-7">
                                <div class="p-4 text-primary">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>Sign in to continue to FRONTROW.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="@/images/profile-img.png" alt class="img-fluid" />
                            </div>
                        </div>
                    </div>
                    <div class="pt-0 card-body">
                        <div>
                            <Link :href="route('landing')">
                                <div class="mb-4 avatar-md profile-user-wid">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="@/images/FRONTROWLogo.svg" alt height="65" />
                                    </span>
                                </div>
                            </Link>
                        </div>

                        <div class="mt-4">
                            <form @submit.prevent="submit">
                                <div v-if="form.errors.email" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ form.errors.email }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div v-if="form.errors.password" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ form.errors.password }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input
                                        style="font-size: 13px"
                                        class="form-control"
                                        id="email"
                                        type="email"
                                        autocomplete="username"
                                        v-model="form.email"
                                        required
                                        autofocus
                                        placeholder="Enter email"
                                    />
                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.email" />
                                </div>

                                <div class="mb-3">
                                    <div class="float-end">
                                        <Link :href="route('password.request')" class="text-muted"> <i class="mr-1 mdi mdi-lock"></i> Forgot your password? </Link>
                                    </div>
                                    <label for="userpassword">Password</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="userpassword"
                                        autocomplete="current-password"
                                        v-model="form.password"
                                        required
                                        placeholder="Enter password"
                                        style="font-size: 13px"
                                    />
                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.password" />
                                </div>

                                <b-form-checkbox id="customControlInline" name="remember" value="accepted" v-model:checked="form.remember" unchecked-value="not_accepted">
                                    Remember me
                                </b-form-checkbox>
                                <div class="mt-3 d-grid">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit" :disabled="form.processing">
                                        <i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="form.processing"></i>Log In
                                    </button>
                                </div>
                            </form>
                            <div class="mt-5 text-center">
                                <p>
                                    Don't have an account ?
                                    <Link :href="route('register')" class="fw-medium text-primary">Signup now </Link>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="mt-5 text-center">
                    <p>© {{ new Date().getFullYear() }} FRONTROW. CinemaUg</p>
                </div>
                <!-- end row -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </Layout>
</template>
