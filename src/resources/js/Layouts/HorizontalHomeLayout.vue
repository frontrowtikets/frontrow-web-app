<script>
import HomeHeader from "../Components/HomeHeader.vue";
import FooterSection from "../Components/FooterSection.vue";

/**
 * Horizontal-layout
 */
export default {
    components: {
        HomeHeader,
        FooterSection,
    },
    data() {
        return {};
    },
    created: () => {
        document.body.setAttribute("data-layout", "horizontal");
        document.body.removeAttribute("data-sidebar", "dark");
        document.body.removeAttribute("data-layout-size", "boxed");
    },
    methods: {
        toggleRightSidebar() {
            document.body.classList.toggle("right-bar-enabled");
        },
        hideRightSidebar() {
            document.body.classList.remove("right-bar-enabled");
        },
    },
};
</script>

<template>
    <div>
        <!-- Begin page -->
        <div id="layout-wrapper">
            <HomeHeader />
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
                <FooterSection />
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <!-- <RightBar /> -->
    </div>
</template>
