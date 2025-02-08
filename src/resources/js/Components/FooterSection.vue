<script setup>
import { router } from "@inertiajs/vue3";
import axios from "axios";

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

function toLogin() {
    router.visit("/login");
}
function toRegister() {
    router.visit("/register");
}
function goEvents() {
    router.visit("/myevents");
}
function createEvent() {
    router.visit("/dashboard");
}
function createMovie() {
    router.visit("/dashboard");
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
function testMail1() {
    axios
        .post(
            "/api/testthismail",
            {},
            {
                headers: {
                    Accept: "application/json",
                },
            }
        )
        .then((res) => {
            console.log("ress", res);
        })

        .catch((err) => {});
}
function testMail2() {
    axios
        .post(
            "/api/testthismail2",
            {},
            {
                headers: {
                    Accept: "application/json",
                },
            }
        )
        .then((res) => {
            console.log("ress", res);
        })

        .catch((err) => {});
}
</script>

<template>
    <!-- Footer start -->
    <footer class="pt-5 landing-footer bg-primary">
        <b-container>
            <div class="row" style="border-bottom: 1px solid #67babf">
                <div class="col-lg-3 col-sm-6">
                    <div class="mb-lg-0">
                        <h5 class="mb-3 footer-list-title">Platform</h5>
                        <ul class="list-unstyled footer-list-menu">
                            <li @click="goToMoviesPage" role="button">
                                <a>Buy Tickets</a>
                            </li>
                            <li @click="createEvent" role="button">
                                <a>Sell Event Tickets</a>
                            </li>
                            <li @click="createMovie" role="button">
                                <a>Sell Movie Tickets</a>
                            </li>
                            <!-- <li @click="goToMoviesPage" role="button">
                                <a>Cinemas</a>
                            </li> -->
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="mb-lg-0">
                        <h5 class="mb-3 footer-list-title">Links</h5>
                        <ul class="list-unstyled footer-list-menu">
                            <li @click="toRegister" role="button">
                                <a>Create Account</a>
                            </li>
                            <li @click="toLogin" role="button">
                                <a>Sign in </a>
                            </li>
                            <li @click="goDashboard" role="button">
                                <a>Go to Dashboard</a>
                            </li>
                            <!-- <li @click="testMail1" >
                                <a>TestMail1</a>
                            </li>
                            <li @click="testMail2">
                                <a>Testmail2</a>
                            </li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="mb-lg-0">
                        <h5 class="footer-list-title">
                            Download Our Application
                        </h5>
                        <div class="blog-post">
                            <div class="flex-row gap-5 d-flex">
                                <div @click="downloadApk" role="button">
                                    <img
                                        src="../../images/playstore.svg"
                                        alt
                                        height="100"
                                    />
                                </div>
                                <div @click="downloadApk" role="button">
                                    <img
                                        src="../../images/appstore.svg"
                                        alt
                                        height="100"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="mt-4 d-flex justify-content-between">
                <div class="col-lg-6">
                    <div>
                        <!-- <div class="">
                            <div class="text-lg text-white fw-bold">
                                FRONTROW
                            </div>
                        </div> -->

                        <p class="mb-2">
                            {{ new Date().getFullYear() }} © FRONTROW. Design &
                            Developed by the CinemaUg
                        </p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="text-lg text-white fw-bold me-3">
                        Follow us:
                    </div>
                    <div class="d-flex">
                        <div @click="" role="button" class="me-3" >
                            <img
                                src="../../images/facebook.svg"
                                alt
                                height="15"
                            />
                        </div>
                        <div @click="" role="button" class="me-3">
                            <img
                                src="../../images/instagram.svg"
                                alt
                                height="19"
                            />
                        </div>
                        <div @click="" role="button" class="me-3">
                            <img
                                src="../../images/twitter.svg"
                                alt
                                height="15"
                            />
                        </div>
                        <div @click="" role="button" class="">
                            <img
                                src="../../images/youtube.svg"
                                alt
                                height="19"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </b-container>
        <!-- end container -->
    </footer>
    <!-- Footer end -->
</template>
