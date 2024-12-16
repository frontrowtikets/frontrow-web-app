<script setup>
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import DashboardLayout from "../../Layouts/main.vue";
import PageHeader from "@/js/Components/page-header.vue";
import { reactive, onMounted, computed, ref } from "vue";
import IsUserBeneficiary from "../../Composables/IsUserBeneficiary.js";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import moment from "moment";
import YouTube from "vue3-youtube";
import Swal from "sweetalert2";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

const props = defineProps(["movieDetails"]);
const state = reactive({});

const currentUser = computed(() => {
    const theUser = usePage().props.auth.user;
    return theUser;
});

const form = useForm({
    review: "",
    movie_id: props.movieDetails.id,
    user_id: usePage().props.auth.user.id,
    submitted_by: usePage().props.auth.user.name,
});

const seatMapModal = ref(false);

const submit = () => {
    form.post("/createmoviereview", {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            router.reload();
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
                }
            });
        },
    });
};

function slugify(title){
     return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
}
function buyTicket(){

    router.visit(`/movie/buy-ticket/${slugify(props.movieDetails.title)}/${props.movieDetails.id}`)
}

</script>
<template>
    <Head :title="props.movieDetails.title" />

    <DashboardLayout>
        <PageHeader :title="props.movieDetails.title" :items="state.items" />

        <div class="row">
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-semibold">Overview</h5>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <td scope="col">{{ moment(props.movieDetails.release_date).format("MMM Do YY") }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Duration</th>
                                        <td>{{ props.movieDetails.duration }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Rating</th>
                                        <td>
                                            <div class="flex-row gap-2 d-flex" role="button">
                                                <div
                                                    v-for="star in 5"
                                                    :key="star"
                                                    class="movie-item-star-icon-button"
                                                    :class="star <= props.movieDetails.overallRating ? 'text-warning' : 'text-grey'"
                                                    :disabled="star === props.movieDetails.overallRating"
                                                >
                                                    <i class="bx bxs-star"></i>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td>
                                            <span class="badge badge-soft-secondary" v-if="props.movieDetails.status == 'coming_soon'"
                                                >Coming Soon</span
                                            >
                                            <span class="badge badge-soft-secondary" v-if="props.movieDetails.status == 'now_showing'"
                                                >Now Showing</span
                                            >
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Language</th>
                                        <td>
                                            <span class="badge badge-soft-success">{{ props.movieDetails.languange }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Maturity</th>
                                        <td>
                                            <span class="badge badge-soft-info">{{ props.movieDetails.maturity_rating }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="gap-2 hstack">
                            <button class="btn btn-soft-primary w-100" @click="buyTicket">Buy Ticket</button>
                            <button class="btn btn-soft-danger w-100" v-if="props.movieDetails.beneficiary_id == currentUser.id">Edit</button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img
                                :src="props.movieDetails.beneficiary.profile_photo_url"
                                :alt="'p'"
                                class="mx-auto rounded-circle header-profile-user object-fit-cover d-block"
                            />
                            <h5 class="mt-3 mb-1">{{ props.movieDetails.beneficiary.name }}</h5>
                            <p class="mb-0 text-muted">Since July 2017</p>
                        </div>

                        <ul class="mt-4 list-unstyled">
                            <li>
                                <div class="d-flex">
                                    <i class="bx bx-phone text-primary fs-4"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-2 fs-14">Phone</h6>
                                        <p class="mb-0 text-muted fs-14">{{ props.movieDetails.beneficiary.phone_number }}</p>
                                    </div>
                                </div>
                            </li>
                            <li class="mt-3">
                                <div class="d-flex">
                                    <i class="bx bx-mail-send text-primary fs-4"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-2 fs-14">Email</h6>
                                        <p class="mb-0 text-muted fs-14">{{ props.movieDetails.beneficiary.email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li class="mt-3">
                                <div class="d-flex">
                                    <i class="bx bx-globe text-primary fs-4"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-2 fs-14">Website</h6>
                                        <p class="mb-0 text-muted fs-14 text-break">www.frontrow.com</p>
                                    </div>
                                </div>
                            </li>
                            <li class="mt-3">
                                <div class="d-flex">
                                    <i class="bx bx-support text-primary fs-4"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-2 fs-14">Support</h6>
                                        <p class="mb-0 text-muted fs-14">support@frontrow.com</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-4" v-if="props.movieDetails.beneficiary_id == currentUser.id">
                            <a href="#!" class="rounded btn btn-soft-primary btn-hover w-100"><i class="mdi mdi-eye"></i> Tickets Sold</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-9">
                <div class="card">
                    <div
                        class="card-body border-bottom background-container"
                        :style="{ backgroundImage: `url(${props.movieDetails.poster_url})` }"
                    ></div>
                    <div class="card-body">
                        <div class="flex-row d-flex col-12 justify-content-between">
                            <div class="col-5">
                                <span class="badge badge-soft-primary me-3" v-for="(genre, index) in props.movieDetails.genres" :key="index">{{
                                    genre.name
                                }}</span>
                            </div>
                            <div class="" v-if="props.movieDetails.beneficiary_id == currentUser.id">
                                <button class="btn btn-soft-primary w-100" @click="seatMapModal = true">Add Seat Map</button>
                            </div>
                        </div>

                        <h5 class="mb-3 fw-semibold">Description</h5>
                        <p class="text-muted" v-html="props.movieDetails.description"></p>

                        <div class="mb-5" v-if="props.movieDetails.trailer_url">
                            <h5 class="mb-3 fw-semibold">Trailer:</h5>
                            <YouTube :src="`${props.movieDetails.trailer_url}`" @ready="onReady" ref="youtube" />
                        </div>

                        <h5 class="mb-3 fw-semibold">Show Times</h5>
                        <div class="col-12 d-flex">
                            <div class="mb-3 col-lg-4">
                                <label for="theatre">Theatre</label>
                            </div>

                            <div class="mb-3 col-lg-2">
                                <label for="screening_date">Date</label>
                            </div>
                            <div class="mb-3 col-lg-2">
                                <label for="start_time">Starts At</label>
                            </div>
                            <div class="mb-3 col-lg-2">
                                <label for="end_time">Ends At</label>
                            </div>

                            <div class="mb-3 col-lg-2">
                                <label for="resume">Ticket Price</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div v-for="(field, index) in props.movieDetails.show_times" :key="field.id" class="mb-3 w-100 row">
                                <div class="mb-3 col-lg-4">
                                    {{ field.theatre }}
                                </div>

                                <div class="mb-3 col-lg-2">
                                    {{ field.screening_date }}
                                </div>
                                <div class="mb-3 col-lg-2">
                                    {{ field.start_time }}
                                </div>
                                <div class="mb-3 col-lg-2">
                                    {{ field.end_time }}
                                </div>

                                <div class="mb-3 col-lg-2">{{ field.currency }}: {{ useCurrencyFormat(field.ticket_price) }}</div>
                            </div>
                        </div>

                        <b-button variant="primary" @click="buyTicket">Buy Ticket </b-button>

                        <div class="mt-5">
                            <h5 class="mb-4">Reviews :</h5>

                            <div
                                class="mt-3 d-flex border-bottom"
                                v-for="(review, index) in props.movieDetails.reviews"
                                :key="`${index}_${review.submitted_by}`"
                            >
                                <img
                                    :src="review.user.profile_photo_url"
                                    class="me-3 rounded-circle header-profile-user object-fit-cover"
                                    alt="img"
                                />
                                <div class="flex-grow-1">
                                    <h5 class="mt-0 font-size-15">{{ review.submitted_by }}</h5>
                                    <p class="text-muted">{{ review.review }}</p>
                                    <ul class="invisible list-inline float-sm-end">
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);"> <i class="far fa-thumbs-up me-1"></i> Like </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);"> <i class="far fa-comment-dots me-1"></i> Comment </a>
                                        </li>
                                    </ul>
                                    <div class="text-muted">
                                        <i class="far fa-calendar-alt text-primary me-1"></i> {{ moment(review.created_at).fromNow() }}
                                    </div>
                                </div>
                            </div>
                            <form>
                                <div class="gap-4 mt-5 mb-5 col-12 c d-flex align-items-end">
                                    <div class="col-10 col-md-8">
                                        <textarea
                                            class="form-control"
                                            id="commentmessage-input"
                                            placeholder="Your message..."
                                            rows="3"
                                            v-model="form.review"
                                        ></textarea>
                                    </div>
                                    <div>
                                        <button
                                            type="submit"
                                            class="btn btn-primary chat-send w-md"
                                            @click.prevent="submit"
                                            :disabled="form.processing"
                                        >
                                            <span class="d-none d-sm-inline-block me-2"
                                                ><i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="form.processing"></i
                                                ><span>Submit</span></span
                                            >
                                            <i class="mdi mdi-send"></i>
                                        </button>
                                    </div>

                                    <InputError class="mt-2 mb-4 text-danger" :message="form.errors.review" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <b-modal v-model="seatMapModal" size="xl" id="Seat_Map" centered title="Seat Map" title-class="font-18" hide-footer>
                    <div class="gap-4 mt-5 col-12 d-flex">
                        <div class="col-4">
                            <div class="mb-3">
                                <label>Theatre</label>
                                <v-select :options="props.movieDetails.show_times" :label="'theatre'"></v-select>
                            </div>
                            <div class="mb-3">
                                <label>Room Name</label>
                                <input class="form-control" type="text" id="roomname" />
                            </div>
                            <div class="gap-3 d-flex col-12 justify-content-between">
                                <div class="col-9">
                                    <div class="mb-3">
                                        <label>Row Label</label>
                                        <select class="form-select form-control" id="movie_status">
                                            <option value="" disabled default>Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                            <option value="J">J</option>
                                            <option value="K">K</option>
                                            <option value="L">L</option>
                                            <option value="M">M</option>
                                            <option value="N">N</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label>Column Seat Number</label>
                                        <input class="form-control" type="text" id="roomname" />
                                    </div>
                                </div>
                                <div class="rounded col-2 d-flex align-items-center justify-content-center" style="background-color: #f6f6f9" role="button">
                                    <div class="text-success fw-bold ">Add</div>
                                </div>
                            </div>
                            <div class="mt-5 mb-5">
                                <b-button variant="success">Add Theatre</b-button>
                            </div>
                        </div>
                    </div>
                </b-modal>
            </div>
            <!--end col-->
        </div>
    </DashboardLayout>
</template>
<style scoped>
.background-container {
    width: 100%;
    height: 300px;
    background-color: grey;
    /* Background styles to center the image */
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
</style>
