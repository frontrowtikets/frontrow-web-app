<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { onMounted, reactive, computed } from "vue";

const props = defineProps({
    status: String,
});

const form = useForm({});

//data
const state = reactive({
    slide: 0,
    sliding: null,
});

const coutryOffice = import.meta.env.VITE_COUNTRY_OFFICE;

const verificationLinkSent = computed(() => props.status === "verification-link-sent");
//lifecycle
onMounted(() => {});

const submit = () => {
    form.post(route("verification.send"));
};
</script>

<template>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5 text-muted">
                        <Link :href="route('landing')" class="d-block auth-logo">
                            <img src="@/images/FRONTROWLogo.svg" alt height="65" />
                        </Link>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-2">
                                <div class="text-center">
                                    <div class="avatar-md mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="bx bxs-envelope h1 mb-0 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <h4>Verify your email</h4>

                                        <p v-if="verificationLinkSent" variant="success" class="mt-3" dismissible>
                                            A new verification link has been sent to the email address you provided in your profile settings.
                                        </p>
                                        <p v-else>
                                            We have sent you a verification email
                                            <span class="fw-semibold">{{ usePage().props.auth.user.email }}</span
                                            >, Please check it
                                        </p>

                                        <form @submit.prevent="submit">
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-success w-md" :disabled="form.processing">Resend Verification Email</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>© {{ new Date().getFullYear() }} FRONTROW. The FRONTROW Group</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
