<script setup>
import { ref, reactive, onMounted } from "vue";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import ActionMessage from "@/js/Components/ActionMessage.vue";
import FormSection from "@/js/Components/FormSection.vue";
import InputError from "@/js/Components/InputError.vue";
import InputLabel from "@/js/Components/InputLabel.vue";
import PrimaryButton from "@/js/Components/PrimaryButton.vue";
import SecondaryButton from "@/js/Components/SecondaryButton.vue";
import TextInput from "@/js/Components/TextInput.vue";

const props = defineProps({
    user: Object,
});

const state = reactive({
    name: "",
    email: "",
    photo: null,
});

onMounted(() => {
    if (usePage().props.auth.user) {
        state.name = usePage().props.auth.user.name;

        state.email = usePage().props.auth.user.email;
    }
});
const form = useForm({
    _method: "PUT",
    name: usePage().props.auth.user.name,
    email: usePage().props.auth.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);
const singleInputID = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
        onError: (e) => {
            console.log("thi is the error", e);
        },
    });
};

const updateProfileDetails = () => {
    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onCancel: (e) => {
            console.log("thi is the error", e);
        },
    });
    router.reload();
};
const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    state.photo = photo;
    form.photo = photo;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
            router.reload();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <form>
        <!-- Profile Photo -->
        <div v-if="$page.props.jetstream.managesProfilePhotos" class="mb-4">
            <!-- Profile Photo File Input -->

            <label for="photo">Profile Picture</label>
            <input ref="photoInput" type="file" class="invisible" @change="updatePhotoPreview" />

            <!-- Current Profile Photo -->
            <div v-show="!photoPreview" class="mt-2 mb-4">
                <img :src="user.profile_photo_url" :alt="user.name" class="rounded-circle avatar-md object-fit-cover" />
            </div>

            <!-- New Profile Photo Preview -->
            <div v-show="photoPreview" class="mt-2 mb-4">
                <img class="rounded-circle avatar-md object-fit-cover" :alt="user.name" :src="photoPreview" />
            </div>

            <div class="d-flex flex-row col-md-6 gap-3">
                <div>
                    <b-button variant="primary" @click="selectNewPhoto">Change Profile Picture</b-button>
                </div>

                <div v-if="user.profile_photo_path" type="button" class="mt-2 text-danger" @click.prevent="deletePhoto"><i class="fas fa-trash-alt"></i></div>
            </div>

            <InputError :message="form.errors.photo" class="mt-2" />
        </div>

        <!-- staff profile details  -->

        <!-- Email Verification-->
        <div class="alert alert-primary alert-dismissible fade show" role="alert" v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
            <div class="mb-4">
                <div class="mb-2">Your email address is unverified.</div>

                <Link :href="route('verification.send')" method="post" @click.prevent="sendEmailVerification">
                    <b-button variant="primary" @click="sendEmailVerification">Click here to re-send the verification email.</b-button>
                </Link>
            </div>

            <div v-show="verificationLinkSent" class="mt-2 mb-4 text-success">A new verification link has been sent to your email address.</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="mt-2">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="staff_names">NAME</label>
                    <input class="form-control" id="staff_names" type="text" v-model="form.name" placeholder="Name" />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="staff_names">Email</label>
                    <input class="form-control" id="staff_names" type="text" v-model="form.email" placeholder="Email" />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
            </div>
        </div>

        <b-button variant="primary" @click="updateProfileInformation">Save Changes</b-button>
    </form>
</template>
