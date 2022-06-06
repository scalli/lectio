<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue';
/* add fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    text_infos: Object,
    systematisches: Object
});

const text_infos = props.text_infos;
const systematisches = props.systematisches;

const checkedTextInfos = ref([]);
const checkedSystematisches = ref(systematisches);

const show_texts= ref(false);
const show_systematic= ref(false);

function toggleShowTexts(event){
    this.show_texts = !this.show_texts;
}

function toggleShowSystematic(event){
    this.show_systematic = !this.show_systematic;
}

function selectAll(event) {
    checkedSystematisches.value = systematisches;
    console.log(checkedSystematisches);
}

function selectNone(event) {
    checkedSystematisches.value = [];
    console.log(checkedSystematisches);
}

</script>

<template>
    <Head title="Repetio voc step 1" />

  <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 mt-2 bg-zinc-200 text-amber-500 pl-2 pr-2 ml-2 mr-2   md:w-1/2 lg:w-1/3 md:mx-auto font-bold" @click="toggleShowTexts($event)">
              &#8595 Teksten &#8595
  </div>
    <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 bg-zinc-200 text-amber-500 pl-2 pr-2 ml-2 mr-2   md:w-1/2 lg:w-1/3 md:mx-auto font-bold" @click="toggleShowTexts($event)">
              {{this.checkedTextInfos.length}} teksten geselecteerd
    </div>
    <div v-if="show_texts" class="md:grid md:grid-cols-2 md:gap-1 ml-1 mr-1 text-sm">
      <div v-for="(text, index) in text_infos" class="pl-4">
         <div>
           <input :id="text.id" :value="text" name="text" type="checkbox" v-model="checkedTextInfos" class="pr-1" />
           <label :for="text.id" class="pl-2 font-bold"><span>{{text['text_title']}}</span></label> 
         </div>
      </div>
    </div>

  <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 mt-2 bg-zinc-200 text-amber-500 pl-2 pr-2 ml-2 mr-2   md:w-1/2 lg:w-1/3 md:mx-auto font-bold" @click="toggleShowSystematic($event)">
              &#8595 Systematische categorieën &#8595
  </div>
    <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 bg-zinc-200 text-amber-500 pl-2 pr-2 ml-2 mr-2   md:w-1/2 lg:w-1/3 md:mx-auto font-bold" @click="toggleShowSystematic($event)">
              {{this.checkedSystematisches.length}} categorieën geselecteerd
  </div>
    <div v-if="show_systematic">

        <div class="mb-2 text-center">
          Selecteer de categorieën die je wil oefenen.
        </div>
        <div class="mb-2 text-center">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectAll">Alles</button>
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectNone">Niets</button>
        </div>

        <div class="md:grid md:grid-cols-2 md:gap-1 ml-1 mr-1 mt-1 text-sm">
          <div v-for="(systematisch, index) in systematisches" class="pl-4">
             <div>
               <input :id="systematisch.id" :value="systematisch" name="systematisch" type="checkbox" v-model="checkedSystematisches" class="pr-1" />
               <label :for="systematisch.id" class="pl-2 font-bold"><span>{{systematisch['part_of_speech']}}</span></label> 
             </div>
          </div>
        </div>
    
    </div>

</template>