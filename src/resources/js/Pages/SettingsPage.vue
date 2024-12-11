<script setup>
import { Head } from "@inertiajs/vue3";
import { reactive, onMounted } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import useInertiaFormSubmit from "@/js/Composables/useInertiaFormSubmit.js";
import TagInput from "@mayank1513/vue-tag-input";
import "@mayank1513/vue-tag-input/style.css";

const props = defineProps({
    eventCategories: {
        type: Array,
        default: [],
    },
     movieCategories: {
        type: Array,
        default: [],
    },
});

const state = reactive({
    items: [
        {
            text: "Dashboard",
            href: "javascript:void(0)",
        },
        {
            text: "Settings",
            active: true,
        },
    ],
    eventCategories: [],
    newTags: [],
    movieCategories:[],
    newMovieTags:[]
});

onMounted(() => {
    const savedProps = props.eventCategories;
    const savedMovieProps = props.movieCategories;
    state.eventCategories = [...savedProps];
    state.movieCategories = [...savedMovieProps]
});

function saveEventSettings() {
    const mergedArray = [...new Set([...state.eventCategories, ...state.newTags])];
    useInertiaFormSubmit(
        {
            eventCategories: mergedArray,
        },
        "admin/saveeventssettings",
        "/settings",
        "You are about to save changes",
        "Changes have been saved successfully"
    );
    state.newTags = [];

}

function revokeCategory(removecat) {
    state.eventCategories = state.eventCategories.filter((cat) => cat !== removecat);
}

function saveMovieSettings() {
    const mergedArray = [...new Set([...state.movieCategories, ...state.newMovieTags])];
    console.log('now thiss',mergedArray)
    useInertiaFormSubmit(
        {
            movieCategories: mergedArray,
        },
        "admin/savemoviessettings",
        "/settings",
        "You are about to save changes",
        "Changes have been saved successfully"
    );
    state.newMovieTags = [];
}

function revokeMovieCategory(removecat) {
    state.movieCategories = state.movieCategories.filter((cat) => cat !== removecat);
}
</script>

<template>
    <Head title="Settings" />

    <DashboardLayout>
        <PageHeader title="Settings" :items="state.items" />
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <b-tabs>
                        <b-tab active title="Events">
                            <div class="mt-5">
                                <div class="col-12 col-md-6">
                                    <h6>Categories</h6>
                                    <div class="mt-2 w-100">
                                        <span role="button" v-for="(cat, index) in state.eventCategories" :key="`${index}_${cat}`">
                                            <span class="mb-3 badge badge-soft-primary font-size-11 me-4" @click="revokeCategory(cat)"
                                                >{{ cat }}<i class="bx bxs-x-circle text-danger ps-1 pe-1" role="button"></i
                                            ></span>
                                        </span>
                                        <div>
                                            <TagInput v-model="state.newTags" :tagBgColor="'rgb(0, 196, 206)'" />
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <b-button variant="primary" @click="saveEventSettings"> Save Changes </b-button>
                                    </div>
                                </div>
                            </div>
                        </b-tab>
                        <b-tab title="Movies">
                            <div class="mt-5">
                                <h6>Categories</h6>
                                <div class="mt-2 w-100">
                                    <span role="button" v-for="(cat, index) in state.movieCategories" :key="`${index}_${cat}`">
                                        <span class="mb-3 badge badge-soft-primary font-size-11 me-4" @click="revokeMovieCategory(cat)"
                                            >{{ cat }}<i class="bx bxs-x-circle text-danger ps-1 pe-1" role="button"></i
                                        ></span>
                                    </span>
                                    <div>
                                        <TagInput v-model="state.newMovieTags" :tagBgColor="'rgb(0, 196, 206)'" />
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <b-button variant="primary" @click="saveMovieSettings"> Save Changes </b-button>
                                </div>
                            </div>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
