<script setup>
import TagInput from '@mayank1513/vue-tag-input';
import '@mayank1513/vue-tag-input/style.css';

const props = defineProps({
    tags:{
        type:Array,
        default:[]
    }
})
</script>


<template>
  <tag-input v-model="props.tags" />
</template>

