<script setup>
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";

const breakpoints = useBreakpoints(breakpointsTailwind);

const greaterThanMd = breakpoints.greater("md");
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
                        <h4>Redefine Your Ticketing.</h4>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="text-muted">
                        <h4>Do Your Event Your Way.</h4>
                        <p>
                            From massive festivals,Cinemas, conferences, expos, and
                            captivating attractions to tailor-made events for
                            schools, clubs, and intimate boutique affairs,
                            Quicket has gained the trust of over 200 000 events.
                        </p>
                        <p class="mb-4">
                            It would be necessary to have uniform pronunciation.
                        </p>

                        <div class="button-items">
                            <a href="#" class="btn btn-primary me-2"
                                >Read More</a
                            >
                            <a href="#" class="btn btn-outline-primary"
                                >How It works</a
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
                                            At vero eos et accusamus et iusto
                                            blanditiis
                                        </p>
                                    </div>
                                    <div
                                        class="text-center bg-transparent card-footer border-top"
                                    >
                                        <a href="#" class="text-primary"
                                            >Buy Tickets</a
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="border card mt-lg-5">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i
                                                class="mdi mdi-movie-roll h2 text-primary"
                                            ></i>
                                        </div>
                                        <h5>Cinemas</h5>
                                        <p class="mb-0 text-muted">
                                            Quis autem vel eum iure
                                            reprehenderit
                                        </p>
                                    </div>
                                    <div
                                        class="text-center bg-transparent card-footer border-top"
                                    >
                                        <a href="#" class="text-primary"
                                            >Create Event</a
                                        >
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
