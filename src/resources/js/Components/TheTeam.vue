<script setup>
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core'

const breakpoints = useBreakpoints(breakpointsTailwind)

const greaterThanMd = breakpoints.greater('md')
</script>
<template>
    <!-- Team start -->
    <section class="bg-white section" id="team">
        <b-container>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-5 text-center">
                        <div class="small-title">Team</div>
                        <h4>Meet our team</h4>

                    </div>
                    <div>
                       
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="col-lg-12"></div>
            <!-- end row -->
        </b-container>
        <!-- end container -->
    </section>
</template>
