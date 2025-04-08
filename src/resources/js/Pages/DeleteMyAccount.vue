<script setup>
import { Head, router } from "@inertiajs/vue3";
import FooterSection from "@/js/Components/FooterSection.vue";
import HomeHeader from "../Components/HomeHeader.vue";
import axios from 'axios';
import Swal from 'sweetalert2';
import { ref,onMounted } from 'vue';

defineProps({
    policy: String,
});

const email = ref('');
const reason = ref('');
const details = ref('');
const isLoading = ref(false);

onMounted(()=>{
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
})

function toPrivacyPolicy() {
    router.visit("/privacy-policy");
}

function toTermsAndConditions() {
    router.visit("/terms-and-conditions");
}

async function handleSubmit(event) {
    event.preventDefault();
    if (!email.value || !reason.value || (reason.value === 'other' && !details.value)) {
        Swal.fire('Error', 'Please fill in all required fields', 'error');
        return;
    }

    isLoading.value = true;
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete your account. This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete my account',
        cancelButtonText: 'No, cancel',
        reverseButtons: true
    }).then(async (result) => {
        if (result.isConfirmed) {
            // loading Swal 
            Swal.fire({
                title: 'Processing',
                text: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
            try {
                const response = await axios.post('delete-my-account', {
                    email: email.value,
                    reason: reason.value,
                    details: details.value
                });
                // close Swal
                Swal.close();
                Swal.fire('Success', response.data.message, 'success');
            } catch (error) {
                // close Swal
                Swal.close();
                Swal.fire('Error', error.response.data.message || 'Something went wrong', 'error');
            } finally {
                isLoading.value = false;
            }
        } else {
            isLoading.value = false;
        }
    });
}
</script>

<template>
    <section>
        <b-container class="" style="margin-top: 16em">

            <Head title="FrontRow - Privacy Policy" />
            <HomeHeader />
            <div class="container mt-5">
                <div class="card shadow">
                    <div class="card-header text-center text-danger">
                        <h4>Delete My Account</h4>
                    </div>
                    <div class="card-body">
                        <p>Are you sure you want to delete your account?</p>
                        <p class="fw-bold">Please note:</p>
                        <ul>
                            <li>Your request will be reviewed and all your data will be deleted within <strong>7-14
                                    business days</strong></li>
                            <li>During this time, you won't be able to log in</li>
                            <li>This action <strong>cannot be undone</strong></li>
                            <li>For more details, see our <a href="javascript:void()" @click="toTermsAndConditions"
                                    class="text-info">Terms & Conditions</a>
                                and <a href="javascript:void()" @click="toPrivacyPolicy" class="text-info">Privacy
                                    Policy</a></li>
                        </ul>
                        <form id="deleteAccountForm" @submit="handleSubmit">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control w-50" id="email" v-model="email"
                                    placeholder="Enter your email" autocomplete="off" :disabled="isLoading" required>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Deletion</label>
                                <select class="form-select w-50" id="reason" v-model="reason" :disabled="isLoading"
                                    required>
                                    <option value="" disabled selected>Select a reason</option>
                                    <option value="no-longer-using">No longer using the service</option>
                                    <option value="privacy">Privacy concerns</option>
                                    <option value="new-account">Created a new account</option>
                                    <option value="not-satisfied">Not satisfied with the service</option>
                                    <option value="technical-issues">Technical issues</option>
                                    <option value="better-alternative">Found a better alternative</option>
                                    <option value="personal-reasons">Personal reasons</option>
                                    <option value="other">Other (please specify in Additional Details)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">Additional Details (Optional)</label>
                                <textarea class="form-control w-50" id="details" v-model="details" rows="3"
                                    :disabled="isLoading" placeholder="Provide more details..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-danger" :disabled="isLoading">
                                <span v-if="isLoading">Deleting...</span>
                                <span v-else>Delete Account</span>
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </b-container>
        <FooterSection />
    </section>
</template>