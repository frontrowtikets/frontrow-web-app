<template>
    <div class="stepper">
        <div class="mb-4 stepper-header d-flex justify-content-between">
            <div
                v-for="(step, index) in steps"
                :key="index"
                class="step-item"
                :class="{
                    active: currentStep === index + 1,
                    completed: currentStep > index + 1,
                }"
                @click="goToStep(index + 1)"
            >
                <span class="step-number">{{ index + 1 }}</span>
                <span class="step-label text-muted">{{ step }}</span>
            </div>
        </div>

        <div class="stepper-content">
            <slot :current-step="currentStep"></slot>
        </div>

        <div class="mt-4 col-12 col-md-9 stepper-footer d-flex justify-content-between ">
            <div
                v-if="currentStep !== 1"
                class="btn btn-light"
                @click="prevStep"
                :disabled="currentStep === 1"
            >
                Previous
        </div>
            <div
                class="btn btn-primary w-md"
                @click="nextStep"
                v-if="currentStep !== steps.length"
            >
                Next
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
    steps: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const currentStep = ref(1);

const nextStep = () => {
    if (currentStep.value < props.steps.length) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

const goToStep = (step) => {
    currentStep.value = step;
};
</script>

<style scoped>
.stepper {
    border: 0px solid #dee2e6;
    padding: 20px;
    border-radius: 8px;
}

.stepper-header {
    position: relative;
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 10px;
}

.step-item {
    text-align: center;
    cursor: pointer;
    flex: 1;
}

.step-item.active .step-number,
.step-item.completed .step-number {
    background-color: rgb(0, 196, 206);
    color: #fff;
}

.step-item .step-number {
    display: inline-block;
    width: 30px;
    height: 30px;
    line-height: 30px;
    border: 2px solid rgb(0, 196, 206);
    border-radius: 50%;
    color: rgb(0, 196, 206);
    font-weight: bold;
}

.step-item .step-label {
    display: block;
    font-weight: bold;
    margin-top: 5px;
}

.step-item.completed .step-number {
    background-color: #00666e;
    border-color: #00666e;
}

.stepper-content {
    padding: 20px 0;
}
</style>
