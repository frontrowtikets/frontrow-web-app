<script setup>
import { reactive } from "vue";

const state = reactive({
    general1: true,
    general2: false,
    general3: false,
    general4: false,
});

function downloadApk() {
    const fileUrl = `/FRONTROW_V1.0.1.apk`;

    const a = document.createElement("a");
    a.href = fileUrl;
    a.download = "FRONTROW_V1.0.1.apk";
    document.body.appendChild(a);
    a.click();
    URL.revokeObjectURL(fileURL);
    document.body.removeChild(a);
}
</script>
<template>
    <!-- Faqs start -->
    <section class="section" id="faqs">
        <b-container>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-5 text-center">
                        <div class="small-title">FAQs</div>
                        <h4>Frequently asked questions</h4>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="vertical-nav">
                        <b-tabs
                            pills
                            vertical
                            nav-wrapper-class="col-lg-2 col-sm-4"
                        >
                            <b-tab active>
                                <template v-slot:title>
                                    <i
                                        class="mb-2 bx bx-help-circle nav-icon d-block"
                                    ></i>
                                    <p class="mb-0 fw-bold">
                                        General Questions
                                    </p>
                                </template>

                            </b-tab>
                            <b-tab>
                                <template v-slot:title>
                                    <i
                                        class="mb-2 bx bx-receipt nav-icon d-block"
                                    ></i>
                                    <p class="mb-0 fw-bold">Configurations</p>
                                </template>

                            </b-tab>
                            <b-tab>
                                <template v-slot:title>
                                    <i
                                        class="mb-2 bx bx-timer d-block nav-icon"
                                    ></i>
                                    <p class="mb-0 fw-bold">Statistics</p>
                                </template>
                               
                            </b-tab>
                        </b-tabs>
                    </div>
                </div>
            </div>
        </b-container>
    </section>
    <!-- end Faqs start -->
</template>
