<script setup>
// import { Head, Link } from '@inertiajs/inertia-vue3';
import { Head, Link } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
// import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    asset: String
});

const docxName = props.docxName;
const asset = props.asset;

</script>

<template>
    <div>
        <a :href="asset">vocabularium downloaden</a>
        

    </div>
</template>