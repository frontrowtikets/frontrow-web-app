<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import Layout from "@/js/Layouts/auth.vue";
import { onMounted, reactive } from "vue";
import { forIn } from "lodash";

//data
const form = useForm({
    name: "",
    email: "",
    vendor_number: "",
    password: "",
    password_confirmation: "",
    terms: true,
    division: "",
});

//data
const state = reactive({
    slide: 0,
    sliding: null,
});

const coutryOffice = import.meta.env.VITE_COUNTRY_OFFICE;

//methods

//lifecycle
onMounted(() => {});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />

    <Layout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="overflow-hidden card">
                    <div class="bg-soft bg-success">
                        <div class="row">
                            <div class="col-7">
                                <div class="p-4 text-primary">
                                    <h5 class="text-primary">Free Register</h5>
                                    <p>Get your free FRONTROW account now.</p>
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
                                        <img src="@/images/FRONTROWLogo.svg" alt class="rounded-circle" height="65" />
                                    </span>
                                </div>
                            </Link>
                        </div>

                        <div class="mt-4">
                            <form>
                                <div v-if="form.errors.email" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ form.errors.email }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div v-if="form.errors.password" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ form.errors.password }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input style="font-size: 13px" type="text" class="form-control" id="name" placeholder="Name" required v-model="form.name" />
                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.name" />
                                </div>

                                <div class="mb-3">
                                    <label for="email"> Email Address</label>
                                    <input style="font-size: 13px" type="email" class="form-control" id="email" required autocomplete="username" placeholder="Enter email" v-model="form.email" />
                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.email" />
                                </div>



                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input
                                        style="font-size: 13px"
                                        type="password"
                                        class="form-control"
                                        id="password"
                                        placeholder="Enter password"
                                        v-model="form.password"
                                        required
                                        autocomplete="new-password"
                                    />
                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.password" />
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input
                                        style="font-size: 13px"
                                        type="password"
                                        class="form-control"
                                        id="password_confirmation"
                                        v-model="form.password_confirmation"
                                        placeholder="Enter password"
                                        required
                                        autocomplete="new-password"
                                    />
                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.password_confirmation" />
                                </div>

                                <div>
                                    <p class="mb-0">
                                        By registering you agree to the FrontRow
                                        <Link class="text-primary">Terms of Use</Link>
                                    </p>
                                </div>

                                <div class="mt-4 d-grid">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit" @click="submit" :disabled="form.processing">
                                        <i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="form.processing"></i>Register
                                    </button>
                                </div>

                                <div class="mt-5 text-center">
                                    <p>
                                        Already have an account ?
                                        <Link :href="route('login')" class="fw-medium text-primary">Login</Link>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="mt-5 text-center">
                    <p>© {{ new Date().getFullYear() }} FRONTROW. Developed by the CinemaUg</p>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </Layout>
</template>
