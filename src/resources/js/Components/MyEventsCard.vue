<script setup>
import { computed } from 'vue';
import moment from 'moment';
import { Head, Link, router, usePage } from "@inertiajs/vue3";


const props = defineProps(['eventDetails']);

const emit  = defineEmits(['viewDetails']);

const creationTime = computed(()=>{
    return moment(props.eventDetails.updated_at).fromNow()
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
</script>
<template>
    <div class="col-xl-4 col-sm-6">
        <div class="border shadow-none card">
            <div class="p-3 card-body" role="button" >
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
                            <b-dropdown-item href="#">Edit</b-dropdown-item>
                            <b-dropdown-item href="#">Tickets Sold</b-dropdown-item>
                            <b-dropdown-item href="#">Event Manager</b-dropdown-item>
                            <b-dropdown-divider></b-dropdown-divider>
                            <b-dropdown-item href="#" ><span class="text-danger">Delete</span></b-dropdown-item>
                        </b-dropdown>
                    </div>
                    <div class="mb-3 avatar-xs me-3" @click="viewEventsDetails">
                        <div class="bg-transparent rounded avatar-title">
                            <i
                                class="bx bxs-folder font-size-24 text-warning"
                            ></i>
                        </div>
                    </div>
                    <div class="d-flex" @click="viewEventsDetails">
                        <div class="overflow-hidden me-auto">
                            <h5 class="mb-1 font-size-14 text-truncate">
                                <a href="javascript: void(0);" class="text-body"
                                    >{{props.eventDetails.title}}
                                </a>
                            </h5>
                            <small class="mb-0 text-muted text-truncate">
                                {{ creationTime }}
                            </small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
