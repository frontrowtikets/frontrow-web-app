<script setup>
import { computed } from "vue";
import moment from "moment";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import IsUserAdmin from "../Composables/IsUserAdmin.js";
import useInertiaFormSubmit from "@/js/Composables/useInertiaFormSubmit.js";

const props = defineProps(["movieDetails"]);

const emit = defineEmits(["viewDetails"]);

const { isAdmin } = IsUserAdmin();

const creationTime = computed(() => {
    return moment(props.movieDetails?.updated_at).fromNow();
});

function slugify(title) {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
}
function viewMovieDetails() {
    router.visit(
        `/movie/${slugify(props.movieDetails.title)}/${props.movieDetails.id}`
    );
}
function viewMoviesManager() {

    router.visit(`/moviemanager/${slugify(props.movieDetails.title)}/${props.movieDetails.id}`)
}
function activateMovie() {

    useInertiaFormSubmit(
        {
            movieId: props.movieDetails.id,
        },
        "admin/activateMovie",
        "/activations",
        "You are about to activate this movie",
        "Changes have successfully activated the movie"
    );
}
function deactivateMovie() {
    useInertiaFormSubmit(
        {
            movieId: props.movieDetails.id,
        },
        "admin/deactivateMovie",
        "/activations",
        "You are about to deactivated this movie",
        "Changes have successfully deactivated the movie"
    );
}
function editMovie() {
    router.get(`/edit_movie/${props.movieDetails.id}`);
}
function deleteMovie() {
    router.get(`/delete_movie/${props.movieDetails.id}`);
}
</script>
<template>
    <div class="col-xl-4 col-sm-6">
        <div class="border shadow-none card">
            <div class="p-3 card-body" role="button">
                <div class="mb-3">
                    <img :src="props.movieDetails?.thumbnail_url" :alt="props.movieDetails?.title"
                        class="object-cover rounded w-100" style="height: 200px; object-fit: cover;" />
                </div>
                <div class="">
                    <div class="float-end ms-2">
                        <b-dropdown toggle-class="p-0 font-size-16 text-muted" class="mb-2" variant="white"
                            menu-class="dropdown-menu-end" right>
                            <b-dropdown-item @click="viewMovieDetails">View Details</b-dropdown-item>
                            <b-dropdown-item v-if="
                                props.movieDetails?.is_active == false &&
                                isAdmin
                            " @click="activateMovie">Activate</b-dropdown-item>
                            <b-dropdown-item v-if="
                                props.movieDetails?.is_active == true &&
                                isAdmin
                            " @click="deactivateMovie">Deactivate</b-dropdown-item>
                            <b-dropdown-item @click="editMovie">Update</b-dropdown-item>
                            <b-dropdown-item @click="viewMoviesManager">Ticket Sales</b-dropdown-item>
                            <b-dropdown-item @click="viewMoviesManager">Manage Movie</b-dropdown-item>
                            <b-dropdown-divider></b-dropdown-divider>
                            <b-dropdown-item @click="deleteMovie"><span
                                    class="text-danger">Delete</span></b-dropdown-item>
                        </b-dropdown>
                    </div>
                    <div class="mb-3 avatar-xs me-3" @click="viewMovieDetails">
                        <div class="bg-transparent rounded avatar-title">
                            <i class="bx bx-play-circle font-size-24 text-secondary"></i>
                        </div>
                    </div>
                    <div class="d-flex" @click="viewMovieDetails">
                        <div class="overflow-hidden me-auto">
                            <h5 class="mb-1 font-size-14 text-truncate">
                                <a href="javascript: void(0);" class="text-body">{{ props.movieDetails?.title }}
                                </a>
                            </h5>

                            <small class="mb-0 text-muted text-truncate">
                                {{ creationTime }}
                                <span class="ms-3 badge badge-soft-danger" v-if="
                                    props.movieDetails?.is_active == false
                                ">Pending Approval</span>
                                <span class="ms-3 badge badge-soft-success" v-if="
                                    props.movieDetails?.is_active == true
                                ">Active</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
