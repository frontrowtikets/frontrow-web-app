<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/horizontal-topbar.vue";
import { ref } from "vue";

import vue2Dropzone from "vue3-dropzone";
import DropZone from "../../components/widgets/dropZone.vue";
/**
 * File Uploads component
 */
export default {
    components: {
        vueDropzone: vue2Dropzone,
        Layout,
        PageHeader,
        DropZone
    },
    data() {
        return {
            title: "Form File Upload",
            items: [{
                text: "Forms",
                href: "/"
            },
            {
                text: "Form File Upload",
                active: true
            }
            ],
            dropzoneOptions: {
                url: "https://httpbin.org/post",
                thumbnailWidth: 150,
                maxFilesize: 0.5,
                headers: {
                    "My-Awesome-Header": "header value"
                }
            }
        };
    },
    setup() {
        let dropzoneFile = ref("");
        const drop = (e) => {
            dropzoneFile.value = e.dataTransfer.files[0];
        };
        const selectedFile = () => {
            dropzoneFile.value = document.querySelector(".dropzoneFile").files[0];
        };
        return { dropzoneFile, drop, selectedFile };
    },
};
</script>

<template>
    <Layout>
        <PageHeader :title="title" :items="items" />
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Dropzone</h4>
                        <p class="card-title-desc">DropzoneJS is an open source library that provides drag’n’drop file
                            uploads with image previews.</p>
                        <!-- file upload -->
                        <DropZone @drop.prevent="drop" @change="selectedFile" />
                        <span class="file-info">File: {{ dropzoneFile.name }}</span>
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-primary">Send Files</button>
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </Layout>
</template>
