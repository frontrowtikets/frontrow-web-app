<script setup>
import { computed } from 'vue';
import moment from 'moment';
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import IsUserAdmin from "../Composables/IsUserAdmin.js";
import useInertiaFormSubmit from "@/js/Composables/useInertiaFormSubmit.js";



const props = defineProps(['eventDetails']);

const emit  = defineEmits(['viewDetails']);

const { isAdmin } = IsUserAdmin();


const creationTime = computed(()=>{
    return moment(props.eventDetails?.updated_at).fromNow()
})

function slugify(title){
     return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
}
function viewEventsDetails(){

    router.visit(`/event/${slugify(props.eventDetails.title)}/${props.eventDetails.id}`)
}
function viewEventsManager(){

    router.visit(`/eventmanager/${slugify(props.eventDetails.title)}/${props.eventDetails.id}`)
}
function activateEvent(){
useInertiaFormSubmit(
        {
            eventId: props.eventDetails.id,
        },
        "admin/activateEvent",
        "/activations",
        "You are about to activate this event",
        "Changes have successfully activated the event"
    );
}
function deactivateEvent(){
useInertiaFormSubmit(
        {
            eventId: props.eventDetails.id,
        },
        "admin/deactivateEvent",
        "/activations",
        "You are about to deactivated this event",
        "Changes have successfully deactivated the event"
    );
}
function editEvent() {
    router.get(`/edit_event/${props.eventDetails.id}`);
}
function deleteEvent() {
    router.get(`/delete_event/${props.eventDetails.id}`);
}
</script>
<template>
    <div class="col-xl-4 col-sm-6">
        <div class="border shadow-none card">
            <div class="p-3 card-body" role="button" >
                <div class="mb-3">
                    <img
                        :src="props.eventDetails?.thumbnail_url"
                        :alt="props.eventDetails?.title"
                        class="object-cover rounded w-100"
                        style="height: 200px; object-fit: cover;"
                    />
                </div>
                <div class="">
                    <div class="float-end ms-2">
                        <b-dropdown
                            toggle-class="p-0 font-size-16 text-muted"
                            class="mb-2"
                            variant="white"
                            menu-class="dropdown-menu-end"
                            right
                        >


                            <b-dropdown-item @click="viewEventsDetails"
                                >View Details</b-dropdown-item
                            >
                            <b-dropdown-item v-if="props.eventDetails?.is_active == false && isAdmin" @click="activateEvent"
                                >Activate</b-dropdown-item
                            >
                            <b-dropdown-item v-if="props.eventDetails?.is_active == true && isAdmin" @click="deactivateEvent"
                                >Deactivate</b-dropdown-item
                            >
                            <b-dropdown-item @click="editEvent">Update</b-dropdown-item>
                            <b-dropdown-item @click="viewEventsManager">Tickets Sold</b-dropdown-item>
                            <b-dropdown-item @click="viewEventsManager">Manage Event</b-dropdown-item>
                            <b-dropdown-divider></b-dropdown-divider>
                            <b-dropdown-item @click="deleteEvent" ><span class="text-danger">Delete</span></b-dropdown-item>
                        </b-dropdown>
                    </div>
                    <div class="mb-3 avatar-xs me-3" @click="viewEventsDetails">
                        <div class="bg-transparent rounded avatar-title">
                            <i
                                class="mdi mdi-movie-roll font-size-24 text-secondary"
                            ></i>
                        </div>
                    </div>
                    <div class="d-flex" @click="viewEventsDetails">
                        <div class="overflow-hidden me-auto">
                            <h5 class="mb-1 font-size-14 text-truncate">
                                <a href="javascript: void(0);" class="text-body"
                                    >{{props.eventDetails?.title}}
                                </a>
                            </h5>
                            <small class="mb-0 text-muted text-truncate">
                                {{ creationTime }}
                                <span
                                    class="ms-3 badge badge-soft-danger"
                                    v-if="
                                        props.eventDetails?.is_active == false
                                    "
                                    >Pending Approval</span
                                >
                                <span
                                    class="ms-3 badge badge-soft-success"
                                    v-if="
                                        props.eventDetails?.is_active == true
                                    "
                                    >Active</span
                                >
                            </small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
