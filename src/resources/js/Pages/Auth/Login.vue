<script setup>
import Layout from "@/js/Layouts/auth.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
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
            // const requestParams = new URLSearchParams(window.location.search);
            // const isAccountActive = requestParams.get("accountActive");
            // state.accountActive = isAccountActive;
        },
    });
};

function backHome(){
     router.visit("/");
}
</script>

<template>
    <Head title="Login" />

    <Layout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="overflow-hidden card" style="position: relative">
                    <div class="bg-soft bg-primary">
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
                    <div style="position: absolute; right: 0; top: 25%">

                        <!-- <button @click="backHome">
                            <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
                                <path
                                    d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z"
                                ></path>
                            </svg>
                            <span>Home</span>
                        </button> -->
                        <div @click="backHome" class="p-2" role="button">Home</div>

                    </div>
                    <div class="pt-0 card-body">
                        <div calss="">
                            <div>
                                <Link :href="route('landing')">
                                    <div class="mb-4 avatar-md profile-user-wid">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <!-- <img src="@/images/FRONTROWLogo.svg" alt height="65" /> -->
                                        </span>
                                    </div>
                                </Link>
                            </div>
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
<style scopped>
/* button {
    display: flex;
    height: 3em;
    width: 100px;
    align-items: center;
    justify-content: center;
    background-color: #eeeeee4b;
    border-radius: 3px;
    letter-spacing: 1px;
    transition: all 0.2s linear;
    cursor: pointer;
    border: none;
    background: #fff;
}

button > svg {
    margin-right: 5px;
    margin-left: 5px;
    font-size: 20px;
    transition: all 0.4s ease-in;
}

button:hover > svg {
    font-size: 1.2em;
    transform: translateX(-5px);
}

button:hover {
    box-shadow: 9px 9px 33px #d1d1d1, -9px -9px 33px #ffffff;
    transform: translateY(-2px);
} */
</style>
