<script setup>

const emit = defineEmits(["removeDoc","deleteUploadSection"]);
const props = defineProps({
    showName: {
        type: Boolean,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    uploadFile: {
        type: Function,
        required: true,
    },
    fileType: {
        type: String,
        required: true,
    },
    isRequiredText: {
        type: String,
    },
    accept: {
        type: String,
    },
    showDel: {
        type: Boolean,
    },
    idName:{
        type:String,
        required:false,
        default:"fileupload"
    }

  
});

function selectFiles() {
    document.getElementById(props.idName).click();
}
function removeDoc(){
    emit('removeDoc')
}
function delSec(){
    emit('deleteUploadSection')
}
</script>
<template>
    
    <div v-if="!props.showName" class="col-12 containerbox d-flex flex-column align-items-center justify-content-center p-2" > 
        <div  class="d-flex w-100">
            <div class="mx-auto">
                <i class="bx bxs-cloud-upload" style="font-size: 4em; color: #b5b5b5"></i>
            </div>
            <div v-if="props.showDel">
                <i class="bx bxs-x-circle text-danger fs-5 mb-3" role="button" @click="delSec"></i>
            </div>
        </div>
        <div class="fw-bold text-muted text-center">DRAG & DROP</div>
        <div class="mb-1">{{ props.fileType }} for this Finanve Request {{ props.isRequiredText }}</div>
        <div class="mb-2">
            <input :id="props.idName" type="file" :accept="props.accept" hidden @change="props.uploadFile($event, n)" />
            <b-button variant="info" type="button" @click="selectFiles">Choose files </b-button>
        </div>
    </div>
    <div v-else class="col-12 border p-5 d-flex flex-column align-items-center justify-content-center">
        <div class="text-center text-black pb-2" style="font-size: 1em">{{ props.name }}</div>

        <div class="text-center">
            <b-button variant="danger text-center" @click.prevent="removeDoc"> Delete </b-button>
        </div>
    </div>
</template>
<style scoped>
.containerbox {
    background-color: #eff2f8;
}
</style>
