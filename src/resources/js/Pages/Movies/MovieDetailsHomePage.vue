<script setup>
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import PageHeader from "@/js/Components/page-header.vue";
import { reactive, computed, ref, onMounted } from "vue";
import useCurrencyFormat from "../../Composables/useCurrencyFormat.js";
import HomeHeader from "../../Components/HomeHeader.vue";
import FooterSection from "../../Components/FooterSection.vue";
import moment from "moment";
import YouTube from "vue3-youtube";
import Swal from "sweetalert2";
import { useWindowSize } from "@vueuse/core";
import "vue-select/dist/vue-select.css";

const props = defineProps(["movieDetails"]);
const { height, width } = useWindowSize();

const state = reactive({
    items: [
        {
            text: "Back",
            // href: "javascript:void(0)"
        },
        {
            text: "Movie",
            active: true,
        },
    ],
});

onMounted(() => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
});

const currentUser = computed(() => {
    const theUser = usePage().props.auth.user;
    return theUser;
});

const movieCasts = computed(() => {
    const casts = props.movieDetails.moviecasts;
    const theCasts = casts.filter((item) => {
        if (item.type !== "crew") {
            return item;
        }
    });

    return theCasts;
});

const movieCrew = computed(() => {
    const casts = props.movieDetails.moviecasts;
    const theCasts = casts.filter((item) => {
        if (item.type == "crew") {
            return item;
        }
    });

    return theCasts;
});

const form = useForm({
    review: "",
    movie_id: props.movieDetails.id,
    user_id: usePage()?.props?.auth?.user?.id,
    submitted_by: usePage()?.props?.auth?.user?.name,
});

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

function goback() {
    if (window.history.length > 1) {
        window.history.back();
    }
}

function goLogin() {
    router.visit("/login");
}

function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}
function buyTicket() {
    router.visit(`/home/movie/buy-ticket/${slugify(props.movieDetails.title)}/${props.movieDetails.id}`);
}

function capitalizeFirstCharacter(str) {
    if (!str) return "";
    return str.charAt(0).toUpperCase();
}
</script>
<template>
    <Head :title="props.movieDetails.title" />

    <b-container class="" style="margin-top: 16em">
        <HomeHeader />
        <PageHeader :title="props.movieDetails.title" :items="state.items" @click="goback" />

        <div class="row">
            <div class="col-xl-3" v-if="width > 1024">
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
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-9" :class="[width < 1440? 'col-12':'']">
                <div class="card">
                    <div
                        class="card-body border-bottom background-container"
                        :style="{ backgroundImage: `url(${props.movieDetails.poster_url})` }"
                    ></div>
                    <div class="card-body">
                        <div class="flex-row d-flex col-12 justify-content-between">
                            <div class="mb-4 col-5">
                                <span class="badge badge-soft-primary me-3" v-for="(genre, index) in props.movieDetails.genres" :key="index">{{
                                    genre.name
                                }}</span>
                            </div>
                        </div>

                        <div class="mb-4 d-flex " :class="[width < 768? 'flex-column':'']">
                            <div class="d-flex me-5" v-if="props.movieDetails.director">
                                <div class="me-2"><label>Director:</label></div>
                                <div>{{ props.movieDetails.director }}</div>
                            </div>
                            <div class="d-flex me-5" v-if="props.movieDetails.writer">
                                <div class="me-2"><label>Writer:</label></div>
                                <div>{{ props.movieDetails.writer }}</div>
                            </div>
                            <div class="d-flex me-5" v-if="props.movieDetails.producer">
                                <div class="me-2"><label>Producer:</label></div>
                                <div>{{ props.movieDetails.producer }}</div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h5 class="mb-3 fw-semibold">Synopsis</h5>
                            <p class="text-muted" v-html="props.movieDetails.description"></p>
                        </div>


                        <div v-if="movieCasts.length > 0" class="mb-5">
                            <h6 class="mb-3 fw-semibold">Casts</h6>

                            <div class="flex-wrap gap-5 w-100 d-flex">
                                <div class="text-center" v-for="(moviecasts, index) in movieCasts" :key="index">
                                    <div v-if="moviecasts.profile_image_url" class="mb-4">
                                        <img
                                            :src="`${moviecasts.profile_image_url}`"
                                            :alt="'img'"
                                            class="rounded-circle avatar-sm object-fit-cover"
                                        />
                                    </div>
                                    <div v-else class="mx-auto mb-4 avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft bg-primary text-primary font-size-16">{{
                                            capitalizeFirstCharacter(moviecasts.name)
                                        }}</span>
                                    </div>
                                    <h5 class="font-size-13">
                                        <a href="javascript: void(0);" class="text-dark">{{ moviecasts.name }}</a>
                                    </h5>
                                    <p class="text-muted">{{ moviecasts.role }}</p>
                                </div>
                            </div>
                        </div>

                        <div v-if="movieCrew.length > 0" class="mb-5">
                            <h6 class="mb-3 fw-semibold">Crew Members</h6>

                            <div class="flex-wrap gap-5 w-100 d-flex">
                                <div class="text-center" v-for="(moviecasts, index) in movieCrew" :key="index">
                                    <div v-if="moviecasts.profile_image_url" class="mb-4">
                                        <img
                                            :src="`${moviecasts.profile_image_url}`"
                                            :alt="'img'"
                                            class="rounded-circle avatar-sm object-fit-cover"
                                        />
                                    </div>
                                    <div v-else class="mx-auto mb-4 avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft bg-primary text-primary font-size-16">{{
                                            capitalizeFirstCharacter(moviecasts.name)
                                        }}</span>
                                    </div>
                                    <h5 class="font-size-13">
                                        <a href="javascript: void(0);" class="text-dark">{{ moviecasts.name }}</a>
                                    </h5>
                                    <p class="text-muted">{{ moviecasts.role }}</p>
                                </div>
                            </div>
                        </div>
                        <div v-if="width > 768">
                            <div class="mb-5" v-if="props.movieDetails.trailer_url">
                                <h5 class="mb-3 fw-semibold">Trailer:</h5>
                                <YouTube :src="`${props.movieDetails.trailer_url}`" @ready="onReady" ref="youtube" />
                            </div>
                        </div>
                        <div v-else>
                            <div class="mb-5" v-if="props.movieDetails.trailer_url">
                                <h5 class="mb-3 fw-semibold">Trailer:</h5>
                                <YouTube :width="300" :height="180" :src="`${props.movieDetails.trailer_url}`" @ready="onReady" ref="youtube" />
                            </div>
                        </div>

                        <div v-if="width > 1023">
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
                            <form v-if="usePage().props.auth.user">
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
                            <div v-else class="mt-3 mb-3 text-center text-muted">
                                <div><span class="text-primary" role="button" @click="goLogin">Sign in</span> to sumbmit a review</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
    </b-container>
    <div class="mt-5">
        <FooterSection />
    </div>
</template>
<style scoped>
.background-container {
    width: 100%;
    height: 300px;
    background-color: grey;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
.horizontalScroll {
    overflow-x: auto;
    display: block;
    scroll-behavior: smooth;
    scrollbar-width: thin;
    scrollbar-color: #888 #f1f1f1;
}

.horizontalScroll::-webkit-scrollbar {
    height: 8px;
}

.horizontalScroll::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.horizontalScroll::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}
</style>
