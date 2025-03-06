<script setup>
import mtnLogo from "../../images/mtnMobileMoney.png";
import airtelMoney from "../../images/airtelMoney.png";
import creditCard from "../../images/creditCard.svg";
import useCurrencyFormat from "../Composables/useCurrencyFormat.js";
import useInertiaFormSubmit from "@/js/Composables/useInertiaFormSubmit.js";

import { ref, computed, onMounted } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import axios from "axios";
import { useStore } from "vuex";

const props = defineProps(["selectedTickets", "quantity", "myWallet"]);
const store = useStore();
const paymentMethod = ref("mtn");
const buyerName = ref("");
const buyerLastName = ref("");
const buyerEmail = ref("");
const cardNumber = ref("");
const expiryDate = ref("");
const userPhoneNumber = ref("");
const cvv = ref("");
const isPhoneNumberValid = ref(true);
const invalidPhoneNumberMsg = ref("");

const responseError = ref("");

const paymentRedirectURL = ref(null);
const showPaymentPage = ref(false);

const isProcessing = ref(false);
const isProcessingWallet = ref(false);

onMounted(() => {
    if (usePage().props.auth.user != null) {
        buyerEmail.value = usePage().props.auth.user.email;
    }
});

const totalAmount = computed(() => {
    const tickets = props.selectedTickets;
    let total = 0;
    tickets.forEach((ticket) => {
        total += Number(ticket.price * ticket.selectedQuantity);
    });
    return total;
});

const checkoutDisabled = computed(() => {
    if (
        buyerEmail.value &&
        buyerName.value &&
        userPhoneNumber.value &&
        isPhoneNumberValid.value
    ) {
        return false;
    } else {
        return true;
    }
});

// const paymentDetailsCleaned = computed(() => {
//     const cleaned = {
//         name: buyerName.value,
//         email: buyerEmail.value,
//         phoneNumber: userPhoneNumber.value,
//         paymentType: paymentMethod.value,
//         cardNumber: cardNumber.value,
//         expiryDate: expiryDate.value,
//         cvv: cvv.value,
//         selectedTicket: props.selectedTickets,
//         amount: totalAmount.value,
//         quantity: props.quantity,
//     };

//     return cleaned;
// });
const paymentDetailsCleaned = computed(() => {
    const cleaned = {
        first_name: buyerName.value,
        last_name: buyerLastName.value,
        email: buyerEmail.value,
        phone: userPhoneNumber.value,
        paymentType: paymentMethod.value,
        cardNumber: cardNumber.value,
        expiryDate: expiryDate.value,
        cvv: cvv.value,
        selectedTicket: props.selectedTickets,
        amount: totalAmount.value,
        quantity: props.quantity,
        description: "Ticket Payment",
    };

    return cleaned;
});
function phoneNumber(val, phoneObj) {
    userPhoneNumber.value = phoneObj["number"];
    isPhoneNumberValid.value = phoneObj.valid;
}
function checkValidity() {
    if (
        isPhoneNumberValid.value === false ||
        typeof isPhoneNumberValid.value == "undefined"
    ) {
        invalidPhoneNumberMsg.value = "Phone Number is Invalid";
    } else {
        invalidPhoneNumberMsg.value = "";
    }
}

async function payTicket() {
    isProcessing.value = true;
    //store.commit("PaymentDetails/savePaymentDetails", {...paymentDetailsCleaned.value,ticketType:"event"});
    const details = { ...paymentDetailsCleaned.value, ticketType: "event" };
    localStorage.setItem("paymentDetails", JSON.stringify(details));
    await axios
        .post("/api/v1/payments/makepayment", paymentDetailsCleaned.value, {
            headers: {
                Accept: "application/json",
            },
        })
        .then((res) => {
            if (res.status == 200) {
                paymentRedirectURL.value = res.data;
            }
            // if (usePage().props.auth.user) {
            //     router.visit("/mytickets");
            // } else {
            //     isProcessing.value = false;

            //     Swal.fire({
            //         title: "Confirm Payment",
            //         icon: "info",
            //         html: `<p style="font-size: 14px">To complete your payment, please enter your mobile money PIN from the prompt on your phone. This ensures your transaction is  processed successfully.</p>`,
            //         showCloseButton: false,
            //         showCancelButton: false,
            //         focusConfirm: true,
            //         confirmButtonText: "Okay",
            //         confirmButtonColor: "#43ad60",
            //         allowOutsideClick: false,
            //         allowEscapeKey: false,
            //         closeOnClickOutside: false,
            //     }).then((result) => {
            //         router.visit("/login");
            //     });
            // }
        })
        .then(() => {
            if (paymentRedirectURL.value) {
                showPaymentPage.value = true;
            } else {
                responseError.value = "Oops!,Please try again";
                isProcessing.value = false;
            }
        })
        .catch((err) => {
            responseError.value = err;
            isProcessing.value = false;
        });
}

function payTicketWithWallet() {
    isProcessingWallet.value = true;
     useInertiaFormSubmit(
        {
            ...paymentDetailsCleaned.value
        },
        "/payEvent/wallet",
        "/mytickets",
        "You are make a payment using your wallet balance",
        "Payment Successful"
    );
}
</script>

<template>
    <div v-if="showPaymentPage" class="container">
        <div class="payment-container">
            <iframe
                id="payment_page"
                ref="paymentPageIframe"
                :src="paymentRedirectURL"
                style="width: 100%; height: 100%"
            ></iframe>
        </div>
    </div>
    <div
        v-else
        class="pt-4 flex-column justify-content-center d-flex flex-md-row col-12"
    >
        <div class="mb-4 col-12 col-md-5 flex-column pe-md-5">
            <div class="shadow-lg card w-100">
                <div class="card-body">
                    <h5 class="mb-4 card-title">Your Order</h5>

                    <div class="mt-4 text-start">
                        <div
                            v-for="(item, index) in props.selectedTickets"
                            :key="`${item.id}_${index}`"
                            class="pt-2 pb-2 mb-4 border-top border-bottom"
                        >
                            <div class="mb-2">
                                <span class="fw-bold me-3">Category:</span
                                >{{ item?.category }}
                            </div>
                            <div class="">
                                <span class="fw-bold me-3">Price:</span
                                >{{ item?.currency }} {{ item.price }} X
                                {{ item.selectedQuantity }}
                            </div>
                        </div>

                        <div class="mb-4 text-end">
                            <div class="mb-2 fw-bold me-3">Total</div>
                            <div>
                                <h4>
                                    {{
                                        props.selectedTickets[0].currency ||
                                        "UGX"
                                    }}
                                    {{ useCurrencyFormat(totalAmount) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5" id="eventsdetailsfrom">
            <div class="modalCheckout2">
                <form class="form">
                    <!-- <div
                        class="gap-5 d-flex justify-content-center payment--options"
                    >
                        <button
                            name="apple-pay"
                            type="button"
                            @click="paymentMethod = 'mtn'"
                            :style="{
                                backgroundColor:
                                    paymentMethod === 'mtn' ? '#aaf3f7' : '',
                            }"
                        >
                            <img :src="mtnLogo" height="50" width="50" />
                        </button>
                        <button
                            name="google-pay"
                            type="button"
                            @click="paymentMethod = 'airtel'"
                            :style="{
                                backgroundColor:
                                    paymentMethod === 'airtel' ? '#aaf3f7' : '',
                            }"
                        >
                            <img :src="airtelMoney" height="50" width="50" />
                        </button>
                        <button
                            name="paypal"
                            type="button"
                            @click="paymentMethod = 'card'"
                        >
                            <img :src="creditCard" height="40" />
                        </button>
                    </div> -->
                    <div
                        v-if="responseError"
                        class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                        role="alert"
                    >
                        {{ responseError.slice(0, 50) }}
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="separator">
                        <hr class="line" />
                        <p>Payment Details</p>
                        <hr class="line" />
                    </div>
                    <div class="" v-if="paymentMethod == 'card'">
                        <div class="mb-4 credit-card-info--form">
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Card holder full name</label
                                >
                                <input
                                    id="password_field"
                                    class="input_field"
                                    type="text"
                                    name="input-name"
                                    title="Enter Card Holder Name"
                                    placeholder="Enter your full name"
                                    v-model="buyerName"
                                />
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Email Address</label
                                >
                                <input
                                    id="password_field"
                                    class="input_field"
                                    type="email"
                                    name="input-name"
                                    title="Enter Email Address"
                                    placeholder="Enter Email Address"
                                    v-model="buyerEmail"
                                />
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Phone Number</label
                                >
                                <VueTelInput
                                    class="input_field"
                                    :inputOptions.required="true"
                                    :inputOptions.showDialCode="true"
                                    :rules="[isValidPhone]"
                                    v-model="userPhoneNumber"
                                    @input="phoneNumber"
                                    @change="phoneNumber"
                                    @blur="checkValidity"
                                />
                                <small
                                    class="text-danger"
                                    v-if="invalidPhoneNumberMsg"
                                    >{{ invalidPhoneNumberMsg }}</small
                                >
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Card Number</label
                                >
                                <input
                                    id="password_field"
                                    class="input_field"
                                    type="number"
                                    name="input-name"
                                    title="Enter Card Number"
                                    v-maska="'#### #### #### ####'"
                                    placeholder="0000 0000 0000 0000"
                                    v-model="cardNumber"
                                />
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Expiry Date / CVV</label
                                >
                                <div class="split">
                                    <input
                                        id="password_field"
                                        class="input_field"
                                        type="text"
                                        name="input-name"
                                        title="Expiry Date"
                                        v-maska="'##/##'"
                                        placeholder="01/25"
                                        v-model="expiryDate"
                                    />
                                    <input
                                        id="password_field"
                                        class="input_field"
                                        type="number"
                                        name="cvv"
                                        title="CVV"
                                        placeholder="CVV"
                                        v-model="cvv"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" v-else-if="paymentMethod == 'mtn'">
                        <div class="mb-4 credit-card-info--form">
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >First name</label
                                >
                                <input
                                    id="password_field"
                                    class="input_field"
                                    type="text"
                                    name="input-name"
                                    title="Enter Card Holder Name"
                                    placeholder="Enter your first name"
                                    v-model="buyerName"
                                />
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Last name</label
                                >
                                <input
                                    id="password_field"
                                    class="input_field"
                                    type="text"
                                    name="input-name"
                                    title="Enter Card Holder Name"
                                    placeholder="Enter your last name"
                                    v-model="buyerLastName"
                                />
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Email</label
                                >
                                <div class="split">
                                    <input
                                        id="password_field"
                                        class="input_field"
                                        type="email"
                                        name="input-name"
                                        title="Email"
                                        placeholder="Email"
                                        v-model="buyerEmail"
                                    />
                                </div>
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Phone Number</label
                                >
                                <VueTelInput
                                    class="input_field"
                                    :inputOptions.required="true"
                                    :inputOptions.showDialCode="true"
                                    :rules="[isValidPhone]"
                                    v-model="userPhoneNumber"
                                    @input="phoneNumber"
                                    @change="phoneNumber"
                                    @blur="checkValidity"
                                />
                                <small
                                    class="text-danger"
                                    v-if="invalidPhoneNumberMsg"
                                    >{{ invalidPhoneNumberMsg }}</small
                                >
                            </div>
                        </div>
                    </div>
                    <div class="" v-else-if="paymentMethod == 'airtel'">
                        <div class="mb-4 credit-card-info--form">
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >First name</label
                                >
                                <input
                                    id="password_field"
                                    class="input_field"
                                    type="text"
                                    name="input-name"
                                    title="Enter Card Holder Name"
                                    placeholder="Enter your full name"
                                    v-model="buyerName"
                                />
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Last name</label
                                >
                                <input
                                    id="password_field"
                                    class="input_field"
                                    type="text"
                                    name="input-name"
                                    title="Enter Card Holder Name"
                                    placeholder="Enter your full name"
                                    v-model="buyerLastName"
                                />
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Email</label
                                >
                                <div class="split">
                                    <input
                                        id="password_field"
                                        class="input_field"
                                        type="email"
                                        name="input-name"
                                        title="Email"
                                        placeholder="Email"
                                        v-model="buyerEmail"
                                    />
                                </div>
                            </div>
                            <div class="input_container">
                                <label for="password_field" class="input_label"
                                    >Airtel Phone Number</label
                                >
                                <VueTelInput
                                    class="input_field"
                                    :inputOptions.required="true"
                                    :inputOptions.showDialCode="true"
                                    :rules="[isValidPhone]"
                                    v-model="userPhoneNumber"
                                    @input="phoneNumber"
                                    @change="phoneNumber"
                                    @blur="checkValidity"
                                />
                                <small
                                    class="text-danger"
                                    v-if="invalidPhoneNumberMsg"
                                    >{{ invalidPhoneNumberMsg }}</small
                                >
                            </div>
                        </div>
                    </div>

                    <button
                        class="purchase--btn"
                        @click.prevent="payTicket"
                        :disabled="checkoutDisabled"
                    >
                        <i
                            class="align-middle bx bx-loader bx-spin font-size-16 me-2"
                            v-if="isProcessing"
                        ></i
                        ><span>Make Payment</span>
                    </button>

                    <button
                        v-if="
                            props.myWallet &&
                            props.myWallet.balance >= totalAmount
                        "
                        style="padding: 13px"
                        class="mt-4 btn btn-primary"
                        @click.prevent="payTicketWithWallet"
                        :disabled="checkoutDisabled"
                    >
                        <i
                            class="align-middle bx bx-loader bx-spin font-size-16 me-2"
                            v-if="isProcessingWallet"
                        ></i
                        ><span>Pay with Wallet</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<style scoped>
.modalCheckout2 {
    width: fit-content;
    height: fit-content;
    background: #ffffff;
    box-shadow: 0px 187px 75px rgba(0, 0, 0, 0.01),
        0px 105px 63px rgba(0, 0, 0, 0.05), 0px 47px 47px rgba(0, 0, 0, 0.09),
        0px 12px 26px rgba(0, 0, 0, 0.1), 0px 0px 0px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    max-width: 450px;
}

.form {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 20px;
}

.payment--options button {
    /* height: 55px; */
    background: #f2f2f2;
    border-radius: 11px;
    padding: 10px;
    border: 0;
    outline: none;
}

.payment--options button svg {
    height: 18px;
}

.payment--options button:last-child svg {
    height: 22px;
}

.separator {
    width: calc(100% - 20px);
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    gap: 10px;
    color: #8b8e98;
    margin: 0 10px;
}

.separator > p {
    word-break: keep-all;
    display: block;
    text-align: center;
    font-weight: 600;
    font-size: 11px;
    margin: auto;
}

.separator .line {
    display: inline-block;
    width: 100%;
    height: 1px;
    border: 0;
    background-color: #e8e8e8;
    margin: auto;
}

.credit-card-info--form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.input_container {
    width: 100%;
    height: fit-content;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.split {
    display: grid;
    grid-template-columns: 4fr 2fr;
    gap: 15px;
}

.split input {
    width: 100%;
}

.input_label {
    font-size: 10px;
    color: #8b8e98;
    font-weight: 600;
}

.input_field {
    width: auto;
    height: 40px;
    padding: 0 0 0 16px;
    border-radius: 9px;
    outline: none;
    background-color: #f2f2f2;
    border: 1px solid #e5e5e500;
    transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
}

.input_field:focus {
    border: 1px solid transparent;
    box-shadow: 0px 0px 0px 2px #242424;
    background-color: transparent;
}

.purchase--btn {
    height: 55px;
    background: #f2f2f2;
    border-radius: 11px;
    border: 0;
    outline: none;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    background: linear-gradient(180deg, #363636 0%, #1b1b1b 50%, #000000 100%);
    box-shadow: 0px 0px 0px 0px #ffffff, 0px 0px 0px 0px #000000;
    transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
}

.purchase--btn:hover {
    box-shadow: 0px 0px 0px 2px #ffffff, 0px 0px 0px 4px #0000003a;
}

/* Reset input number styles */
.input_field::-webkit-outer-spin-button,
.input_field::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.input_field[type="number"] {
    -moz-appearance: textfield;
}

.payment-container {
    width: 100%;
    height: 100vh;
    position: relative;
}

.payment_page {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
    overflow: hidden;
}
</style>
