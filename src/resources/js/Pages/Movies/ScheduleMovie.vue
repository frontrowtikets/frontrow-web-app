<script setup>
import { Head, useForm, router,usePage } from "@inertiajs/vue3";
import { reactive, onMounted, ref, watch, computed } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import InputError from "@/js/Components/InputError.vue";
import Stepper from "@/js/Components/Stepper.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import { VueEditor } from "vue3-editor";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import { Money3Component } from "v-money3";
import IsUserAdmin from "@/js/Composables/IsUserAdmin.js"
import Swal from "sweetalert2";


const props = defineProps(["movieCategories","beneficiaries", "editDetails"]);

const state = reactive({
    items: [
        {
            text: "Dashboard",
            href: "javascript:void(0)",
        },
        {
            text: "Schedule Movies",
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
    language: "",
    trailer_url: "",
    release_date: "",
    duration:"",
    status:"",
    rating:3,
    thumbnail_url: "",
    currency: "",
    maturity_rating: "",
    categories: [],
    bannerImage: null,
    cardImage: null,
    tickets: [],
    casts:[],
    id:'',
    director:'',
    writer:'',
    producer:'',
    viewingFormat: '3D'

});

const bannerImageData = ref(null);
const cardImageData = ref(null);
const movieTheatres = ref([{ currency: "UGX" }]);
const movieCasts = ref([{ castName: '', role: '', image: null, imagePreview: null,imageUrl:''}]);
const scheduleForBeneficiary = ref(false);
const selectedBeneficiary = ref(null);
const movieRating = ref(3);
const movieLanguages = ref(["English","Kiswahili","Luganda",]);
const fileInputs = ref([]);
 const {isAdmin} = IsUserAdmin();

onMounted(() => {
    form["beneficiary_id"] = usePage().props.auth.user.id;

    if(props.editDetails){
        const editData = props.editDetails;
    form["beneficiary_id"] = editData.beneficiary_id;
        form["title"] = editData.title;
        form["maturity_rating"] = editData.maturity_rating;
        form["status"] = editData.status;
        form["description"] = editData.description;
        form["language"] = editData.languange;
        form["trailer_url"] = editData.trailer_url;
        form["release_date"] = editData.release_date;
        form["duration"] = editData.duration;
        form["rating"] = movieRating.value;
        form["id"] = editData.duration;
        form["director"] = editData.director;
        form["writer"] = editData.writer;
        form["producer"] = editData.producer;
        form["viewingFormat"] = editData.viewing_format;

        //genres
        editData.genres.forEach((genre)=>{
            const moviegenres = [];
            moviegenres.push({id:genre.id,name:genre.name})
            form["categories"] = moviegenres;
        })

        //show times
        movieTheatres.value = editData.show_times
        //casts
        movieCasts.value = editData.moviecasts.map((cast)=>{
            const cleaned = {
                castName: cast.name,
                role: cast.role,
                imageUrl:cast.profile_image_url,
                id:cast.id
            }

            return cleaned;
        })

    }



});

watch(
    movieTheatres,
    (newVal) => {
        form["tickets"] = [...newVal];
    },
    { deep: true }
);
watch(selectedBeneficiary,(newVal)=>{
    form["beneficiary_id"] = newVal.id
})
watch(movieRating,(newVal)=>{
    form["rating"] = newVal
})
watch(movieCasts,(newVal)=>{
    const cleaned  = newVal.map((cast)=>{
        const castObj = {castName:cast.castName,role:cast.role,image:cast.image}

        if(cast.hasOwnProperty("id")){
            castObj.id = cast.id
        }
        return castObj
    })

    form['casts'] = cleaned;
}, { deep: true } )

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
    movieTheatres.value.push({ currency: "UGX" });
}
function deleteTicket(index) {
    movieTheatres.value.splice(index, 1);
}
function updateRating(star){
movieRating.value = star
}
const submit = () => {
    if(isEdit.value){
        form ["id"] = props.editDetails.id
    }
    form.post("/createmovie", {
    onSuccess:()=>{
        router.visit("/mymovies")
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
const selectProfilePhoto = (index) => {
     fileInputs.value[index]?.click();
};

function addNewCast() {
      movieCasts.value.push({
        castName: '',
        role: '',
        image: null,
        imagePreview: null,
        imageUrl:''
      })
    }
function removeCast(index) {
      movieCasts.value.splice(index, 1)
    }
function handleImageUpload(event, index) {
      const file = event.target.files[0]
      if (!file) return

      movieCasts.value[index].image = file

      const reader = new FileReader()
      reader.onload = (e) => {
        movieCasts.value[index].imagePreview = e.target.result
      }
      reader.readAsDataURL(file)
    }
</script>

<template>
    <Head title="Schedule Movies" />

    <DashboardLayout>
        <PageHeader title="Schedule Movie" :items="state.items" />
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <Stepper :steps="['Movie Details', 'Theater','Casts', 'Confirm & Schedule']">
                            <template #default="{ currentStep }">
                                <div v-if="currentStep === 1">

                                    <div class="mb-4" v-if="isAdmin && !isEdit">

                                <div class="mb-2 align-middle form-check font-size-16">
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
                                            <label for="title" class="mb-2">Movie Title <span class="text-danger">*</span></label>
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
                                            <label for="title" class="mb-2">Director </label>
                                            <input
                                                style="font-size: 13px"
                                                type="text"
                                                class="form-control"
                                                id="title"
                                                placeholder="Director"
                                                required
                                                v-model="form.director"
                                            />
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.director" />
                                        </div>
                                          <div class="mb-4 col-12 col-md-9">
                                            <label for="title" class="mb-2">Writer </label>
                                            <input
                                                style="font-size: 13px"
                                                type="text"
                                                class="form-control"
                                                id="writer"
                                                placeholder="Writer"
                                                required
                                                v-model="form.writer"
                                            />
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.writer" />
                                        </div>
                                          <div class="mb-4 col-12 col-md-9">
                                            <label for="title" class="mb-2">Producer</label>
                                            <input
                                                style="font-size: 13px"
                                                type="text"
                                                class="form-control"
                                                id="producer"
                                                placeholder="Producer"
                                                required
                                                v-model="form.producer"
                                            />
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.producer" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9" v-if="isAdmin">
                                            <label for="maturity_rating" class="mb-2">Maturity Rating<span class="text-danger">*</span></label>
                                            <select class="form-select form-control" id="maturity_rating" v-model="form.maturity_rating">
                                                <option value="" disabled>Select</option>
                                                <option value="13+">13+</option>
                                                <option value="Adults">Adults</option>
                                                <option value="Kids">Kids</option>
                                                <option value="Any">Any</option>
                                            </select>
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.access_type" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="movie_status" class="mb-2">Movie Status <span class="text-danger">*</span></label>
                                            <select class="form-select form-control" id="movie_status" v-model="form.status">
                                                <option value="" disabled>Select</option>
                                                <option value="coming_soon">Coming Soon</option>
                                                <option value="now_showing">Now Showing</option>
                                            </select>
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.access_type" />
                                        </div>
                                         <div class="mb-4 col-12 col-md-9">
                                            <label for="movie_status" class="mb-2">Viewing Format <span class="text-danger">*</span></label>
                                            <select class="form-select form-control" id="movie_status" v-model="form.viewingFormat">
                                                <option value="3D" selected>3D</option>
                                                <option value="2D">2D</option>
                                                <option value="4D">4D</option>
                                                <option value="IMAX">IMAX</option>
                                                <option value="5D & above ">5D & Above</option>
                                            </select>
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.viewingFormat" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="event_description" class="mb-2">Description</label>
                                            <VueEditor v-model="form.description" id="event_description"></VueEditor>
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.description" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="title" class="mb-2">Genre <span class="text-danger">*</span></label>
                                            <v-select multiple v-model="form.categories" :options="props.movieCategories" :label="'name'"></v-select>
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="language" class="mb-2">Language<span class="text-danger">*</span></label>
                                             <v-select  v-model="form.language" :options="movieLanguages" taggable></v-select>
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.language" />
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="trailer_url" class="mb-2">Trailer URL <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="formFile" placeholder="Link" v-model="form.trailer_url" >
                                            <InputError class="mt-2 mb-4 text-danger" :message="form.errors.trailer_url" />
                                        </div>

                                        <div class="flex flex-row gap-4 mb-4 col-12 col-md-9 d-flex justify-content-between">
                                            <div class="w-100">
                                                <label for="release_date" class="mb-2">Release Date<span class="text-danger">*</span></label>
                                                <input
                                                    style="font-size: 13px"
                                                    type="date"
                                                    class="form-control"
                                                    id="title"
                                                    required
                                                    v-model="form.release_date"
                                                />
                                                <InputError class="mt-2 mb-4 text-danger" :message="form.errors.release_date" />
                                            </div>
                                           <div class="w-100">
                                                <label for="duration" class="mb-2">Duration (minutes)<span class="text-danger">*</span></label>
                                                <input
                                                    style="font-size: 13px"
                                                    type="number"
                                                    class="form-control"
                                                    min="1"
                                                    id="duration"
                                                    required
                                                    v-model="form.duration"
                                                />
                                                <InputError class="mt-2 mb-4 text-danger" :message="form.errors.duration" />
                                            </div>
                                        </div>
                                        <div class="mb-4 col-12 col-md-9">
                                            <label for="trailer_url" class="mb-2">Rating</label>

                                                <div class="flex-row gap-2 d-flex" role="button">
                                                <div
                                                 v-for="star in 5"
                                                :key="star"
                                                class="movie-item-star-icon-button"
                                                :class="star <= movieRating ? 'text-warning' : 'text-grey'"
                                                :disabled="star === movieRating"
                                                @click="updateRating(star)"
                                                @mouseover="()=>movieRating =star"
                                            >
                                                <i class="bx bxs-star" ></i>
                                                </div>
                                                </div>

                                        </div>

                                        <div>
                                            <label for="event_banner" class="mb-2">Movie Card Image <span class="text-danger">*</span></label>
                                            <div class="flex flex-row gap-4 mb-4 col-12 col-md-9 d-flex justify-content-between">
                                                <div class="dropzone w-100">
                                                    <div class="mx-auto">
                                                        <i class="bx bxs-cloud-upload" style="font-size: 4em; color: #b5b5b5"></i>
                                                    </div>
                                                    <div class="text-center text-muted">Appears on the card of your movie Page.</div>
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
                                            <label for="movie_banner" class="mb-2">Movie Banner Image</label>
                                            <div class="flex flex-row gap-4 mb-4 col-12 col-md-9 d-flex justify-content-between">
                                                <div class="dropzone w-100">
                                                    <div class="mx-auto">
                                                        <i class="bx bxs-cloud-upload" style="font-size: 4em; color: #b5b5b5"></i>
                                                    </div>
                                                    <div class="text-center text-muted">Appears across the top of your movie Page.</div>
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
                                                        :src="props.editDetails.poster_url"
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
                                            <div v-for="(field, index) in movieTheatres" :key="field.id" class="mb-3 w-100 row">
                                                <div class="mb-3 col-lg-2">
                                                    <label for="theatre">Theatre</label>
                                                    <input id="theatre" v-model="field.theatre" type="text" class="form-control" />

                                                </div>

                                                <div class="mb-3 col-lg-2">
                                                    <label for="screening_date">Date</label>
                                                    <input id="screening_date " v-model="field.screening_date" type="date" class="form-control" />
                                                </div>
                                                <div class="mb-3 col-lg-2">
                                                    <label for="start_time">Starts At</label>
                                                    <input id="start_time" v-model="field.start_time" type="time" class="form-control" />
                                                </div><div class="mb-3 col-lg-2">
                                                    <label for="end_time">Ends At</label>
                                                    <input id="end_time " v-model="field.end_time" type="time" class="form-control" />
                                                </div>

                                                <div class="mb-3 col-lg-1">
                                                    <label for="currency">Currency</label>
                                                    <select class="form-select form-control" id="currency" v-model="field.currency">
                                                        <option value="UGX" :selected="true">UGX</option>
                                                        <option value="KSH">KSH</option>
                                                        <option value="USD">USD</option>
                                                        <option value="EUR">EUR</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-lg-2">
                                                    <label for="resume">Ticket Price</label>
                                                    <Money3Component
                                                        class="form-control"
                                                        v-model="field.ticket_price"
                                                        v-bind="state.config"
                                                    ></Money3Component>
                                                </div>

                                                <div class="col-1 align-self-center ">
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
                                    <div class="mt-4 mb-5 repeater">
                                        <div class="col-12">
                                            <div v-for="(field, index) in movieCasts" :key="`${index}_${field.name}`" class="gap-4 mb-3 w-100 d-flex align-items-center ">

                                                <div class="mb-3 col-4 ">
                                                    <label for="theatre">Name <span class="text-danger">*</span></label>
                                                    <input id="theatre" v-model="field.castName" type="text" class="form-control" />

                                                </div>
                                                <div class="mb-3 col-3">
                                                    <label for="theatre">Role <span class="text-danger">*</span></label>
                                                    <input id="theatre" v-model="field.role" type="text" class="form-control" />

                                                </div>



                                                <div class="mb-3 ">
                                                    <label>Upload Profile Picture</label>
                                                    <div>
                     <input
              type="file"
              class=" form-control"
              @change="(event)=>handleImageUpload(event, index)"
              accept="image/*"
            />

                </div>

                                                </div>
  <div v-if="field.imagePreview" class="">

                <img v-if="field.imagePreview" :src="field.imagePreview" :alt="'img'" class="rounded-circle avatar-sm object-fit-cover" />

            </div>
            <div v-else>

                <img v-if="!field.imagePreview && isEdit && field.imageUrl" :src="field.imageUrl" :alt="'img'" class="rounded-circle avatar-sm object-fit-cover" />

            </div>


                                                <div class=" align-self-center">
                                                    <div class="pt-3">
                                                        <span class="mb-3 badge font-size-11 me-4" @click="removeCast(index)" v-if="movieCasts.length > 1"
                                                            >{{ permission }}<i class="bx bxs-x-circle text-danger ps-1 pe-1" role="button"></i
                                                        ></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" class="mt-3 btn btn-success mt-lg-0" value="Add" @click="addNewCast" />
                                    </div>
                                </div>

                                <div v-if="currentStep === 4">
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

                                                            <h6 class="text-success">Theatre</h6>
                                                            <div class="mb-4">
                                                                <h5 class="mb-2" v-for="(details,index) in form.tickets" :key="`${index}`" >
                                                                {{ details.theatre }} :
                                                                <span class="text-muted me-2">
                                                                    <span> {{ details.currency  }}</span>
                                                                </span>
                                                               <span>{{ details.ticket_price }}</span>
                                                            </h5>
                                                            </div>
                                                            <p class="mb-4 text-muted" v-html="form.description"

                                                            </p>
                                                            <div class="mb-3 row">
                                                                <div class="">
                                                                    <div>
                                                                        <div class="mb-2 text-mute" v-if="form.maturity_rating">
                                                                            <i
                                                                                class="align-middle bx bx-male-sign font-size-16 text-primary me-1"
                                                                            ></i>
                                                                            <span><span class="fw-bold me-3">Maturity Rating:</span><span >{{ form.maturity_rating }}</span></span>
                                                                        </div>

                                                                        <div class="mb-2 text-mute" v-if="form.status">
                                                                            <i
                                                                                class="align-middle bx bx-play-circle font-size-16 text-primary me-1"
                                                                            ></i>
                                                                            <span><span class="fw-bold me-3">Status:</span><span v-if="form.status == 'coming_soon'">Coming Soon</span><span v-if="form.status == 'now_showing'">Now Showing</span></span>
                                                                        </div>
                                                                        <div class="mb-2 text-mute" v-if="form.casts.length>0">
                                                                            <i
                                                                                class="align-middle bx bx-user-circle font-size-16 text-primary me-1"
                                                                            ></i>
                                                                            <span><span class="fw-bold me-3">Casts:</span> <span
                                                role="button"
                                                v-for="(cast, index) in form.casts"
                                                :key="`${index}_${cast.castName}`"
                                            >
                                                <span class="mb-3 badge badge-soft-secondary font-size-11 me-2"
                                                    >{{ cast.castName}}</span>
                                            </span></span>
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
                                                ><span>Schedule Movie</span>
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
