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

            <Head title="FrontRow - Terms & Conditions" />
            <HomeHeader />
            <div class="container py-4">
                <h2 class="mb-3">Terms and Conditions</h2>

                <h4>1. Introduction</h4>
                <p>Welcome to FrontRow! By accessing or using our platform, you agree to be bound by these Terms and
                    Conditions. Please read them carefully before proceeding. If you do not agree, you may not use our
                    services.</p>

                <h4>2. Ticket Booking</h4>
                <p>(a) Users can book tickets without creating a formal account. During the booking process, we collect
                    your name, email address, and phone number to facilitate the purchase and delivery of your tickets.
                </p>
                <p>(b) An account is automatically created for you under the hood to associate your ticket purchases.
                </p>
                <p>(c) To access your account, you can log in using a One-Time Password (OTP) sent to your registered
                    phone number.</p>

                <h4>3. Payment and Authentication</h4>
                <p>(a) Your phone number is used for payment verification and authentication purposes.</p>
                <p>(b) We use your email address to send you a copy of your ticket.</p>

                <h4>4. User Responsibilities</h4>
                <p>(a) Ensure the accuracy of the personal information you provide during the ticket booking process.
                </p>
                <p>(b) Maintain the confidentiality of the OTP sent to your phone number.</p>
                <p>(c) You agree to notify us immediately of any unauthorized use of your account or any other breach of
                    security.</p>

                <h4>5. Refund and Cancellation Policy</h4>
                <p>(a) All ticket purchases are final. Refunds or cancellations are subject to the event organizer’s
                    policies. Please refer to the event details for specific terms.</p>

                <h4>6. Prohibited Activities</h4>
                <p>(a) You may not use our platform for any unlawful or fraudulent activity.</p>
                <p>(b) You may not violate any laws in your jurisdiction (including but not limited to copyright).</p>
                <p>(c) You may not attempt to gain unauthorized access to accounts or systems.</p>

                <h4>7. Account Deletion</h4>
                <p>(a) Users may request account deletion by using the delete account service in the app or by
                    contacting us at support@frontrowtikets.com.</p>
                <p>(b) Deletion requests will be reviewed and processed within 7-14 business days to ensure the request
                    is legitimate and all pending transactions or bookings are resolved.</p>
                <p>(c) Once the account is deleted, all personal information associated with the account will be
                    permanently removed from our systems.</p>
                <p>(d) Users will be notified once the account deletion is complete.</p>

                <h4>8. Limitation of Liability</h4>
                <p>FrontRow Tickets is not responsible for issues arising from events beyond our control, including
                    cancellations, postponements, or venue changes.</p>
                <p>We are not liable for any direct, indirect, or consequential damages arising from the use of our
                    platform.</p>

                <h4>9. Changes to Terms</h4>
                <p>We reserve the right to modify these terms at any time. By continuing to use our platform, you agree
                    to be bound by the updated terms.</p>
            </div>

        </b-container>
        <FooterSection />
    </section>
</template>
