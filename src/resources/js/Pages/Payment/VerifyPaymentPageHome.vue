<script setup>
import { Head, router } from "@inertiajs/vue3";
import { reactive, onMounted, ref, computed, onUnmounted } from "vue";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import HomeHeader from "@/js/Components/HomeHeader.vue";
import FooterSection from "@/js/Components/FooterSection.vue";
import { useStore } from "vuex";

const props = defineProps(["OrderTrackingId", "OrderNotificationType", "OrderMerchantReference"]);

const state = reactive({
    items: [
        {
            text: "Dashboard",
            href: "javascript:void(0)",
        },
        {
            text: "Complete Payment",
            active: true,
        },
    ],
});

const isLoading = ref(true);
const errorMessage = ref("");
const paymentStatusdetails = ref(null);
const paymentDetails = ref(null);

onMounted(() => {
    //verify Payment
    const store = useStore();
    // paymentDetails.value = store.getters["PaymentDetails/getPaymentDetails"];
    const details = localStorage.getItem("paymentDetails");
    paymentDetails.value = details ? JSON.parse(details) : null;

    const paymentStatus = getPaymentStatus();
    if (paymentStatus) {
        paymentStatusdetails.value = paymentStatus;
    } else {
        errorMessage.value = "Something Went Wrong, Please try again.";
    }
    isLoading.value = false;
});
onUnmounted(() => {
    localStorage.removeItem("paymentDetails");
});

const isPaymentSuccessfull = computed(() => {
    if (paymentStatusdetails) {
        if (paymentStatusdetails.value.status_code === 1) {
            return true;
        } else {
            return false;
        }
    }
});
async function getPaymentStatus() {
    await axios
        .post(
            "/api/v1/payments/getStatus",
            {
                orderTrackingId: props.OrderTrackingId,
                username: `${paymentDetails.value.first_name} ${paymentDetails.value.last_name}`,
                userEmail: paymentDetails.value.email,
                phone: paymentDetails.value.phone,
                purpose: paymentDetails.value.ticketType,
                selectedTicket: paymentDetails.value.selectedTicket,
            },
            {
                headers: {
                    Accept: "application/json",
                },
            }
        )
        .then((res) => {
            if (res.success) {
                return res.data;
            } else {
                return null;
            }
        })

        .catch((err) => {
            errorMessage.value = "Something Went Wrong, Please try again.";
            return null;
        });
}
function returnHome() {
    router.visit("/");
}
</script>

<template>
    <b-container class="mt-5">
        <HomeHeader />

        <div style="margin-top: 22vh; margin-bottom: 10vh">
            <div class="col-12">
                <div v-if="isLoading" class="mt-5 d-flex align-items-center justify-content-center" style="height: 50vh">
                    <div><i class="bx bx-hourglass bx-spin me-2"></i> Please wait ...</div>
                </div>
                <div v-else class="mt-5 d-flex align-items-center justify-content-center" style="height: 50vh">
                    <div class="d-flex align-items-center justify-content-center vh-100">
                        <div class="card" style="width: 24rem">
                            <div class="card-body">
                                <div v-if="isPaymentSuccessfull">
                                    <div class="mb-4 d-flex align-items-center justify-content-center">
                                        <div>
                                            <svg
                                                width="30px"
                                                height="30px"
                                                viewBox="-2.4 -2.4 28.80 28.80"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                stroke="#1ae031"
                                                transform="matrix(1, 0, 0, 1, 0, 0)"
                                            >
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g
                                                    id="SVGRepo_tracerCarrier"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke="#CCCCCC"
                                                    stroke-width="0.24000000000000005"
                                                ></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <rect width="24" height="24" fill="white"></rect>
                                                    <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M9.55879 3.6972C10.7552 2.02216 13.2447 2.02216 14.4412 3.6972L14.6317 3.96387C14.8422 4.25867 15.1958 4.41652 15.5558 4.37652L16.4048 4.28218C18.3156 4.06988 19.9301 5.68439 19.7178 7.59513L19.6235 8.44415C19.5835 8.8042 19.7413 9.15774 20.0361 9.36831L20.3028 9.55879C21.9778 10.7552 21.9778 13.2447 20.3028 14.4412L20.0361 14.6317C19.7413 14.8422 19.5835 15.1958 19.6235 15.5558L19.7178 16.4048C19.9301 18.3156 18.3156 19.9301 16.4048 19.7178L15.5558 19.6235C15.1958 19.5835 14.8422 19.7413 14.6317 20.0361L14.4412 20.3028C13.2447 21.9778 10.7553 21.9778 9.55879 20.3028L9.36831 20.0361C9.15774 19.7413 8.8042 19.5835 8.44414 19.6235L7.59513 19.7178C5.68439 19.9301 4.06988 18.3156 4.28218 16.4048L4.37652 15.5558C4.41652 15.1958 4.25867 14.8422 3.96387 14.6317L3.6972 14.4412C2.02216 13.2447 2.02216 10.7553 3.6972 9.55879L3.96387 9.36831C4.25867 9.15774 4.41652 8.8042 4.37652 8.44414L4.28218 7.59513C4.06988 5.68439 5.68439 4.06988 7.59513 4.28218L8.44415 4.37652C8.8042 4.41652 9.15774 4.25867 9.36831 3.96387L9.55879 3.6972ZM15.7071 9.29289C16.0976 9.68342 16.0976 10.3166 15.7071 10.7071L11.8882 14.526C11.3977 15.0166 10.6023 15.0166 10.1118 14.526L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929C8.68342 10.9024 9.31658 10.9024 9.70711 11.2929L11 12.5858L14.2929 9.29289C14.6834 8.90237 15.3166 8.90237 15.7071 9.29289Z"
                                                        fill="#1ae031"
                                                    ></path>
                                                </g>
                                            </svg>
                                        </div>
                                        <span class="ms-2 fw-bold" style="font-size: medium; color: #1ae031">Payment Successful</span>
                                    </div>

                                    <div class="flex mb-3 text-center d-flex-column">
                                        <div class="mb-4 mt-4">
                                            <label>{{ paymentStatusdetails.description }}</label>
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="mb-4 d-flex align-items-center justify-content-center">
                                        <div>
                                            <svg
                                                width="50px"
                                                height="50px"
                                                viewBox="0 0 1024 1024"
                                                class="icon"
                                                version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="#000000"
                                            >
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M512 128C300.8 128 128 300.8 128 512s172.8 384 384 384 384-172.8 384-384S723.2 128 512 128z m0 85.333333c66.133333 0 128 23.466667 179.2 59.733334L273.066667 691.2C236.8 640 213.333333 578.133333 213.333333 512c0-164.266667 134.4-298.666667 298.666667-298.666667z m0 597.333334c-66.133333 0-128-23.466667-179.2-59.733334l418.133333-418.133333C787.2 384 810.666667 445.866667 810.666667 512c0 164.266667-134.4 298.666667-298.666667 298.666667z"
                                                        fill="#D50000"
                                                    ></path>
                                                </g>
                                            </svg>
                                        </div>
                                        <span class="ms-2 fw-bold" style="font-size: medium; color: #d50000">Payment Failed</span>
                                    </div>

                                    <div class="flex mb-3 text-center d-flex-column">
                                        <div class="mb-4 mt-4">
                                            <label>{{ paymentStatusdetails.description }} This i ss comlese</label>
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary" @click="returnHome">Return to Home</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </b-container>
    <FooterSection />
</template>
