<template>
  <div class="container mt-4">
    <h2 class="mb-4">Dynamic Image Uploader</h2>

    <!-- Dynamic Upload Slots -->
    <div class="row g-3">
      <div
        class="col-md-4"
        v-for="(imageSlot, index) in imageSlots"
        :key="index"
      >
        <div class="card">
          <div class="text-center card-body">
            <!-- Image Preview or Placeholder -->
            <div class="mb-3">
              <img
                v-if="imageSlot.preview"
                :src="imageSlot.preview"
                class="mb-2 img-thumbnail"
                style="max-height: 150px; object-fit: cover;"
                alt="Image Preview"
              />
              <div v-else class="placeholder bg-light text-muted d-flex align-items-center justify-content-center" style="height: 150px;">
                No Image
              </div>
            </div>

            <!-- Upload Button -->
            <input
              type="file"
              class="mb-3 form-control"
              @change="handleFileUpload($event, index)"
              accept="image/*"
            />

            <!-- Remove Button -->
            <button
              class="btn btn-danger btn-sm"
              @click="removeImage(index)"
            >
              Remove
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Slot Button -->
    <button
      class="mt-4 btn btn-primary"
      @click="addImageSlot"
    >
      Add New Slot
    </button>
  </div>
</template>

<script>
import { ref } from "vue";

export default {
  setup() {
    const imageSlots = ref([
      { preview: null }, // Initial slot
    ]);

    const handleFileUpload = (event, index) => {
      const file = event.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = (e) => {
        imageSlots.value[index].preview = e.target.result;
      };
      reader.readAsDataURL(file);
    };

    const removeImage = (index) => {
      imageSlots.value.splice(index, 1);
    };

    const addImageSlot = () => {
      imageSlots.value.push({ preview: null });
    };

    return {
      imageSlots,
      handleFileUpload,
      removeImage,
      addImageSlot,
    };
  },
};
</script>

<style scoped>
.placeholder {
  height: 150px;
  border: 1px dashed #ccc;
}
.img-thumbnail {
  object-fit: cover;
}
</style>
