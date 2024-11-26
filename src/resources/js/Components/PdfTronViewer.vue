<!-- <script>
import { ref, onMounted,reactive } from "vue";
import moment from "moment";
import WebViewer from "@pdftron/webviewer";
import { usePage } from "@inertiajs/vue3";
import smallUnicefLogo from "../../images/small-logo-blue.svg";

export default {
    name: "PdfTronViewer",
    props: ["pdfArrayBufferData", "canSign", "id"],
    emits: ["saveUserSignedForm"],
    setup(props, ctx) {
        const viewer = ref(null);

        const state = reactive({
            tronDocumentViewer:null,
            tronAnnotationManager:null
        })

        onMounted(() => {
            const path = `/webviewer`;
            WebViewer(
                {
                    path,
                    // initialDoc: props.pdfUrl,
                    // licenseKey: 'demo:1696945650933:7ceb2d4f03000000004e9ca4b3bda7f1bb5c1b4a877ae4b5ab4c45632a'  // sign up to get a free trial key at https://dev.apryse.com
                },
                viewer.value
            ).then((instance) => {
                const arr = new Uint8Array(props.pdfArrayBufferData);
                const blob = new Blob([arr], { type: "application/pdf" });
                instance.UI.loadDocument(blob, { filename: "FormFile.pdf" });

                const { documentViewer, annotationManager } = instance.Core;
               
                const signatureTool = documentViewer.getTool("AnnotationCreateSignature");

                documentViewer.addEventListener("documentLoaded", async () => {
                    // Loading  user Signature
                    let stampCanvas = document.getElementById("signature-content-" + props.id).getContext("2d");

                    stampCanvas.beginPath();
                    stampCanvas.lineWidth = "1";
                    stampCanvas.strokeStyle = "#0160a0";
                    stampCanvas.rect(0, 0, 200, 140);
                    stampCanvas.stroke();

                    stampCanvas.textAlign = "center";

                    //disable the signature section if canSign is false
                    // if (props.canSign == false) {
                    //     instance.UI.disableElements(["toolbarGroup-FillAndSign"]);
                    //     instance.UI.setToolbarGroup("toolbarGroup-View");
                    // }

                    if (usePage().props.auth.user.signature != null) {
                        const signatureBase64 = usePage().props.auth.user.signature.image;

                        //this is the signature
                        // stampCanvas.drawImage(signatureBase64, 65.5, 15, 120, 60);

                        await signatureTool.importSignatures([signatureBase64]);
                    } else {
                        let unicefImage = new Image();
                        unicefImage.src = smallUnicefLogo;
                        unicefImage.onload = function () {
                            stampCanvas.drawImage(unicefImage, 65.5, 15, 120, 60);
                        };
                    }

                    stampCanvas.font = "14px Arial";
                    stampCanvas.fillStyle = "blue";
                    stampCanvas.textAlign = "center";
                    stampCanvas.fillText(usePage().props.auth.user.name, 100, 80);
                    stampCanvas.fillText(usePage().props.auth.user.staffProfile.position_text, 100, 98);
                    stampCanvas.fillText(moment().format("DD/MMM/YYYY"), 100, 116);

                    let image = document.getElementById("signature-content-" + props.id).toDataURL();
                    await signatureTool.importSignatures([image]);
                });

                 state.tronDocumentViewer = documentViewer;
                state.tronAnnotationManager = annotationManager;

            });
        });

        async function saveSignedForm() {
            if (state.tronDocumentViewer != null && state.tronAnnotationManager != null) {
                const doc = state.tronDocumentViewer.getDocument();
                const xfdfString = await state.tronAnnotationManager.exportAnnotations();
                const data = await doc.getFileData({
                    // saves the document with annotations in it
                    xfdfString,
                });
                const arr = new Uint8Array(data);
                const blob = new Blob([arr], { type: "application/pdf" });

                //generating a file from the blob
                let file = new File([blob], "PettyCashForm", {
                    type: "application/pdf",
                    lastModified: new Date(),
                });

                //emit an event with the signed form
                ctx.emit("saveUserSignedForm", file);
            }else {
                console.log('webviewer Issue(event to save the signed file is not triggered)')
            }
        }

        return {
            viewer,
            props,
            saveSignedForm,
        };
    },
};
</script>

<template>
    <div>
        <div id="webviewer" ref="viewer">
            <div v-if="props.canSign" style="position: absolute; top: -10000px">
                <canvas :id="'signature-content-' + props.id" width="200" height="140"></canvas>
            </div>
        </div>
        <div style="text-align: center" class="mt-3 mb-2">
            <b-button variant="primary" type="button" class="unicef-btn unicef-primary w-md ml-1" @click="saveSignedForm">
                <span>Next</span>
            </b-button>
        </div>
    </div>
</template>

<style>
#webviewer {
    height: 100vh;
}
</style> -->
