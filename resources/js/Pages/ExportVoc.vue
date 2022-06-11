<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'

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