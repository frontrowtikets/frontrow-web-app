<script setup>

import { router } from "@inertiajs/vue3";

function downloadApk() {
    const fileUrl = `/FRONTROW_V1.0.1.apk`;

    const a = document.createElement("a");
    a.href = fileUrl;
    a.download = "FRONTROW_V1.0.1.apk";
    document.body.appendChild(a);
    a.click();
    URL.revokeObjectURL(fileURL);
    document.body.removeChild(a);
}

function toLogin(){
     router.visit("/login");
}
function toRegister(){
     router.visit("/register");
}
function goEvents() {
    router.visit("/myevents");
}
function createEvent() {
    router.visit("/scheduleevents");
}
function goToEventsPage() {
    router.visit("/events");
}
function goToMoviesPage() {
    router.visit("/movies");
}
function goDashboard() {
    router.visit("/dashboard");
}
</script>

<template>
    <!-- Footer start -->
    <footer class="pt-5 landing-footer bg-primary">
        <b-container>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="mb-4 mb-lg-0">
                        <h5 class="mb-3 footer-list-title">Platform</h5>
                        <ul class="list-unstyled footer-list-menu">
                            <li @click="goToMoviesPage" role="button">
                                <a>Buy Tickets</a>
                            </li>
                            <li @click="createEvent" role="button">
                                <a >Create Event</a>
                            </li>
                            <li @click="goToEventsPage" role="button">
                                <a >Events</a>
                            </li>
                            <li @click="goToMoviesPage" role="button">
                                <a>Cinemas</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="mb-4 mb-lg-0">
                        <h5 class="mb-3 footer-list-title">Links</h5>
                        <ul class="list-unstyled footer-list-menu">
                            <li @click="toRegister" role="button">
                                <a >Create Account</a>
                            </li>
                            <li @click="toLogin" role="button">
                                <a >Sign in </a>
                            </li>
                            <li @click="goDashboard">
                                <a >Go to Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class=" mb-lg-0">
                        <h5 class=" footer-list-title">
                            Download Our Application
                        </h5>
                        <div class="blog-post">

                            <div class="flex-row gap-5 d-flex">
                                <div @click="downloadApk" role="button">
                                    <img
                                        src="../../images/playstore.svg"
                                        alt
                                        height="120"
                                    />
                                </div>
                                <div @click="downloadApk" role="button">
                                    <img
                                        src="../../images/appstore.svg"
                                        alt
                                        height="120"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <hr class="my-5 footer-border" />

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-2">
                        <div class="text-lg text-white fw-bold">FRONTROW</div>
                    </div>

                    <p class="mb-2">
                        {{ new Date().getFullYear() }} © FRONTROW. Design &
                        Developed by the CinemaUg
                    </p>
                    <p>Movies & Beyound</p>
                </div>
            </div>
        </b-container>
        <!-- end container -->
    </footer>
    <!-- Footer end -->
</template>
