<script setup>
defineProps([
    "discount",
    "eventName",
    "eventImageLink",
    "eventDate",
    "eventLocation",
    "eventPrice",
    "eventCurrency",
]);
</script>

<template>
    <b-container>
        <div class="rounded shadow card w-100">
            <div class="p-2">
                <div
                    class="overflow-hidden rounded position-relative"
                    style="height: 320px"
                    role="button"
                >
                    <div
                        v-if="discount"
                        class="avatar-sm product-ribbon"
                        style="z-index: 1"
                    >
                        <span class="avatar-title rounded-circle bg-primary"
                            >-{{ discount }}%</span
                        >
                    </div>
                    <div>
                        <img
                            :src="`${eventImageLink}`"
                            alt
                            class=""
                            style="
                                object-fit: cover;
                                object-position: center;
                                height: 320px;
                                background-color: lightgray;
                                width: 100%;
                            "
                            v-motion
                            :initial="{ opacity: 0 }"
                            :enter="{ opacity: 1, scale: 1 }"
                            :hovered="{ scale: 1.1 }"
                            :delay="20"
                            :duration="400"
                        />
                    </div>
                </div>
                <div class="pb-2 mt-4 ps-2 pe-2" role="button">
                    <h5 class="mb-3 text-truncate text-start">
                        <div class="text-hover-warning" role="button">
                            {{ eventName }}
                        </div>
                    </h5>
                    <div class="mb-1 text-primary text-start">
                        <i class="bx bx-calendar-event me-1"></i
                        ><span>{{ eventDate }}</span>
                    </div>
                    <div class="text-truncate text-start">
                        <i class="bx bx-map me-1"></i
                        ><span>{{ eventLocation }} </span>
                    </div>

                    <h5 class="mt-3 text-end">
                        <b>{{ eventCurrency }} {{ eventPrice }}</b>
                    </h5>
                </div>
            </div>
        </div>
    </b-container>
</template>
<style scoped>
.text-hover-warning {
    color: black;
    transition: color 0.3s ease-in-out; /* Animate color changes over 0.3s */
}

.text-hover-warning:hover {
    color: #fed444; /* Bootstrap's primary color variable */
}
</style>
