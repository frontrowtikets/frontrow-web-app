<script setup>
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";
import { router } from "@inertiajs/vue3";

const breakpoints = useBreakpoints(breakpointsTailwind);

const greaterThanMd = breakpoints.greater("md");

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
    router.visit("/scheduleevents");
}
function createMovie() {
    router.visit("/schedulemovies");
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
    <!-- Team start -->

    <!-- about section start -->
    <section class="pt-4 section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-5 text-center">
                        <div class="small-title">
                            Feature-filled & Power-packed.
                        </div>
                        <h4>Book Your Spot at Top Events Today</h4>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <!-- <div class="col-lg-5">
                    <div class="text-muted">
                        <h4>Do Your Event Your Way.</h4>
                        <p>
                            Unmissable moments await you right here! From
                            electrifying concerts and vibrant festivals to
                            insightful conferences and exclusive meetups, we
                            bring you the best events happening near you and
                            beyond. Discover the perfect way to create memories
                            that last a lifetime. Don’t miss out on the action.
                        </p>
                        <p class="mb-4">
                            Register your event for bookings or book your spot
                            today and let the adventure begin.
                        </p>

                        <div class="button-items">
                            <a
                                @click="goToMoviesPage"
                                role="button"
                                class="btn btn-primary me-2"
                                >Book Now</a
                            >
                            <a
                                @click="createMovie"
                                role="button"
                                class="btn btn-outline-primary"
                                >Register</a
                            >
                        </div>


                        <div class="mt-4 row">
                            <div class="col-lg-4 col-6">
                                <div class="mt-4">
                                    <h4>$ 6.2 M</h4>
                                    <p>Transactions</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="mt-4">
                                    <h4>46245</h4>
                                    <p>Users</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-lg-6 ms-auto">
                    <div class="mt-4 mt-lg-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="border card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i
                                                class="bx bx-sticker h2 text-primary"
                                            ></i>
                                        </div>
                                        <h5>Convenience</h5>
                                        <p class="mb-0 text-muted">
                                            Book your spot
                            today and let the adventure begin.
                                        </p>
                                    </div>
                                    <div
                                        class="text-center bg-transparent card-footer border-top"
                                         @click="goToMoviesPage"
                                        role="button"
                                    >
                                        <a class="text-primary">Book Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="border card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i
                                                class="bx bx-group h2 text-primary"
                                            ></i>
                                        </div>
                                        <h5>Join Thousands</h5>
                                        <p class="mb-0 text-muted">
                                             Register your events & cinemas for bookings.
                                        </p>
                                    </div>
                                    <div
                                        class="text-center bg-transparent card-footer border-top"
                                         @click="createMovie"
                                        role="button"
                                    >
                                        <a class="text-primary">Register</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 ms-auto">
                    <div class="mt-4 mt-lg-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="border card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i
                                                class="mdi mdi-ticket h2 text-primary"
                                            ></i>
                                        </div>
                                        <h5>Ticketing</h5>
                                        <p class="mb-0 text-muted">
                                            The Best Seats in the House Are Just
                                            a Click Away!
                                        </p>
                                    </div>
                                    <div
                                        class="text-center bg-transparent card-footer border-top"
                                        @click="goToMoviesPage"
                                        role="button"
                                    >
                                        <a class="text-primary">Buy Tickets</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="border card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i
                                                class="mdi mdi-movie-roll h2 text-primary"
                                            ></i>
                                        </div>
                                        <h5>Cinemas & Events</h5>
                                        <p class="mb-0 text-muted">
                                            Host your events and cinemas with us
                                            today!
                                        </p>
                                    </div>
                                    <div
                                        class="text-center bg-transparent card-footer border-top"
                                        @click="createEvent"
                                        role="button"
                                    >
                                        <a class="text-primary">Create Event</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <hr class="my-5" />

            <div class="row">
                <div class="col-lg-12">
                    <!-- <client-slider /> -->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
</template>
