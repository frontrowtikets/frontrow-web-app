<script setup>
import { router } from "@inertiajs/vue3";
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";
import axios from "axios";

const breakpoints = useBreakpoints(breakpointsTailwind);

const greaterThanSm = breakpoints.greater("md");

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

function toPrivacyPolicy() {
    router.visit("/privacy-policy");
}

function toTermsAndConditions() {
    router.visit("/terms-and-conditions");
}

function toDeleteAccount() {
    router.visit("/delete-my-account");
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
    <footer class="pt-3 pb-2 landing-footer bg-primary">
        <b-container v-if="greaterThanSm">
            <div class="row">
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
                        <h5 class="mb-3 footer-list-title">Company</h5>
                        <ul class="list-unstyled footer-list-menu">
                            <li @click="toDeleteAccount" role="button">
                                <a>Delete My Account</a>
                            </li>
                            <li @click="toPrivacyPolicy" role="button">
                                <a>Privacy Policy</a>
                            </li>
                            <li @click="toTermsAndConditions" role="button">
                                <a>Terms & Conditions</a>
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

                <div class="col-lg-3 col-sm-6 text-end">
                    <div class="mb-lg-0">
                        <h5 class="footer-list-title">Follow Us</h5>
                        <div
                            class="gap-3 pt-2 d-flex flex-column align-items-end"
                        >
                            <div
                                role="button"
                                class="right-auto d-flex justify-content-between"
                                style="width: 35%"
                            >
                                <a
                                    :href="`https://www.instagram.com/frontrowtikets?igsh=ZmVmajFlb3k1MzU4`"
                                    target="_blank"
                                >
                                    <img
                                        src="../../images/instagram.svg"
                                        alt
                                        height="19"
                                /></a>
                                <a
                                    :href="`https://www.instagram.com/frontrowtikets?igsh=ZmVmajFlb3k1MzU4`"
                                    target="_blank"
                                    class="text-light"
                                    >Instagram</a
                                >
                            </div>
                            <div
                                role="button"
                                class="right-auto d-flex justify-content-between"
                                style="width: 35%"
                            >
                                <a
                                    :href="`https://www.tiktok.com/@frontrowtikets?_t=ZM-8u2RAENRACU&_r=1`"
                                    target="_blank"
                                >
                                    <img
                                        src="../../images/tiktok.svg"
                                        alt
                                        height="20"
                                /></a>
                                <a
                                    :href="`https://www.tiktok.com/@frontrowtikets?_t=ZM-8u2RAENRACU&_r=1`"
                                    target="_blank"
                                    class="text-light"
                                    >TikTok</a
                                >
                            </div>
                            <div
                                role="button"
                                class="right-auto d-flex justify-content-between"
                                style="width: 35%"
                            >
                                <a
                                    :href="`https://x.com/frontrowtikets?s=21`"
                                    target="_blank"
                                >
                                    <img
                                        src="../../images/twitter.svg"
                                        alt
                                        height="15"
                                /></a>
                                <a
                                    :href="`https://x.com/frontrowtikets?s=21`"
                                    target="_blank"
                                    class="text-light"
                                    >X(Twitter)</a
                                >
                            </div>

                            <!-- <div @click="" role="button" class="">
                            <img
                                src="../../images/youtube.svg"
                                alt
                                height="19"
                            />
                             Youtube
                        </div> -->
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

                        <p class="">
                            {{ new Date().getFullYear() }} © FRONTROW. Design &
                            Developed by the CinemaUg
                        </p>
                    </div>
                </div>
            </div>
        </b-container>
        <b-container v-else>
            <div>
                <div class="d-flex justify-content-between ps-3 pe-3">
                    <div class="">
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

                    <div class="">
                        <div class="mb-lg-0">
                            <h5 class="mb-3 footer-list-title">Company</h5>
                            <ul class="list-unstyled footer-list-menu">
                                <li @click="toDeleteAccount" role="button">
                                    <a>Delete My Account</a>
                                </li>
                                <li @click="toPrivacyPolicy" role="button">
                                    <a>Privacy Policy</a>
                                </li>
                                <li @click="toTermsAndConditions" role="button">
                                    <a>Terms & Conditions</a>
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
                </div>
                <div class="mt-5 ps-3 pe-3">
                    <div class="">
                        <div class="">
                            <h5 class="footer-list-title">
                                Download Our Application
                            </h5>
                            <div class="">
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

                <div class="ps-3 pe-3">
                    <div class="">
                        <div class="mb-lg-0">
                            <h5 class="footer-list-title">Follow Us</h5>
                            <div
                                class="gap-5 pt-2 d-flex flex-row "
                            >
                                <div
                                    role="button"
                                    class="right-auto "
                                >
                                    <a
                                        :href="`https://www.instagram.com/frontrowtikets?igsh=ZmVmajFlb3k1MzU4`"
                                        target="_blank"
                                    >
                                        <img
                                            src="../../images/instagram.svg"
                                            alt
                                            height="19"
                                    /></a>
                                </div>
                                <div
                                    role="button"
                                    class="right-auto "
                                >
                                    <a
                                        :href="`https://www.tiktok.com/@frontrowtikets?_t=ZM-8u2RAENRACU&_r=1`"
                                        target="_blank"
                                    >
                                        <img
                                            src="../../images/tiktok.svg"
                                            alt
                                            height="20"
                                    /></a>
                                   
                                </div>
                                <div
                                    role="button"
                                    class="right-auto "
                                >
                                    <a
                                        :href="`https://x.com/frontrowtikets?s=21`"
                                        target="_blank"
                                    >
                                        <img
                                            src="../../images/twitter.svg"
                                            alt
                                            height="15"
                                    /></a>
                                   
                                </div>

                                <!-- <div @click="" role="button" class="">
                            <img
                                src="../../images/youtube.svg"
                                alt
                                height="19"
                            />
                             Youtube
                        </div> -->
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

                        <p class="">
                            {{ new Date().getFullYear() }} © FRONTROW. Design &
                            Developed by the CinemaUg
                        </p>
                    </div>
                </div>
            </div>
        </b-container>
        <!-- end container -->
    </footer>
    <!-- Footer end -->
</template>
