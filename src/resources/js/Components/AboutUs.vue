<script setup>
import { onMounted, reactive } from "vue";
import { GoogleMap, Marker, Polygon } from "vue3-google-map";

const state = reactive({
    markCenter: { lat: 0.363889, lng: 32.528611 },
});
onMounted(() => {});
</script>
<template>
    <section class="pt-4 bg-white section" id="about">
        <b-container>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-5 text-center">
                        <div class="small-title">About us</div>
                        <h4>Why the FRONTROW?</h4>
                    </div>
                </div>
            </div>
            
            <!-- end row -->

            <!-- end row -->
        </b-container>
        <!-- end container -->
    </section>
</template>

<style scoped>
.weather-map-container {
    width: 100%;
    height: 400px;
    position: relative;
}

#weather-map {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
