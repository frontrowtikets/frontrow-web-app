<script setup>
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
    <!-- Footer start -->
    <footer class="landing-footer">
        <b-container>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="mb-4 mb-lg-0">
                        <h5 class="mb-3 footer-list-title">Platform</h5>
                        <ul class="list-unstyled footer-list-menu">
                            <li>
                                <a href="#">About Us</a>
                            </li>
                            <li>
                                <a href="#">Features</a>
                            </li>
                            <li>
                                <a href="#">Team</a>
                            </li>
                            <li>
                                <a href="#">FAQs</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="mb-4 mb-lg-0">
                        <h5 class="mb-3 footer-list-title">Links</h5>
                        <ul class="list-unstyled footer-list-menu">
                            <li>
                                <a href="#">Create Account</a>
                            </li>
                            <li>
                                <a href="#">Sign in </a>
                            </li>
                            <li>
                                <a href="#">Go to Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="mb-4 mb-lg-0">
                        <h5 class="mb-3 footer-list-title">
                            Mobile Application
                        </h5>
                        <div class="blog-post">
                            <div
                                class="badge badge-soft-success font-size-11"
                                @click="downloadApk"
                                role="button"
                            >
                                Download FRONTROW App on Playstore
                            </div>
                            <div class="flex-row gap-5 d-flex">
                                <div @click="downloadApk" role="button">
                                    <img
                                        src="../../images/playstore.svg"
                                        alt
                                        height="120"
                                    />
                                </div>
                                <div @click="downloadApk" role="button">
                                    <img
                                        src="../../images/appstore.svg"
                                        alt
                                        height="120"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <hr class="my-5 footer-border" />

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-2">
                        <div class="text-lg text-white fw-bold">FRONTROW</div>
                    </div>

                    <p class="mb-2">
                        {{ new Date().getFullYear() }} © FRONTROW. Design &
                        Developed by the CinemaUg
                    </p>
                    <p>Movies & Beyound</p>
                </div>
            </div>
        </b-container>
        <!-- end container -->
    </footer>
    <!-- Footer end -->
</template>
