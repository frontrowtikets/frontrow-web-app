<template>

        <input ref="inputRef" class="form-control p-2" type="text" :name="inputName" :id="inputName"/>

</template>

<script setup>
import{ref} from "vue";
import {useCurrencyInput} from "vue-currency-input";
const props = defineProps({
    inputName: {
        type:String,required:true,default:'money-input'},
    modelValue: {
        type:Number,required:false,default:0},
    options:{
        type:Object,
    required:true
    }
});
const valueOutput = ref(null)
const {inputRef,formattedValue} = useCurrencyInput(props.options);


const updateValue =()=>{

    let val = inputRef.value;
    valueOutput.value = formattedValue;
    console.log({valueOutput,val})
}

</script>

<style lang="scss" scoped>

</style>
