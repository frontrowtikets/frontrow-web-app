<script>
import HorizontalTopbar from "../Components/horizontal-topbar.vue";
import HorizontalNav from "../Components/horizontal-nav.vue";
import RightBar from "../Components/right-bar.vue";
import Footer from "../Components/footer.vue";

/**
 * Horizontal-layout
 */
export default {
    components: {
        HorizontalTopbar,
        HorizontalNav,
        Footer,
        RightBar,
    },
    data() {
        return {
            disableSecondNav:false,
        };
    },
    created: () => {
        document.body.setAttribute("data-layout", "horizontal");
        document.body.removeAttribute("data-sidebar", "dark");
        document.body.removeAttribute("data-layout-size", "boxed");
    },
    computed: {
        dashboardView() {
            let showDashboard = import.meta.env.VITE_COUNTRY_OFFICE;
            let isToShow = 0;
            switch (showDashboard) {
                case "Uganda":
                    isToShow = 2;
                    break;
                default:
                    isToShow = 1;
                    break;
            }
            return isToShow;
        },
    },
    mounted() {
        if(this.hideSecondNav()){
            this.disableSecondNav = true;
            document.body.classList.remove("second-nav-disabled");
        }
    },
    methods: {
        toggleRightSidebar() {
            document.body.classList.toggle("right-bar-enabled");
        },
        hideRightSidebar() {
            document.body.classList.remove("right-bar-enabled");
        },

        hideSecondNav(){
            return document.body.classList.contains("second-nav-disabled");
        }
    },
};
</script>

<template>
    <div>
        <!-- Begin page -->
        <div id="layout-wrapper">
            <HorizontalTopbar />

            <HorizontalNav v-if="dashboardView != 2 && !disableSecondNav" />
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <slot />
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <!-- <Footer /> -->
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <RightBar />
    </div>
</template>
