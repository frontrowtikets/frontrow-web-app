<script setup>
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { reactive, onMounted, ref } from "vue";
import PageHeader from "@/js/Components/page-header.vue";
import DashboardLayout from "@/js/Layouts/DashboardLayout.vue";
import useInertiaFormSubmit from "@/js/Composables/useInertiaFormSubmit.js";
import TagInput from "@mayank1513/vue-tag-input";
import "@mayank1513/vue-tag-input/style.css";
import axios from "axios";

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
    movieCategories: [],
    newMovieTags: [],
});

onMounted(async () => {
    const savedProps = props.eventCategories;
    const savedMovieProps = props.movieCategories;
    state.eventCategories = [...savedProps];
    state.movieCategories = [...savedMovieProps];

    //fetch banner images
    try {
        const options = {
            headers: {
                "Content-Type": "multipart/form-data",
                Authorization: `Bearer ${usePage().props.auth.user.api_token}`,
            },
        };
        const response = await axios.get("/api/images",options);
        savedImages.value = response.data.images;
    } catch (error) {
        console.error("Error fetching images:", error);
    }
});

const selectedImages = ref([]);
const savedImages = ref([]);
const fileInput = ref(null);
const saving = ref(false);

// Trigger file input programmatically
const triggerFileInput = () => {
    fileInput.value.click();
};

// Handle file selection
const onFileChange = (event) => {
    const files = Array.from(event.target.files);

    files.forEach((file) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            selectedImages.value.push({
                file: file,
                preview: e.target.result,
            });
        };
        reader.readAsDataURL(file);
    });
};

// Remove unsaved image
const removeUnsavedImage = (index) => {
    selectedImages.value.splice(index, 1);
};

// Save images to backend
const saveImages = async () => {
    if (selectedImages.value.length === 0) return;

    saving.value = true;
    const formData = new FormData();

    selectedImages.value.forEach((image) => {
        formData.append("images[]", image.file);
    });

    try {
         const options = {
            headers: {
                "Content-Type": "multipart/form-data",
                Authorization: `Bearer ${usePage().props.auth.user.api_token}`,
            },
        };
        const response = await axios.post("/api/images", formData, options);

        // Add newly saved images to savedImages
        savedImages.value.push(...response.data.images);

        // Clear selected images
        selectedImages.value = [];
    } catch (error) {
        console.error("Error saving images:", error);
        alert("Failed to save images");
    } finally {
        saving.value = false;
    }
};

// Delete image from database
const deleteImage = async (imageId) => {
    try {
         const options = {
            headers: {
                "Content-Type": "multipart/form-data",
                Authorization: `Bearer ${usePage().props.auth.user.api_token}`,
            },
        };
        await axios.delete(`/api/images/${imageId}`,options);

        // Remove from saved images
        savedImages.value = savedImages.value.filter((img) => img.id !== imageId);
    } catch (error) {
        console.error("Error deleting image:", error);
        alert("Failed to delete image");
    }
};

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
    console.log("now thiss", mergedArray);
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
                        <b-tab active title="System Configuration">
                            <div class="mt-5">
                                <div class="col-12">
                                    <div class="mt-5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-5 d-flex justify-content-between align-items-center">
                                                    <h6>Home Banner Images</h6>
                                                    <div>
                                                        <input
                                                            type="file"
                                                            ref="fileInput"
                                                            @change="onFileChange"
                                                            multiple
                                                            accept="image/*"
                                                            class="d-none"
                                                        />
                                                        <button class="btn btn-primary me-2" @click="triggerFileInput">Add Images</button>
                                                        <button
                                                            v-if="selectedImages.length > 0"
                                                            class="btn btn-success"
                                                            @click="saveImages"
                                                            :disabled="saving"
                                                        >
                                                            <i class="align-middle bx bx-loader bx-spin font-size-16 me-2" v-if="saving"></i>
                                                            {{ saving ? "Saving..." : "Save Changes" }}
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="mb-5">
                                                    <div class="row g-3">
                                                        <!-- Unsaved Selected Images -->
                                                        <div
                                                            v-for="(image, index) in selectedImages"
                                                            :key="`unsaved-${index}`"
                                                            class="col-md-3 position-relative"
                                                        >
                                                            <div class="image-wrapper">
                                                                <img :src="image.preview" class="img-fluid rounded" alt="Selected Image" />
                                                                <button
                                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                                                    @click="removeUnsavedImage(index)"
                                                                >
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Saved Images from Database -->
                                                        <div v-for="image in savedImages" :key="image.id" class="col-md-3 position-relative">
                                                            <div class="image-wrapper">
                                                                <img :src="image.url" class="img-fluid rounded" alt="Saved Image" />
                                                                <button
                                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                                                    @click="deleteImage(image.id)"
                                                                >
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </b-tab>
                        <b-tab title="Events">
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
                                <h6>Categories(Genres)</h6>
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
<style scoped>
.image-wrapper {
    position: relative;
    margin-bottom: 1rem;
}

.image-wrapper img {
    width: 500px;
    height: 250px;
    object-fit: cover;
}

.image-wrapper .btn-danger {
    position: absolute;
    top: 10px;
    right: 10px;
}
</style>
