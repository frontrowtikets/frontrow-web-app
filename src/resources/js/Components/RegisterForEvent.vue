<script setup>
import {  useForm,  } from "@inertiajs/vue3";
import {ref,watch } from "vue";

const props = defineProps("showModal");

const form = useForm({
    name: "",
    email: "",
    asEventsManager: false,
    password: "",
    phone_number: "",
    password_confirmation: "",
    terms: true,
});

const showRegisterModal= ref(true)

watch(props.showModal,(newVal)=>{
    showRegisterModal.value =newVal
})

</script>
<template>
    <b-modal
        :v-model="showRegisterModal"
        id="EventRegister"
        centered
        title="Register For Event"
        title-class="font-18"
        hide-footer
    >
        <div>
            <form>
                <div
                    v-if="form.errors.email"
                    class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    {{ form.errors.email }}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>

                <div
                    v-if="form.errors.phone_number"
                    class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    {{ form.errors.phone_number }}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
                <div
                    v-if="invalidPhoneNumberMsg"
                    class="mt-4 mb-4 alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    {{ invalidPhoneNumberMsg }}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="mb-3">
                    <label for="name">Name</label>
                    <input
                        style="font-size: 13px"
                        type="text"
                        class="form-control"
                        id="name"
                        placeholder="Name"
                        required
                        v-model="form.name"
                    />
                    <InputError
                        class="mt-2 mb-4 text-danger"
                        :message="form.errors.name"
                    />
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
                    <InputError
                        class="mt-2 mb-4 text-danger"
                        :message="form.errors.email"
                    />
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
                    <small class="text-danger" v-if="invalidPhoneNumberMsg">{{
                        invalidPhoneNumberMsg
                    }}</small>
                </div>

                <div class="">
                    <div class="mb-3 form-check form-check-left">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="formCheckRight1"
                            v-model="form.asEventsManager"
                        />
                        <label class="form-check-label" for="formCheckRight1">
                            Register as Events Manager
                        </label>
                    </div>
                </div>

                <div class="mt-5 d-grid">
                    <button
                        class="btn btn-primary btn-block waves-effect waves-light"
                        type="submit"
                        @click="submit"
                        :disabled="form.processing"
                    >
                        <i
                            class="align-middle bx bx-loader bx-spin font-size-16 me-2"
                            v-if="form.processing"
                        ></i
                        ><span>Register</span>
                    </button>
                </div>
            </form>
        </div>
    </b-modal>
</template>
