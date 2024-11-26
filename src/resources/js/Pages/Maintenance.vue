<script>
import logoDark from "@/images/cinemaug_logo.svg";
import logoLight from "@/images/cinemaug_logo.svg";
import maintenence from "@/images/maintenance.svg";

export default {
    data() {
        return {
            logoDark,
            logoLight,
            maintenence,
        };
    },
};
</script>
<template>
    <div>
        <div class="home-btn d-none d-sm-block">
            <router-link to="/" class="text-dark">
                <i class="fas fa-home h2"></i>
            </router-link>
        </div>
        <section class="my-5 pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="text-center col-12">
                        <div class="home-wrapper">
                            <div class="mb-5">
                                <router-link to="/" class="d-block auth-logo">
                                    <img :src="logoDark" alt="" height="30" class="mx-auto auth-logo-dark" />
                                    <img :src="logoLight" alt="" height="30" class="mx-auto auth-logo-light" />
                                </router-link>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-sm-4">
                                    <div class="maintenance-img">
                                        <img :src="maintenence" alt class="mx-auto img-fluid d-block" />
                                    </div>
                                </div>
                            </div>
                            <h3 class="mt-5">Site is Under Development</h3>
                            <p>Please check back in sometime.</p>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mt-4 card maintenance-box">
                                        <div class="card-body">
                                            <i class="mb-4 bx bx-broadcast h1 text-primary"></i>
                                            <h5 class="font-size-15 text-uppercase">Why is the Site Down?</h5>
                                            <p class="mb-0 text-muted">Our site is currently under development as we strive to bring you an amazing experience. We're making improvements and polishing things up to ensure everything runs smoothly.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mt-4 card maintenance-box">
                                        <div class="card-body">
                                            <i class="mb-4 bx bx-time-five h1 text-primary"></i>
                                            <h5 class="font-size-15 text-uppercase">What is the Downtime?</h5>
                                            <p class="mb-0 text-muted">The downtime is scheduled from November to January. During this period, we’re performing updates to enhance our site’s performance and features.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mt-4 card maintenance-box">
                                        <div class="card-body">
                                            <i class="mb-4 bx bx-envelope h1 text-primary"></i>
                                            <h5 class="font-size-15 text-uppercase">Do you need Support?</h5>
                                            <p class="mb-0 text-muted">
                                                We’re here to assist you! If you have any questions or need support, please don’t hesitate to reach out to us. Email
                                                <a href="mailto:no-reply@domain.com" class="text-decoration-underline">support@cinemaug.com</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
