<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import Layout from "@/js/Layouts/auth.vue";
import { onMounted, reactive, ref, computed } from "vue";
import { VueTelInput } from "vue3-tel-input";
import "vue3-tel-input/dist/vue3-tel-input.css";

//data
const isPhoneNumberValid = ref(false);
const invalidPhoneNumberMsg = ref("");
const userPhoneNumber = ref("");

const form = useForm({
    name: "",
    email: "",
    asEventsManager: true,
    password: "",
    phone_number: "",
    password_confirmation: "",
    terms: true,
});

//data
const state = reactive({
    slide: 0,
    sliding: null,
});

//methods

//lifecycle
onMounted(() => {});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
        onError: (err) => console.log(err),
    });
};
function backHome() {
    router.visit("/");
}

function phoneNumber(val, phoneObj) {
    form.phone_number = phoneObj["number"];
    isPhoneNumberValid.value = phoneObj.valid;
}
function checkValidity() {
    if (isPhoneNumberValid.value === false || typeof isPhoneNumberValid.value == "undefined") {
        invalidPhoneNumberMsg.value = "Phone Number is Invalid";
    } else {
        invalidPhoneNumberMsg.value = "";
    }
}
function registerAsEventsManager(val){
form['asEventsManager'] = val
}
</script>

<template>
    <Head title="Register" />

    <Layout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="overflow-hidden card" style="position: relative">
                    <div class="bg-soft bg-primary">
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
                    <div style="position: absolute; right: 0; top: 17%">
                        <!-- <button @click="backHome" class="backhome">
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

                        <div class="mt-4">
                            <div><label>Register As</label></div>
                            <div>
                                <b-tabs pills justified content-class="p-3 text-muted">
                                    <b-tab active @click="registerAsEventsManager(true)">
                                        <template v-slot:title>
                                            <span class="d-inline-block d-sm-none">
                                                <i class="far fa-user"></i>
                                            </span>
                                            <span class="d-none d-sm-inline-block">Events Manager</span>
                                        </template>
                                        {{ content }}
                                    </b-tab>
                                    <b-tab  class="border-0" @click="registerAsEventsManager(false)">
                                        <template v-slot:title>
                                            <span class="d-inline-block d-sm-none">
                                                <i class="fas fa-home"></i>
                                            </span>
                                            <span class="d-none d-sm-inline-block">Ticket Buyer</span>
                                        </template>
                                        {{ text }}
                                    </b-tab>

                                </b-tabs>
                            </div>
                            <form>
                                <div v-if="form.errors.email" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ form.errors.email }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div v-if="form.errors.password" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ form.errors.password }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div v-if="form.errors.phone_number" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ form.errors.phone_number }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div v-if="invalidPhoneNumberMsg" class="mt-4 mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ invalidPhoneNumberMsg }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="mb-3">
                                    <label for="name">Full Name</label>
                                    <input
                                        style="font-size: 13px"
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        placeholder="Name"
                                        required
                                        v-model="form.name"
                                    />
                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.name" />
                                </div>

                                <div class="mb-3">
                                    <label for="email"> Email Address</label>
                                    <input
                                        style="font-size: 13px"
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        required
                                        autocomplete="username"
                                        placeholder="Enter email"
                                        v-model="form.email"
                                    />
                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.email" />
                                </div>

                                <div class="mb-3">
                                    <label for="phone_number"> Phone Number</label>
                                    <VueTelInput
                                        class="form-control"
                                        :inputOptions.required="true"
                                        :inputOptions.showDialCode="true"
                                        :rules="[isValidPhone]"
                                        v-model="form.phone_number"
                                        @input="phoneNumber"
                                        @change="phoneNumber"
                                        @blur="checkValidity"
                                    />
                                    <!-- <input style="font-size: 13px" type="text" class="form-control" id="phone_number" required placeholder="Phone NO." v-model="form.phone_number" />-->
                                    <small class="text-danger" v-if="invalidPhoneNumberMsg">{{ invalidPhoneNumberMsg }}</small>
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
                                <div class="mb-4">
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
                                <!-- <div class="">
                                    <div class="mb-3 form-check form-check-left">
                                        <input class="form-check-input" type="checkbox" id="formCheckRight1" v-model="form.asEventsManager" />
                                        <label class="form-check-label" for="formCheckRight1"> Register as Events Manager </label>
                                    </div>
                                </div> -->
                                <!-- <div>
                                    <b-form-checkbox id="customControlInline" name="remember" value="true" v-model="registerAsEventsManager" unchecked-value="false">
                                        Signup as Events Manager
                                    </b-form-checkbox>
                                </div> -->

                                <div class="mt-5 d-grid">
                                    <button
                                        class="btn btn-primary btn-block waves-effect waves-light"
                                        type="submit"
                                        @click="submit"
                                        :disabled="form.processing"
                                    >
                                        <i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="form.processing"></i
                                        ><span>Register</span>
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
