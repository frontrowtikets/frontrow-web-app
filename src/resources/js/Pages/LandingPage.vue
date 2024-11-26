<script setup>
import TheTeam from "../Components/TheTeam.vue";
import Faq from "../Components/Faq.vue";
import Features from "../Components/Features.vue";
import AboutUs from "../Components/AboutUs.vue";
import FooterSection from "../Components/FooterSection.vue";
import { onMounted, reactive, onBeforeMount, computed } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import PdfIcon from "@/js/Components/icons/PdfIcon.vue";
import ExcelIcon from "@/js/Components/icons/ExcelIcon.vue";
import WordIcon from "@/js/Components/icons/WordIcon.vue";
import Swal from "sweetalert2";
import "vue3-pdf-app/dist/icons/main.css";
import { VueEditor } from "vue3-editor";

const props = defineProps(["realtimeWeatherData"]);
const state = reactive({

});

onBeforeMount(() => {
    window.addEventListener("scroll", windowScroll);
});

onMounted(() => {
    //get realtime weather
    fetchRealTimeWeather();
});

function windowScroll() {
    const navbar = document.getElementById("navbar");

    if (navbar) {
        if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
            navbar.classList.add("nav-sticky");
        } else {
            navbar.classList.remove("nav-sticky");
        }
    }
}

function toggleMenu() {
    document.getElementById("topnav-menu-content").classList.toggle("show");
}

const computedWeathercode = computed(() => {
    let weatherCode = props.realtimeWeatherData.weatherCode;
    const stringValue = weatherCode.toString();

    if (stringValue.length == 4) {
        const cleaned = stringValue + "0";
        return cleaned;
    } else {
        return stringValue;
    }
});





</script>

<template>
    <Head title="FRONTROW App" />

    <div class="no-scrollbar">
        <nav class="sticky navbar navbar-expand-lg navigation fixed-top" id="navbar">
            <b-container>
                <a class="navbar-logo" href="/">
                    <img src="../../images/FRONTROWLogo.svg" alt height="80" class="logo logo-dark" />
                    <img src="../../images/FRONTROWLogo.svg" alt height="80" class="logo logo-light" />
                </a>

                <button type="button" class="px-3 btn btn-sm font-size-16 d-lg-none header-item" data-toggle="collapse" @click="toggleMenu()">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav ms-auto" id="topnav-menu" v-scroll-spy-active="{ selector: 'a.nav-link' }">
                        <li class="nav-item">
                            <a class="nav-link" v-scroll-to="'#home'" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" v-scroll-to="'#about'" href="#about">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" v-scroll-to="'#features'" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" v-scroll-to="'#team'" href="#team">Team</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" v-scroll-to="'#faqs'" href="#faqs">FAQs</a>
                        </li>
                    </ul>
                    <Link :href="route('dashboard')" class="fw-medium text-primary" v-if="usePage().props.auth.user">
                        <div class="ms-lg-2">
                            <div class="btn btn-outline-success w-xs">My Dashboard</div>
                        </div></Link
                    >
                    <Link :href="route('login')" class="fw-medium text-primary" v-else>
                        <div class="ms-lg-2">
                            <div class="btn btn-outline-success w-xs">Sign in</div>
                        </div></Link
                    >
                </div>
            </b-container>
        </nav>
        <div v-scroll-spy>
            <!-- hero section start -->
            <section class="section hero-section bg-ico-hero" id="home">
                <div class="bg-overlay"></div>
                <b-container>
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="text-white-50">
                                <h1 class="mb-3 text-white fw-semibold hero-title">Cinema Ug</h1>
                                <p class="font-size-14">Movies & Beyond</p>

                                <div class="gap-4 mt-4 button-items d-flex">
                                    <Link :href="route('login')">
                                        <a href="javascript: void(0);" class="btn btn-success">Get a Ticket</a>
                                    </Link>
                                    <a v-scroll-to="'#features'" href="#features" class="btn btn-light">How it works</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end row -->
                </b-container>
                <!-- end container -->
            </section>
            <!-- hero section end -->
            <!-- currency price section start -->
            <section class="p-0 bg-white section">
                <b-contain>
                    <div class="currency-price">
                        <div class="row">
                            <div class="mb-5 col-12">
                                <AirQualityPollutantWidget />
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </b-contain>
                <!-- end container -->
            </section>
            <!-- curreny price section end -->
            <!-- about section start -->

            <AboutUs />

            <div id="sampleFeatures">
                <Features />
            </div>

            <TheTeam />
            <Faq />

            <FooterSection />
        </div>


    </div>
</template>
<style scoped lang="scss">
.no-scrollbar {
    overflow-x: auto;
    scrollbar-width: none;
    /* Firefox */
    -ms-overflow-style: none;
    /* IE and Edge */
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
    /* WebKit browsers */
}
</style>
