<script setup>
import { router } from "@inertiajs/vue3";
import { computed } from "vue";
import moment from "moment";

const props = defineProps(["eventTikectDetails", "userDetails", "transactionDetails", "isValid"]);

const showEndDateTime = computed(() => {
    const startDate = props?.eventTikectDetails.event?.start_date;
    const endTime = props?.eventTikectDetails.event?.end_time;
    return moment(`${startDate} ${endTime}`, "YYYY-MM-DD HH:mm");
});

const hasShowEnded = computed(() => {
    const currentTime = moment();
    return currentTime.isAfter(showEndDateTime.value);
});

function returnHome() {
    router.visit("/");
}
</script>

<template>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="card" style="width: 24rem">
            <div class="card-body">
                <div v-if="props.isValid">
                    <div v-if="hasShowEnded" class="mb-4 d-flex align-items-center justify-content-center">
                        <div>
                            <svg
                                version="1.1"
                                id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 345.8 345.8"
                                enable-background="new 0 0 345.8 345.8"
                                xml:space="preserve"
                                width="34px"
                                height="34px"
                                fill="#000000"
                            >
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <circle
                                            fill="none"
                                            stroke="#FFFFFF"
                                            stroke-width="0.75"
                                            stroke-miterlimit="10"
                                            cx="172.9"
                                            cy="172.9"
                                            r="172.5"
                                        ></circle>
                                        <circle fill="#E1473F" cx="172.9" cy="172.9" r="172.5"></circle>
                                        <circle fill="#FF5F57" cx="172.9" cy="172.9" r="157.5"></circle>
                                        <g>
                                            <path
                                                fill="#752521"
                                                d="M160.4,80.4c5.7-5.3,12.4-8,20.1-8c7.8,0,14.5,2.7,20.1,8c5.6,5.3,8.3,11.7,8.3,19.3 c0,3.7-0.8,9.3-2.3,16.6c-1.6,7.4-3.3,14.9-5.1,22.6c-2.1,8.4-4.4,18.8-7,31.2c-2.6,12.4-5.4,27.9-8.3,46.6h-11.3 c-2.9-18.5-5.7-34-8.3-46.5c-2.6-12.5-5-23-7-31.4c-2.1-8.9-3.9-16.6-5.3-23.2c-1.4-6.6-2.1-11.9-2.1-15.9 C151.9,92.1,154.7,85.7,160.4,80.4z M160.6,242.2c5.6-5.4,12.2-8.1,19.7-8.1c7.6,0,14.2,2.7,19.8,8.1c5.6,5.4,8.4,11.8,8.4,19.3 c0,7.4-2.8,13.8-8.4,19.1c-5.6,5.3-12.2,8-19.8,8c-7.5,0-14.1-2.7-19.7-8c-5.6-5.3-8.4-11.7-8.4-19.1 C152.2,254.1,155,247.6,160.6,242.2z"
                                            ></path>
                                        </g>
                                        <g>
                                            <path
                                                fill="#FFFFFF"
                                                d="M152.9,72.8c5.7-5.3,12.4-8,20.1-8c7.8,0,14.5,2.7,20.1,8c5.6,5.3,8.3,11.7,8.3,19.3 c0,3.7-0.8,9.3-2.3,16.6c-1.6,7.4-3.3,14.9-5.1,22.6c-2.1,8.4-4.4,18.8-7,31.2c-2.6,12.4-5.4,27.9-8.3,46.6h-11.3 c-2.9-18.5-5.7-34-8.3-46.5c-2.6-12.5-5-23-7-31.4c-2.1-8.9-3.9-16.6-5.3-23.2c-1.4-6.6-2.1-11.9-2.1-15.9 C144.4,84.5,147.2,78.1,152.9,72.8z M153.1,234.6c5.6-5.4,12.2-8.1,19.7-8.1c7.6,0,14.2,2.7,19.8,8.1c5.6,5.4,8.4,11.8,8.4,19.3 c0,7.4-2.8,13.8-8.4,19.1c-5.6,5.3-12.2,8-19.8,8c-7.5,0-14.1-2.7-19.7-8c-5.6-5.3-8.4-11.7-8.4-19.1 C144.7,246.5,147.5,240,153.1,234.6z"
                                            ></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="ms-2 fw-bold" style="font-size: large; color: #FF5F57">Expired </span>
                    </div>
                    <div v-else class="mb-4 d-flex align-items-center justify-content-center">
                        <div>
                            <svg
                                width="34px"
                                height="34px"
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
                        <span class="ms-2 fw-bold" style="font-size: large; color: #1ae031">Valid </span>
                    </div>

                    <div class="flex mb-3 text-center d-flex-column">
                        <div class="mb-3">
                            <label>{{ props.eventTikectDetails.ticket_id }}</label>
                        </div>
                        <div>
                            <label>{{ props.userDetails.full_name }}</label>
                        </div>
                        <div>
                            <label
                                >{{ props.eventTikectDetails.event.title }} ({{
                                   props.eventTikectDetails.event.location_name
                                }})</label
                            >
                        </div>
                        <div>

                        </div>
                        <div>
                            <label v-if="props.userDetails.payment_type == 'card'">ATM Card</label>
                            <label v-if="props.userDetails.payment_type == 'mtn'">MTN Mobile Money</label>
                            <label v-if="props.userDetails.payment_type == 'airtel'">Airtel Mobile Money</label>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div>
                        <svg
                            width="80px"
                            height="80px"
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
                    <h3 class="mt-4 mb-5 text-danger fw-bold">Invalid Ticket</h3>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary" @click="returnHome">Return to Home</button>
                </div>
            </div>
        </div>
    </div>
</template>
