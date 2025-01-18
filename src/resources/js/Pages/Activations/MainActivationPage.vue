<script setup>
import { Head, usePage, router } from "@inertiajs/vue3";
import { reactive, computed, ref } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import IsUserBeneficiary from "@/js/Composables/IsUserBeneficiary.js";
import useRequestBeneficiaryStatus from "@/js/Composables/useRequestBeneficiaryStatus.js";
import useScheduleMoviesPage from "@/js/Composables/useScheduleMoviesPage.js";
import useScheduleEventsPage from "@/js/Composables/useScheduleEventsPage";
import MyEventsCard from "@/js/Components/MyEventsCard.vue";
import MyMoviesCard from "@/js/Components/MyMoviesCard.vue";

import { useInfiniteScroll } from "../../Composables/useInfiniteScroll.js";

import icondata from "@/images/icondata.png";

const el = (ref < HTMLElement) | (null > null);

const props = defineProps({
    pendingEvents: {
        type: Array,
        default: [],
    },
    pendingMovies: {
        type: Array,
        default: [],
    },
    activatedEvents: {
        type: Array,
        default: [],
    },
    activatedMovies: {
        type: Array,
        default: [],
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

const selectedOption = ref("pendingMovies");

const pendingMoviesBottom = ref(null);
const pendingEventsBottom = ref(null);
const activatedMoviesBottom = ref(null);
const activatedEventsBottom = ref(null);

const { paginatedItems: pendingMoviesPaginatedItems, nextPageExists: pendingMoviesNextPageExists } = useInfiniteScroll(
    "pendingMovies",
    pendingMoviesBottom
);
const { paginatedItems: pendingEventsPaginatedItems, nextPageExists: pendingEventsNextPageExists } = useInfiniteScroll(
    "pendingEvents",
    pendingEventsBottom
);
const { paginatedItems: activatedMoviesPaginatedItems, nextPageExists: activatedMoviesNextPageExists } = useInfiniteScroll(
    "activatedMovies",
    activatedMoviesBottom
);
const { paginatedItems: activatedEventsPaginatedItems, nextPageExists: activatedEventsNextPageExists } = useInfiniteScroll(
    "activatedEvents",
    activatedEventsBottom
);

function allEvents() {
    router.visit("/allevents");
}
function setOption(theOption) {
    selectedOption.value = theOption;
}
</script>

<template>
    <Head title="Activations" />

    <DashboardLayout>
        <PageHeader title="Activations" :items="state.items" />
        <div class="d-xl-flex">
            <div class="w-100">
                <div class="d-md-flex">
                    <div class="card filemanager-sidebar me-md-2">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-stretch">
                                <div class="mb-4">
                                    <div class="mb-3 d-grid">
                                        <b-dropdown toggle-class="w-100 btn-block" variant="light">
                                            <template #button-content> <i class="mdi mdi-eye-outline me-1"></i> View Activated</template>
                                            <b-dropdown-item @click="useScheduleEventsPage"
                                                ><i class="mdi mdi-movie-roll me-1"></i> Events</b-dropdown-item
                                            >
                                            <b-dropdown-item @click="useScheduleMoviesPage">
                                                <i class="mdi mdi-play-circle-outline"></i>
                                                Movies</b-dropdown-item
                                            >
                                        </b-dropdown>
                                    </div>
                                    <ul class="mt-5 list-unstyled categories-list">
                                        <li @click="setOption('pendingMovies')">
                                            <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                                                <i class="bx bx-play font-size-16 me-2"></i>
                                                <span class="me-auto">Pending Movies</span>
                                                <i class="mdi mdi-circle-medium text-danger ms-2"></i>
                                            </a>
                                        </li>
                                        <li @click="setOption('pendingEvents')">
                                            <a href="javascript: void(0);" class="text-body d-flex align-items-center">
                                                <i class="bx bxs-movie font-size-16 me-2"></i>
                                                <span class="me-auto">Pending Events</span>
                                                <i class="mdi mdi-circle-medium text-danger ms-2"></i>
                                            </a>
                                        </li>

                                        <li @click="setOption('activatedMovies')" role="button">
                                            <a class="text-body d-flex align-items-center">
                                                <i class="bx bx-play-circle text-danger font-size-16 me-2"></i>
                                                <span class="me-auto">Activated Movies</span>
                                            </a>
                                        </li>
                                        <li @click="setOption('activatedEvents')" role="button">
                                            <a class="text-body d-flex align-items-center">
                                                <i class="bx bxs-movie text-danger font-size-16 me-2"></i>
                                                <span class="me-auto">Activated Events</span>
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
                            <div class="card-body" v-if="selectedOption == 'pendingMovies'">
                                <div>
                                    <div class="mb-3 row">
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="mt-2">
                                                <h5>Pending Movies</h5>
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
                                    <div v-if="pendingMoviesPaginatedItems?.length > 0">
                                        <div class="row">
                                            <MyMoviesCard
                                                v-for="(movie, index) in pendingMoviesPaginatedItems"
                                                :key="`${index}_${movie.id}_${movie.title}`"
                                                :movieDetails="movie"
                                            />

                                            <div ref="pendingMoviesBottom"></div>
                                            <div v-if="pendingMoviesNextPageExists" class="mt-4 text-center text-success">
                                                <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                            </div>
                                            <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="d-flex flex-column align-items-center" style="padding-top: 15vh; padding-bottom: 30vh">
                                            <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                            <div>No Movies Yet.</div>
                                            <div ref="pendingMoviesBottom"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" v-if="selectedOption == 'pendingEvents'">
                                <div>
                                    <div class="mb-3 row">
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="mt-2">
                                                <h5>Pending Events</h5>
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
                                    <div v-if="pendingEventsPaginatedItems?.length > 0">
                                        <div class="row">
                                            <MyEventsCard
                                                v-for="(event, index) in pendingEventsPaginatedItems"
                                                :key="`${index}_${event.id}_${event.title}`"
                                                :eventDetails="event"
                                            />

                                            <div ref="pendingEventsBottom"></div>
                                            <div v-if="pendingEventsNextPageExists" class="mt-4 text-center text-success">
                                                <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                            </div>
                                            <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="d-flex flex-column align-items-center" style="padding-top: 15vh; padding-bottom: 30vh">
                                            <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                            <div>No Events Yet.</div>
                                            <div ref="pendingEventsBottom"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" v-if="selectedOption == 'activatedMovies'">
                                <div>
                                    <div class="mb-3 row">
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="mt-2">
                                                <h5>Activated Movies</h5>
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
                                    <div v-if="activatedMoviesPaginatedItems?.length > 0">
                                        <div class="row">
                                            <MyMoviesCard
                                                v-for="(movie, index) in activatedMoviesPaginatedItems"
                                                :key="`${index}_${movie.id}_${movie.title}`"
                                                :movieDetails="movie"
                                            />

                                            <div ref="activatedMoviesBottom"></div>
                                            <div v-if="activatedMoviesNextPageExists" class="mt-4 text-center text-success">
                                                <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                            </div>
                                            <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="d-flex flex-column align-items-center" style="padding-top: 15vh; padding-bottom: 30vh">
                                            <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                            <div>No Movies Yet.</div>
                                            <div ref="activatedMoviesBottom"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" v-if="selectedOption == 'activatedEvents'">
                                <div>
                                    <div class="mb-3 row">
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="mt-2">
                                                <h5>Activated Events</h5>
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
                                    <div v-if="activatedEventsPaginatedItems?.length > 0">
                                        <div class="row">
                                            <MyEventsCard
                                                v-for="(event, index) in activatedEventsPaginatedItems"
                                                :key="`${index}_${event.id}_${event.title}`"
                                                :eventDetails="event"
                                            />

                                            <div ref="activatedEventsBottom"></div>
                                            <div v-if="activatedEventsNextPageExists" class="mt-4 text-center text-success">
                                                <i class="bx bx-hourglass bx-spin font-size-18 me-2"></i> Loading more
                                            </div>
                                            <div v-else class="mt-4 text-center text-primary">No More Data</div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="d-flex flex-column align-items-center" style="padding-top: 15vh; padding-bottom: 30vh">
                                            <div class="pt-5 mb-4"><img :src="icondata" :height="50" /></div>
                                            <div>No Events Yet.</div>
                                            <div ref="activatedEventsBottom"></div>
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
