<script setup>
import profileImg from "@/images/profile-img.png";
import logo from "@/images/FRONTROWLogo.svg";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import InputError from "@/js/Components/InputError.vue";
import { onMounted } from "vue";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

//lifecycle
onMounted(() => {});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft bg-success">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Reset Password</h5>
                                        <p>Re-Password with FRONTROW.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img :src="profileImg" alt class="img-fluid" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <Link :href="route('landing')">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img :src="logo" alt height="65" />
                                        </span>
                                    </div>
                                </Link>
                            </div>
                            <div class="p-2">
                                <div class="w-100">
                                    <div class="d-flex flex-column h-100">
                                        <div class="my-auto">
                                            <div>
                                                <h5 class="text-primary">Reset Password</h5>
                                                <p>Enter your new credentials!</p>
                                            </div>

                                            <div class="mt-4">
                                                <form @submit.prevent="submit">
                                                    <slot />
                                                    <div class="mb-3">
                                                        <label for="email">Email</label>
                                                        <input
                                                            style="font-size: 13px"
                                                            type="email"
                                                            name="email"
                                                            v-model="form.email"
                                                            class="form-control"
                                                            id="email"
                                                            placeholder="Enter email"
                                                            autocomplete="username"
                                                        />
                                                        <InputError class="mt-2 text-danger" :message="form.errors.email" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password">Password</label>
                                                        <input
                                                            style="font-size: 13px"
                                                            name="email"
                                                            v-model="form.password"
                                                            class="form-control"
                                                            id="password"
                                                            type="password"
                                                            required
                                                            autofocus
                                                            autocomplete="new-password"
                                                        />
                                                        <InputError class="mt-2 text-danger" :message="form.errors.password" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password_confirmation">Confirm Password</label>
                                                        <input
                                                            style="font-size: 13px"
                                                            name="email"
                                                            v-model="form.password_confirmation"
                                                            class="form-control"
                                                            id="password_confirmation"
                                                            type="password"
                                                            required
                                                            autocomplete="new-password"
                                                        />
                                                        <InputError class="mt-2 text-danger" :message="form.errors.password_confirmation" />
                                                    </div>
                                                    <div class="col-12 text-end">
                                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit" :disabled="form.processing">
                                                            <i class="bx bx-loader bx-spin font-size-16 align-middle me-2" v-if="form.processing"></i
                                                            >{{ form.processing ? "Please wait" : "Reset Password" }}
                                                        </button>
                                                    </div>
                                                </form>
                                                <div class="mt-5 text-center">
                                                    <p>
                                                        Remember It ?
                                                        <Link :href="route('login')" class="fw-medium text-primary"> Sign In here </Link>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-5 text-center">
                        <p>© {{ new Date().getFullYear() }} FRONTROW. The FRONTROW Group</p>
                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>
</template>
