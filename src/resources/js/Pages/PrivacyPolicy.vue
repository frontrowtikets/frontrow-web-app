<script setup>
import { Head } from "@inertiajs/vue3";
import FooterSection from "@/js/Components/FooterSection.vue";
import HomeHeader from "../Components/HomeHeader.vue";
defineProps({
    policy: String,
});
</script>

<template>
    <section>
        <b-container class="" style="margin-top: 16em">

            <Head title="FrontRow - Privacy Policy" />
            <HomeHeader />
            <div class="container my-4">
                <h2 class="mb-4">Privacy Policy</h2>

                <h4>1. Introduction</h4>
                <p>This Privacy Policy explains how FrontRow collects, uses, and protects your information when you use
                    our platform. By using FrontRow, you consent to the practices described in this policy.</p>

                <h4>2. Information We Collect</h4>
                <ul>
                    <li><strong>Name:</strong> To personalize your ticket.</li>
                    <li><strong>Email Address:</strong> To email your ticket and communicate important updates.</li>
                    <li><strong>Phone Number:</strong> For payment verification, authentication, and sending OTPs.</li>
                </ul>

                <h4>3. How We Use Your Information</h4>
                <ul>
                    <li>To process ticket bookings and payments.</li>
                    <li>To send your ticket and related event updates via email.</li>
                    <li>To authenticate your account and provide secure access via OTP.</li>
                </ul>

                <h4>4. Data Storage and Security</h4>
                <p>We implement industry-standard measures to protect your data from unauthorized access or disclosure.
                    However, no method of electronic transmission is completely secure.</p>

                <h4>5. Sharing Your Information</h4>
                <ul>
                    <li>We do not sell your personal information to third parties.</li>
                    <li>Your information may be shared with event organizers solely for ticket validation purposes.</li>
                </ul>

                <h4>6. Account Deletion</h4>
                <ul>
                    <li>Users may request account deletion by using the delete account service in the app or by
                        contacting us at support@frontrowtikets.com.</li>
                    <li>Account deletion requests will be reviewed and processed within 7-14 business days.</li>
                    <li>If you have active bookings or unresolved transactions, the deletion may be delayed until these
                        are resolved.</li>
                </ul>

                <h4>7. Your Rights</h4>
                <ul>
                    <li><strong>Access:</strong> You have the right to access the personal information we hold about
                        you.</li>
                    <li><strong>Correction:</strong> You can request corrections to your information if it is
                        inaccurate.</li>
                    <li><strong>Deletion:</strong> You may request the deletion of your information, subject to legal
                        and operational requirements.</li>
                </ul>

                <h4>8. Changes to Privacy Policy</h4>
                <p>We reserve the right to modify this Privacy Policy at any time. Updates will be posted on our
                    platform, and your continued use of our services constitutes acceptance of the changes.</p>

                <h4>9. Contact Us</h4>
                <p>If you have any questions or concerns about these Terms and Conditions or our Privacy Policy, please
                    contact us at <a href="mailto:support@frontrowtikets.com">support@frontrowtikets.com</a>.</p>

                <p>Thank you for choosing FrontRow Tickets!</p>
            </div>

        </b-container>
        <FooterSection />
    </section>
</template>
