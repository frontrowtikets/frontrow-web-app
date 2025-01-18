<script setup>
import { Head, useForm, router,usePage } from "@inertiajs/vue3";
import { reactive, onMounted, ref, watch,computed } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import InputError from "@/js/Components/InputError.vue";
import Stepper from "@/js/Components/Stepper.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import icondata from "@/images/icondata.png";
import { VueEditor } from "vue3-editor";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import { Money3Component } from "v-money3";
import IsUserAdmin from "@/js/Composables/IsUserAdmin.js"
import useInertiaFormSubmit from "@/js/Composables//useInertiaFormSubmit.js";
import Swal from "sweetalert2";


const props = defineProps(["eventCategories","beneficiaries", "editDetails"]);

const state = reactive({
    items: [
        {
            text: "Dashboard",
            href: "javascript:void(0)",
        },
        {
            text: "Schedule Events",
            active: true,
        },
    ],
    config: {
        masked: false,
        prefix: "",
        suffix: "",
        thousands: ",",
        decimal: ".",
        precision: 2,
        disableNegative: false,
        disabled: false,
        min: null,
        max: null,
        allowBlank: false,
        minimumNumberOfCharacters: 0,
        shouldRound: true,
        focusOnRight: false,
    },
});

const form = useForm({
    beneficiary_id: "",
    title: "",
    description: "",
    location_name: "",
    gps_location: "",
    start_date: "",
    end_date: "",
    start_time:"",
    end_time:"",
    status:"",
    thumbnail_url: "",
    currency: "",
    access_type: "",
    categories: [],
    bannerImage: null,
    cardImage: null,
    tickets: [],
    id:""
});

const bannerImageData = ref(null);
const cardImageData = ref(null);
const eventTickets = ref([{ currency: "UGX" }]);
const scheduleForBeneficiary = ref(false);
const selectedBeneficiary = ref(null)

const selectedTickets = ref([]);


 const {isAdmin} = IsUserAdmin();

onMounted(() => {
    form["beneficiary_id"] = usePage().props.auth.user.id;
    window.navigator.geolocation.getCurrentPosition(currentCoords, null, {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0,
    });

    if(props.editDetails){
        const editData = props.editDetails;
          form['beneficiary_id'] = editData.beneficiary_id
    form['title'] = editData.title
    form['description'] = editData.description
    form['location_name'] = editData.location_name
    form['gps_location'] = editData.gps_location
    form['start_date'] = editData.start_date
    form['end_date'] = editData.end_date
    form['start_time'] = editData.start_time
    form['end_time'] =editData.end_time
    form['status'] =editData.status
    form['thumbnail_url'] = editData.thumbnail_url
    form['currency'] = editData.currency
    form['access_type'] = editData.access_type
    form["id"] =  editData.id



    //categories
        editData.categories.forEach((category)=>{
            const eventCats= [];
            eventCats.push({id:category.id,name:category.name})
            form["categories"] = eventCats;
        })

        // tickets
         eventTickets.value = editData.event_tickets.map((ticket)=>{
            const cleaned = {
                id: ticket.id,
                category: ticket.category,
                currency: ticket.currency,
                price: ticket.price,
                quantity: ticket.available_quantity
            }
            return cleaned;
         })

    }
});

watch(
    eventTickets,
    (newVal) => {
        form["tickets"] = [...newVal];
    },
    { deep: true }
);
watch(selectedBeneficiary,(newVal)=>{
    form["beneficiary_id"] = newVal.id
})
function currentCoords(pos) {
    const crd = pos.coords;
    form["gps_location"] = `${crd.longitude},${crd.latitude}`;
}

const isEdit = computed(()=>{
    return props.editDetails?true:false;
})


function saveImage(event, cardType) {

    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            if (cardType === "card") {
                form["cardImage"] = file;
                cardImageData.value = reader.result; // Update the card image
            } else if (cardType === "banner") {
                form["bannerImage"] = file;
                bannerImageData.value = reader.result; // Update the banner image
            }
        };
        reader.readAsDataURL(file);
    }
}

function deleteBannerImage() {
    form["bannerImage"] = null;
    bannerImageData.value = null;
}

function deleteCardImage() {
    form["cardImage"] = null;
    cardImageData.value = null;
}

function addTicket() {
    eventTickets.value.push({ currency: "UGX" });
}
function deleteTicket(index) {
    eventTickets.value.splice(index, 1);
}

const submit = () => {
    form.post("/createevent", {
    onSuccess:()=>{
        router.visit("/myevents")
    },
        onError: (err) => {
            const keysArray = Object.keys(err);
                 Swal.fire({
                        title: "Something Went Wrong",
                        icon: "error",
                        html: `<p style="font-size: 14px">${err[`${keysArray[0]}`]}</p>`,
                        showCloseButton: false,
                        showCancelButton: false,
                        focusConfirm: true,
                        confirmButtonText: "OK",
                        confirmButtonColor: "#43ad60",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        closeOnClickOutside: false,
                    }).then((result) => {
                        if (result.value) {
                            // router.reload({
                            //     preserveState: false,
                            // });
                        }
                    });
        },
    });

};
</script>

<template>
    <Head title="Schedule Events" />

    <DashboardLayout>
        <PageHeader title="Schedule Event" :items="state.items" />
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <Stepper :steps="['Event Details', 'Tickets', 'Confirm & Schedule']">
                            <template #default="{ currentStep }">
                                <div v-if="currentStep === 1">

                                    <div class="mb-4" v-if="isAdmin">

                                <div class="mb-2 align-middle form-check font-size-16" v-if="!isEdit">
                                    <input class="form-check-input" type="checkbox" id="transactionCheck01"  v-model="scheduleForBeneficiary"/>
                                    <small class="form-check-label" for="transactionCheck01"> Schedule for another beneficiary </small>
                                </div>
                                    </div>
                                    <div class="mb-4 col-12 col-md-9" v-if="scheduleForBeneficiary">
                                            <label for="title" class="mb-2">Select Beneficiary <span class="text-danger">*</span></label>
                                            <v-select  v-model="selectedBeneficiary" :options="props.beneficiaries" :label="'name'"></v-select>
                                        </div>
                                    <div class="mt-4">
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="title" class="mb-2">Event Title <span class="text-danger">*</span></label>
                                            <input
                                                style="font-size: 13px"
                                                type="text"
                                                class="form-control"
                                                id="title"
                                                placeholder="Title"
                                                required
                                                v-model="form.title"
                                            />
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.title" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="access_type" class="mb-2">Access Type <span class="text-danger">*</span></label>
                                            <select class="form-select form-control" id="access_type" v-model="form.access_type">
                                                <option value="" disabled>Select</option>
                                                <option value="paid">Paid Event</option>
                                                <option value="free">Free Event</option>
                                                <option value="invite-only">Invite Only Event</option>
                                            </select>
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.access_type" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="event_status" class="mb-2">Event Status <span class="text-danger">*</span></label>
                                            <select class="form-select form-control" id="event_status" v-model="form.status">
                                                <option value="" disabled>Select</option>
                                                <option value="coming_soon">Coming Soon</option>
                                                <option value="ongoing">Ongoing</option>
                                            </select>
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.access_type" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="event_description" class="mb-2">Description</label>
                                            <VueEditor v-model="form.description" id="event_description"></VueEditor>
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.description" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="title" class="mb-2">Event Catergory <span class="text-danger">*</span></label>
                                            <v-select multiple v-model="form.categories" :options="props.eventCategories" :label="'name'" ></v-select>
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="location" class="mb-2">Location<span class="text-danger">*</span></label>
                                            <input
                                                style="font-size: 13px"
                                                type="text"
                                                class="form-control"
                                                id="title"
                                                placeholder="Location"
                                                required
                                                v-model="form.location_name"
                                            />
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.location_name" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="gps_location" class="mb-2">GPRS Coordinates <span class="text-danger">*</span></label>
                                            <input
                                                style="font-size: 13px"
                                                type="text"
                                                class="form-control"
                                                id="title"
                                                placeholder="Coordinates"
                                                required
                                                v-model="form.gps_location"
                                            />
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.gps_location" />
                                        </div>
                                        <div class="flex flex-row gap-4 mb-4 col-12 col-md-9 d-flex justify-content-between">
                                            <div class="w-100">
                                                <label for="start_date" class="mb-2">Start Date<span class="text-danger">*</span></label>
                                                <input
                                                    style="font-size: 13px"
                                                    type="date"
                                                    class="form-control"
                                                    id="title"
                                                    required
                                                    v-model="form.start_date"
                                                />
                                                <InputError class="mt-2 mb-4 text-danger" :message="form.errors.start_date" />
                                            </div>
                                            <div class="w-100">
                                                <label for="end_date" class="mb-2">End Date<span class="text-danger">*</span></label>
                                                <input
                                                    style="font-size: 13px"
                                                    type="date"
                                                    class="form-control"
                                                    id="title"
                                                    required
                                                    v-model="form.end_date"
                                                />
                                                <InputError class="mt-2 mb-4 text-danger" :message="form.errors.end_date" />
                                            </div>
                                        </div>
                                         <div class="flex flex-row gap-4 mb-4 col-12 col-md-9 d-flex justify-content-between">
                                            <div class="w-100">
                                                <label for="start_time" class="mb-2">Start Time<span class="text-danger">*</span></label>
                                                <input
                                                    style="font-size: 13px"
                                                    type="time"
                                                    class="form-control"
                                                    id="title"
                                                    required
                                                    v-model="form.start_time"
                                                />
                                                <InputError class="mt-2 mb-4 text-danger" :message="form.errors.start_time" />
                                            </div>
                                            <div class="w-100">
                                                <label for="end_time" class="mb-2">End Time<span class="text-danger">*</span></label>
                                                <input
                                                    style="font-size: 13px"
                                                    type="time"
                                                    class="form-control"
                                                    id="title"
                                                    required
                                                    v-model="form.end_time"
                                                />
                                                <InputError class="mt-2 mb-4 text-danger" :message="form.errors.end_time" />
                                            </div>
                                        </div>
                                        <div>
                                            <label for="event_banner" class="mb-2">Event Card Image <span class="text-danger">*</span></label>
                                            <div class="flex flex-row gap-4 mb-4 col-12 col-md-9 d-flex justify-content-between">
                                                <div class="dropzone w-100">
                                                    <div class="mx-auto">
                                                        <i class="bx bxs-cloud-upload" style="font-size: 4em; color: #b5b5b5"></i>
                                                    </div>
                                                    <div class="text-center text-muted">Appears on the card of your event Page.</div>
                                                    <div class="text-center text-muted">Please note your image should not be below 200x320 (<20MB).</div>

                                                    <label for="dropzoneFile">Select Files</label>
                                                    <input
                                                        type="file"
                                                        id="dropzoneFile"
                                                        class="dropzoneFile btn btn-primary"
                                                        @change="saveImage($event, 'card')"
                                                        :accept="'image/*'"
                                                    />
                                                </div>
                                                <div v-if="cardImageData">
                                                    <img
                                                        id="cardImage"
                                                        :src="cardImageData"
                                                        style="
                                                            object-fit: cover;
                                                            object-position: center;
                                                            height: 180px;
                                                            width: 150px;
                                                            border-radius: 5px;
                                                            background-color: lightgray;
                                                        "
                                                    />
                                                    <div class="mt-4 text-danger" role="button" @click="deleteCardImage">
                                                        <span class="me-2"><i class="bx bx-trash-alt"></i></span>Delete image
                                                    </div>
                                                </div>
                                                <div v-else-if="!cardImageData && isEdit">
                                                    <img
                                                        id="cardImage"
                                                        :src="props.editDetails.thumbnail_url"
                                                        style="
                                                            object-fit: cover;
                                                            object-position: center;
                                                            height: 180px;
                                                            width: 150px;
                                                            border-radius: 5px;
                                                            background-color: lightgray;
                                                        "
                                                    />

                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="event_banner" class="mb-2">Event Banner Image</label>
                                            <div class="flex flex-row gap-4 mb-4 col-12 col-md-9 d-flex justify-content-between">
                                                <div class="dropzone w-100">
                                                    <div class="mx-auto">
                                                        <i class="bx bxs-cloud-upload" style="font-size: 4em; color: #b5b5b5"></i>
                                                    </div>
                                                    <div class="text-center text-muted">Appears across the top of your event Page.</div>
                                                    <div class="text-center text-muted">Please note your image should not be below 1500x500 (<20MB) .</div>

                                                    <label for="dropzoneFile2">Select Files</label>
                                                    <input
                                                        type="file"
                                                        id="dropzoneFile2"
                                                        class="dropzoneFile2 btn-primary"
                                                        @change="saveImage($event, 'banner')"
                                                        :accept="'image/*'"
                                                    />
                                                </div>
                                                <div v-if="bannerImageData">
                                                    <img
                                                        id="bannerImage"
                                                        :src="bannerImageData"
                                                        style="
                                                            object-fit: cover;
                                                            object-position: center;
                                                            height: 150px;
                                                            width: 300px;
                                                            border-radius: 5px;
                                                            background-color: lightgray;
                                                        "
                                                    />
                                                    <div class="mt-4 text-danger" role="button" @click="deleteBannerImage">
                                                        <span class="me-2"><i class="bx bx-trash-alt"></i></span>Delete image
                                                    </div>
                                                </div>
                                                 <div v-else-if="!bannerImageData && isEdit">
                                                    <img
                                                        id="bannerImage"
                                                        :src="props.editDetails.banner_image_url"
                                                        style="
                                                            object-fit: cover;
                                                            object-position: center;
                                                            height: 150px;
                                                            width: 300px;
                                                            border-radius: 5px;
                                                            background-color: lightgray;
                                                        "
                                                    />

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div v-if="currentStep === 2">
                                    <div class="mt-4 mb-5 repeater">
                                        <div class="col-12">
                                            <div v-for="(field, index) in eventTickets" :key="field.id" class="mb-3 w-100 row">
                                                <div class="mb-3 col-lg-3">
                                                    <label for="category">Category</label>
                                                    <select class="form-select form-control" id="category" v-model="field.category">
                                                        <option value="" disabled>Select</option>
                                                        <option value="VIP">VIP</option>
                                                        <option value="VVIP">VVIP</option>
                                                        <option value="Ordinary">Ordinary</option>
                                                        <option value="Standard">Standard</option>
                                                        <option value="Standard">Early Bird</option>
                                                        <option value="Standard">Corporate</option>
                                                        <option value="Standard">First Class</option>
                                                        <option value="Charity Supporter">Charity Supporter</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Workshop Pass">Workshop Pass</option>
                                                    </select>
                                                </div>

                                              <div class="mb-3 col-lg-2">
                                                    <label for="quantity">Available Qty</label>
                                                    <input id="quantity " v-model="field.quantity" type="number" class="form-control" />
                                                </div>

                                                <div class="mb-3 col-lg-2">
                                                    <label for="currency">Currency</label>
                                                    <select class="form-select form-control" id="currency" v-model="field.currency">
                                                        <option value="UGX" :selected="true">UGX</option>
                                                        <option value="KSH">KSH</option>
                                                        <option value="USD">USD</option>
                                                        <option value="EUR">EUR</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-lg-3">
                                                    <label for="resume">Price</label>
                                                    <Money3Component
                                                        class="form-control"
                                                        v-model="field.price"
                                                        v-bind="state.config"
                                                    ></Money3Component>
                                                </div>

                                                <div class="col-lg-2 align-self-center">
                                                    <div class="pt-3">
                                                        <span class="mb-3 badge font-size-11 me-4" @click="deleteTicket(index)"
                                                            >{{ permission }}<i class="bx bxs-x-circle text-danger ps-1 pe-1" role="button"></i
                                                        ></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" class="mt-3 btn btn-success mt-lg-0" value="Add" @click="addTicket" />
                                    </div>
                                </div>
                                <div v-if="currentStep === 3">
                                    <div class="mt-4">
                                        <div class="">
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="product-detai-imgs">
                                                            <div v-if="cardImageData" class="product-img">
                                                                <img
                                                                    :src="cardImageData"
                                                                    alt
                                                                    class="mx-auto img-fluid d-block"
                                                                    style="
                                                                        object-fit: cover;
                                                                        object-position: center;
                                                                        height: 320px;
                                                                        background-color: lightgray;
                                                                    "
                                                                />
                                                            </div>
                                                                                  <div v-else-if="!cardImageData && isEdit">
                                                    <img
                                                        id="cardImage"
                                                        :src="props.editDetails.thumbnail_url"
                                                        alt
                                                                    class="mx-auto img-fluid d-block"
                                                                    style="
                                                                        object-fit: cover;
                                                                        object-position: center;
                                                                        height: 320px;
                                                                        background-color: lightgray;
                                                                    "
                                                    />

                                                </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="mt-3">
                                                            <h4 class="mt-1 mb-3">{{ form.title }}</h4>

                                                            <div v-if="form.categories">
                                            <span
                                                role="button"
                                                v-for="(category, index) in form.categories"
                                                :key="`${index}_${category.name}`"
                                            >
                                                <span class="mb-3 badge badge-soft-primary font-size-11 me-2"
                                                    >{{ category.name }}</span>
                                            </span>
                                        </div>

                                                            <h6 class="text-success">Tickets</h6>
                                                            <div class="mb-4">
                                                                <h5 class="mb-2" v-for="(details,index) in form.tickets" :key="`${index}`" >
                                                                {{ details.category }} :
                                                                <span class="text-muted me-2">
                                                                    <span> {{ details.currency  }}</span>
                                                                </span>
                                                               <span>{{ details.price }}</span>
                                                            </h5>
                                                            </div>
                                                            <p class="mb-4 text-muted" v-html="form.description"

                                                            </p>
                                                            <div class="mb-3 row">
                                                                <div class="">
                                                                    <div>
                                                                        <div class="mb-2 text-mute" v-if="form.location_name">
                                                                            <i
                                                                                class="align-middle bx bx-map-pin font-size-16 text-primary me-1"
                                                                            ></i>
                                                                            <span><span class="fw-bold me-3">Location:</span><span>{{ form.location_name }}</span></span>
                                                                        </div>
                                                                        <div class="mb-2 text-mute" v-if="form.gps_location">
                                                                            <i
                                                                                class="align-middle bx bx-map font-size-16 text-primary me-1"
                                                                            ></i>
                                                                            <span><span class="fw-bold me-3">Map Coordinates:</span><span>{{ form.gps_location }}</span></span>
                                                                        </div>
                                                                        <div class="mb-2 text-mute" v-if="form.start_date">
                                                                            <i
                                                                                class="align-middle bx bx-calendar font-size-16 text-primary me-1"
                                                                            ></i>
                                                                            <span><span class="fw-bold me-3">Date:</span><span v-if="form.start_date">{{ form.start_date }}</span><span v-if="form.end_date"> to {{ form.end_date }}</span></span>
                                                                        </div>

                                                                        <div class="mb-2 text-mute" v-if="form.access_type">
                                                                            <i
                                                                                class="align-middle bx bx-user-voice font-size-16 text-primary me-1"
                                                                            ></i>
                                                                            <span><span class="fw-bold me-3">Access Type:</span><span>{{ form.access_type }}</span></span>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-5">
                                            <button
                                                class="btn btn-primary btn-block waves-effect waves-light"
                                                type="submit"
                                                @click.prevent="submit"
                                                :disabled="form.processing"
                                            >
                                                <i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="form.processing"></i
                                                ><span>Schedule Event</span>
                                            </button>
                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Stepper>
                    </form>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
<style scoped lang="scss">
.image {
    background: #34495e;
    border: 1px solid #34495e;
    border-radius: 4px;
    width: 100px;
    height: 100px;
}

.image-contain {
    object-fit: contain;
    object-position: center;
}

.image-cover {
    object-fit: cover;
    object-position: right top;
}

.dropzone {
    // width: 400px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    row-gap: 16px;
    border: 2px dashed #01b4bd45;
    background-color: #fff;
    transition: 0.3s ease all;
    label {
        padding: 8px 12px;
        border-radius: 4px;
        color: #fff;
        background-color: #01b3bd;
        transition: 0.3s ease all;
    }
    input {
        display: none;
    }
}
.dropzone2 {
    // width: 400px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    row-gap: 16px;
    border: 2px dashed #01b4bd45;
    background-color: #fff;
    transition: 0.3s ease all;
    label {
        padding: 8px 12px;
        border-radius: 4px;
        color: #fff;
        background-color: #01b3bd;
        transition: 0.3s ease all;
    }
    input {
        display: none;
    }
}
.active-dropzone {
    color: #fff;
    border-color: #fff;
    background-color: #01b3bd;
    label {
        background-color: #fff;
        border-radius: 4px;
        color: #01b3bd;
    }
}
</style>
