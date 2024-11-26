<script setup>
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";

const breakpoints = useBreakpoints(breakpointsTailwind);

const greaterThanMd = breakpoints.greater("md");
</script>
<template>
    <!-- Features start -->
    <section class="section" id="features">
        <b-container>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-5 text-center">
                        <div class="small-title">Features</div>
                        <h4>Key features of the FRONTROW </h4>
                    </div>
                </div>
            </div>
            <!-- end row -->


            <!-- end row -->


            <!-- end row -->

            <!-- end row -->


            <!-- end row -->

            <!-- end row -->

           
        </b-container>
        <!-- end container -->
    </section>
    <!-- Features end -->
</template>
