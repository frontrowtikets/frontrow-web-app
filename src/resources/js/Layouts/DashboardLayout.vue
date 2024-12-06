<script>
import NavBar from "../Components/nav-bar.vue";
import SideBar from "../Components/side-bar.vue";
// import RightBar from "../Components/right-bar.vue";
import Footer from "../Components/footer.vue";
import { router} from "@inertiajs/vue3";

/**
 * Vertical layout
 */
export default {
    components: { NavBar, SideBar, Footer },
    data() {
        return {
            isMenuCondensed: false,
        };
    },
    computed: {},
    setup(){
        return {
            router
        }
    },

    created: () => {},
    methods: {
        toggleMenu() {
            document.body.classList.toggle("sidebar-enable");

            // if (window.screen.width >= 992) {
            //   // eslint-disable-next-line no-unused-vars

            //     document.body.classList.remove("sidebar-enable");
            //     document.body.classList.remove("vertical-collpsed");
            //   document.body.classList.toggle("vertical-collpsed");
            // } else {
            //   // eslint-disable-next-line no-unused-vars
            //     document.body.classList.remove("sidebar-enable");
            //   document.body.classList.remove("vertical-collpsed");
            //   document.body.classList.toggle("vertical-collpsed");

            // }
            // this.isMenuCondensed = false;
        },
        toggleRightSidebar() {
            document.body.classList.toggle("right-bar-enabled");
        },
        hideRightSidebar() {
            document.body.classList.remove("right-bar-enabled");
        },
    },
    mounted() {
        if (this.loader === true) {
            document.getElementById("preloader").style.display = "block";
            document.getElementById("status").style.display = "block";

            setTimeout(function () {
                document.getElementById("preloader").style.display = "none";
                document.getElementById("status").style.display = "none";
            }, 2500);
        } else {
            document.getElementById("preloader").style.display = "none";
            document.getElementById("status").style.display = "none";
        }
    },

};
</script>

<template>
    <div >
        <div id="preloader">
            <div id="status">
                <div class="spinner-chase">
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                </div>
            </div>
        </div>
        <div id="layout-wrapper">
            <NavBar />
            <SideBar :is-condensed="isMenuCondensed"  />
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="main-content">
                <div class="page-content">
                    <!-- Start Content-->
                    <b-container fluid>
                        <slot />
                    </b-container>
                </div>
                <Footer />
            </div>
            <!-- <RightBar /> -->
        </div>
    </div>
</template>
