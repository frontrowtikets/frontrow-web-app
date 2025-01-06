<script setup>
import mtnLogo from "../../images/mtnMobileMoney.png";
import airtelMoney from "../../images/airtelMoney.png";
import creditCard from "../../images/creditCard.svg";
import useCurrencyFormat from "../Composables/useCurrencyFormat.js";
import { ref, computed, onMounted } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps(["selectedTicket", "quantity"]);

const paymentMethod = ref("card");
const buyerName = ref("");
const buyerEmail = ref("");
const cardNumber = ref("");
const expiryDate = ref("");
const userPhoneNumber = ref("");
const cvv = ref("");
const isPhoneNumberValid = ref(true);
const invalidPhoneNumberMsg = ref("");

const responseError = ref("");

const isProcessing = ref(false);

onMounted(() => {
    if (usePage().props.auth.user != null) {
        buyerName.value = usePage().props.auth.user.name;
        buyerEmail.value = usePage().props.auth.user.email;
    }
});

const totalAmount = computed(() => {
    const total = Number(props.selectedTicket.price * props.quantity);
    return total;
});

const paymentDetailsCleaned = computed(() => {
    const cleaned = {
        name: buyerName.value,
        email: buyerEmail.value,
        phoneNumber: userPhoneNumber.value,
        paymentType: paymentMethod.value,
        cardNumber: cardNumber.value,
        expiryDate: expiryDate.value,
        cvv: cvv.value,
        selectedTicket: props.selectedTicket,
        total: totalAmount.value,
        quantity: props.quantity,
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
    await axios
        .post("/api/v1/buyEventTicket", paymentDetailsCleaned.value)
        .then((res) => {
            router.visit("/mytickets");
        })
        .catch((err) => {
            responseError.value = err.response.data.message;
            isProcessing.value = false;
        });
}
</script>

<template>
    <div class="modalCheckout2">
        <form class="form">
            <div class="payment--options">
                <button
                    name="paypal"
                    type="button"
                    @click="paymentMethod = 'card'"
                >
                    <img :src="creditCard" height="40" />
                </button>
                <button
                    name="apple-pay"
                    type="button"
                    @click="paymentMethod = 'mtn'"
                >
                    <img :src="mtnLogo" height="40" />
                </button>
                <button
                    name="google-pay"
                    type="button"
                    @click="paymentMethod = 'airtel'"
                >
                    <img :src="airtelMoney" height="40" />
                </button>
            </div>
            <div
                v-if="responseError"
                class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                {{ responseError }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
            <div class="separator">
                <hr class="line" />
                <p>Select Payment Method</p>
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
                            >Full name</label
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
                            >MTN Phone Number</label
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
                            >Full name</label
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
            <div class="text-end text-muted fw-bold">
                <span class="me-2">{{ props.selectedTicket.currency }}</span
                ><span>{{ useCurrencyFormat(totalAmount) }}</span>
            </div>
            <button class="purchase--btn" @click.prevent="payTicket">
                <i
                    class="align-middle bx bx-loader bx-spin font-size-16 me-2"
                    v-if="isProcessing"
                ></i
                ><span>Checkout</span>
            </button>
        </form>
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
    border-radius: 26px;
    max-width: 450px;
}

.form {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 20px;
}

.payment--options {
    width: calc(100% - 40px);
    display: grid;
    grid-template-columns: 33% 34% 33%;
    gap: 20px;
    padding: 10px;
}

.payment--options button {
    height: 55px;
    background: #f2f2f2;
    border-radius: 11px;
    padding: 0;
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
</style>
