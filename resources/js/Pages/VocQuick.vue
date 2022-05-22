<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    phrases: Object,
    // voc_front: Array,
    // voc_back: Array,
    voc: Array,
    title: String
});

const phrases = props.phrases;
const title = props.title;
// const voc_front = props.voc_front;
// const voc_back = props.voc_back;
const voc = props.voc;

const checkedWords = ref([]);

const show_preferences= ref(false);

function toggleShowPreferences(event){
    this.show_preferences = !this.show_preferences;
}

function setSelected(event) {
  console.log(checkedWords);
  // console.log(selected.index);
}

function selectAll(event) {
    // var selected = [];
    // console.log(voc);

    // voc.forEach(function (word) {
    //     selected.push(word);
    // });

    checkedWords.value = voc;
    console.log(checkedWords);
}

function selectNone(event) {
    checkedWords.value = [];
    console.log(checkedWords);
}

function selectFirstHalf(event){
  const half = Math.ceil(voc.length / 2);
  const firstHalf = voc.slice(0, half)

  checkedWords.value = firstHalf;
}

function selectSecondHalf(event){
  const half = Math.ceil(voc.length / 2);
  const secondHalf = voc.slice(-half);

  checkedWords.value = secondHalf;
}
</script>

<template>
    <Head title="Lees Latijn in cola" />

    <div class="bg-gray-100 dark:bg-gray-900 h-screen">
        <div v-if="canLogin" class="px-6 py-4">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <div class="grid grid-cols-2 justify-items-end">
                    <div>
                        <Link :href="route('login')" class="text-sm text-gray-700 underline text-right">
                            Log in
                        </Link>
                    </div> 

                    <div>
                        <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline text-right">
                            Register
                        </Link>
                    </div> 

                </div>
            </template>
        </div>

      <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 bg-zinc-200 text-amber-500 pl-2 pr-2 ml-2 mr-2   md:w-1/2 lg:w-1/3 md:mx-auto font-bold" @click="toggleShowPreferences($event)">
                  &#8595 Instellingen &#8595
      </div>
      <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 text-sm bg-zinc-200 text-amber-500 pl-2 pr-2 ml-2 mr-2   md:w-1/2 lg:w-1/3 md:mx-auto font-bold">
                  Er zijn momenteel {{this.checkedWords.length}} woorden geselecteerd. Klik hier om te wijzigen.
      </div>
      <div v-if="show_preferences" class="pt-2 pb-2 pl-2 pr-2 bg-white pt-2 pb-2 pl-2 pr-2 ml-2 mr-2 mt-2 md:w-1/2 lg:w-1/3 md:mx-auto">

            <div class="mb-2">
              Selecteer de woorden die je wil instuderen.
            </div>
            <div class="mb-2">
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectAll">Alles</button>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectNone">Niets</button>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectFirstHalf">1e helft</button>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="selectSecondHalf">2e helft</button>
            </div>

            <div @click="setSelected($event)"  class="text-center inline-block pr-1" 
                    v-for="(word, index) in voc" >
               <input :id="word.id" :value="word" name="word" type="checkbox" v-model="checkedWords" class="pr-1" />
               <label :for="word.id" class="pl-2 font-bold"><span>{{word["word"]}}</span></label> 
            </div>
      </div>


    </div>

</template>