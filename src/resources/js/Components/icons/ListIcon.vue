<template>
    <svg :width="width" :height="height" viewBox="0 0 24.00 24.00" xmlns="http://www.w3.org/2000/svg" fill="none" :stroke="color">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
            <path
                :stroke="color"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.6320000000000001"
                d="M11 8h5m0 4h-5m5 4h-5m-5 4h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2zM8 8h.001M8 12h.001M8 16h.001"
            ></path>
        </g>
    </svg>
</template>
<script>

export default {
    name:'ListIcon',
     props:{
        width:{
            type:String,
            required:true
        },
        height:{
            type:String,
            required:true
        },
         color:{
            type:String,
            required:true
        },
    }
}
</script>
