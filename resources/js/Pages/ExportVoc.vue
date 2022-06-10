<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    docxName: String
});

const docxName = props.docxName;

const form = reactive({
      docxName: docxName
    })

    function submit() {
      Inertia.post('/voc/downloadvoc', form)
    }
</script>

<template>
    <div>
        <a :href="'/voc/downloadvoc/'">vocabularium downloaden</a>
        <Link :href="documentlink" class="text-sm text-gray-700 underline">
            vocabularium downloaden
        </Link>
    
    <Link href="/voc/downloadvoc" method="post" :data="{ docxName : docxName  }">Vocabularium downloaden</Link>

      <form @submit.prevent="submit">
        <input id="docxName" name="docxName" type="hidden" :value="docxName" />
        <button type="submit">Submit</button>
    </form>

    </div>
</template>