<script setup>
import { Head, usePage,router } from "@inertiajs/vue3";
import { reactive, computed, ref } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import IsUserBeneficiary from "@/js/Composables/IsUserBeneficiary.js";
import useRequestBeneficiaryStatus from "@/js/Composables/useRequestBeneficiaryStatus.js";
import useScheduleMoviesPage from "@/js/Composables/useScheduleMoviesPage.js";
import useScheduleEventsPage from "@/js/Composables/useScheduleEventsPage";
import MyMoviesCard from "@/js/Components/MyMoviesCard.vue";
import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";

import icondata from "@/images/icondata.png";

const el = (ref < HTMLElement) | (null > null);

const props = defineProps({
    userMovies: {
        type: Object,
        required: true,
    },
});

const { isBeneficiary } = IsUserBeneficiary();

const state = reactive({
    items: [
        {
            text: "Dashboard",
            href: "javascript:void(0)",
        },
        {
            text: "Movies",
            active: true,
        },
    ],
});
const mymoviesBottom = ref(null);

const { paginatedItems, nextPageExists } = useInfiniteScroll("userMovies", mymoviesBottom);

const showMyMoviesDropdown = ref(true);
const selectedMovie = ref(null);
const viewMovies = ref(false);
const currentUser = computed(() => {
    const theUser = usePage().props.auth.user;
    return theUser;
});
function allMovies(){
    router.visit('allmovies')
}
</script>

<template>
    <Head title="My Movies" />

    <DashboardLayout>
        <PageHeader title="Movies" :items="state.items" />
        <div class="d-xl-flex">
            <div class="w-100">
                <div class="d-md-flex">
                    <div class="card filemanager-sidebar me-md-2">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-stretch">
                                <div class="mb-4">
                                    <div class="mb-3 d-grid">
                                        <b-dropdown toggle-class="w-100 btn-block" variant="light" v-if="isBeneficiary">
                                            <template #button-content> <i class="mdi mdi-plus me-1"></i> Create New </template>

                                            <b-dropdown-item @click="useScheduleMoviesPage">
                                                <i class="mdi mdi-play-circle-outline"></i>
                                                Movie</b-dropdown-item
                                            >
                                            <b-dropdown-item @click="useScheduleEventsPage"
                                                ><i class="mdi mdi-movie-roll me-1"></i> Event</b-dropdown-item
                                            >
                                        </b-dropdown>

                                        <div v-else-if="currentUser.user_type === 'beneficiary' && currentUser.beneficiary_status === 'inactive'">
                                            <b-button variant="light" :disabled="true">Request Pending Approval </b-button>
                                        </div>
                                        <div v-else>
                                            <b-button variant="primary" @click="useRequestBeneficiaryStatus(currentUser.id)"
                                                >Request Beneficiary Status</b-button
                                            >
                                        </div>
                                    </div>
                                    <ul class="mt-5 list-unstyled categories-list">
                                        <li>
                                            <div class="custom-accordion">
                                                <a
                                                    class="py-1 text-body fw-medium d-flex align-items-center"
                                                    data-toggle="collapse"
                                                    v-b-toggle.categories-collapse
                                                    role="button"
                                                    aria-expanded="false"
                                                    aria-controls="categories-collapse"
                                                >
                                                    <i class="mdi mdi-folder font-size-16 text-warning me-2"></i>
                                                    My Movies
                                                    <i
                                                        class="mdi mdi-chevron-up accor-down-icon ms-auto"
                                                        @click="showMyMoviesDropdown = !showMyMoviesDropdown"
                                                    ></i>
                                                </a>
                                                <b-collapse :visible="showMyMoviesDropdown" class="collapse show" id="categories-collapse">
                                                    <div class="mb-0 border-0 shadow-none card ps-2">
                                                        <ul class="mb-0 list-unstyled">
                                                            <li>
                                                                <a href="#" class="d-flex align-items-center"><span class="me-auto">All</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="d-flex align-items-center"
                                                                    ><span class="me-auto">Coming Soon</span> <i class="mdi mdi-pin ms-auto"></i
                                                                ></a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="d-flex align-items-center"
                                                                    ><span class="me-auto">Now Showing</span></a
                                                                >
                                                            </li>
                                                            <li>
                                                                <a href="#" class="d-flex align-items-center"
                                                                    ><span class="me-auto">Out of Theaters</span> <i class="mdi mdi-pin ms-auto"></i
                                                                ></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </b-collapse>
                                            </div>
                                        </li>

                                        <li>
                                            <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                                                <i class="mdi mdi-share-variant font-size-16 me-2"></i>
                                                <span class="me-auto">Reviews</span>
                                                <i class="mdi mdi-circle-medium text-danger ms-2"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                                                <i class="mdi mdi-star-outline text-muted font-size-16 me-2"></i>
                                                <span class="me-auto">Ratings</span>
                                            </a>
                                        </li>
                                        <li @click="allMovies" role="button">
                                            <a  class="text-body d-flex align-items-center">
                                                <i class="mdi mdi-play-circle-outline text-danger font-size-16 me-2"></i>
                                                <span class="me-auto">Other Movies</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- filemanager-leftsidebar -->

                    <div class="w-100 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body">
                                <div>
                                    <div class="mb-3 row">
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="mt-2">
                                                <h5>My Movies</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl-9 col-sm-6">
                                            <form class="mt-4 mt-sm-0 float-sm-end d-flex align-items-center">
                                                <div class="mb-2 search-box me-2">
                                                    <div class="position-relative">
                                                        <input
                                                            type="text"
                                                            class="rounded form-control bg-light border-light"
                                                            placeholder="Search..."
                                                        />
                                                        <i class="bx bx-search-alt search-icon"></i>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-4" />
                                <div>
                                    <div v-if="paginatedItems?.length > 0">
                                        <div class="row">
                                            <MyMoviesCard
                                                v-for="(movie, index) in paginatedItems"
                                                :key="`${index}_${movie.id}_${movie.title}`"
                                                :movieDetails="movie"
                                            />

                                            <div ref="mymoviesBottom"></div>
                                            <div v-if="nextPageExists" class="mt-4 text-center text-success">
                                                <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                            </div>
                                            <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="d-flex flex-column align-items-center" style="padding-top: 15vh; padding-bottom: 30vh">
                                            <div class="pt-5 mb-4"><img :src="icondata" :height="80" /></div>
                                            <div>No Movies Yet.</div>
                                            <div ref="mymoviesBottom"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end w-100 -->
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
