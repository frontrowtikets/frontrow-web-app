<script>
import HorizontalTopbar from "../Components/HorizontalTopbarSupport.vue";
import RightBar from "../Components/right-bar.vue";
import Footer from "../Components/footer.vue";

/**
 * Horizontal-layout
 */
export default {
    components: {
        HorizontalTopbar,
        Footer,
        RightBar
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
        }
    }
};
</script>

<template>
    <div>
        <!-- Begin page -->
        <div id="layout-wrapper" >
            <HorizontalTopbar />
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content ">
                <div class="page-content ">
                    <div class="container-fluid ">
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
        <!-- <RightBar /> -->
    </div>
</template>
