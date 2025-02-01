<script setup>
import Layout from "@/js/Layouts/auth.vue";

import { Head, Link, useForm, router } from "@inertiajs/vue3";
import { onMounted } from "vue";

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

//lifecycle
onMounted(() => {});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <Layout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="overflow-hidden card">
                    <div class="bg-soft bg-success">
                        <div class="row">
                            <div class="col-7">
                                <div class="p-4 text-primary">
                                    <h5 class="text-primary">Reset Password</h5>
                                    <p>Re-Password with FRONTROW.</p>
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
                                        <img
                                            src="@/images/logos/small2.png"
                                            class="avatar-title rounded-circle"
                                            style="background-color: #ffffff"
                                            alt
                                            height="70"
                                        />
                                    </span>
                                </div>
                            </Link>
                        </div>

                        <div class="p-2">
                            <div class="mt-4">
                                <div v-if="form.wasSuccessful" class="mb-4 text-center alert alert-success" role="alert">Check your email for the password reset link!</div>
                                <div v-else class="mb-4 text-center alert alert-success" role="alert">Enter your Email and instructions will be sent to you!</div>

                                <form @submit.prevent="submit">
                                    <div class="mb-3">
                                        <label for="useremail">Email</label>
                                        <input style="font-size: 13px" type="email" class="form-control" id="useremail" placeholder="Enter email" v-model="form.email" />
                                        <InputError class="mt-2 mb-4 text-danger" :message="form.errors.email" />
                                    </div>

                                    <div class="mb-0 form-group row">
                                        <div v-if="form.recentlySuccessful" class="mb-4 text-center alert alert-success" role="alert">Reset Email has been sent.</div>

                                        <div class="col-12 text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit" :disabled="form.processing">
                                                <i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="form.processing"></i>Reset
                                            </button>
                                        </div>
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
                    <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="mt-5 text-center">
                    <p>© {{ new Date().getFullYear() }} FRONTROW. The FRONTROW Group</p>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </Layout>
</template>

<style lang="scss" module></style>
