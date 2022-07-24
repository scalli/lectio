<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue';
/* add fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    text_words: Object,
    voc: Object,
    title: String
});

const selected = reactive({ index: 0 });
const questions = reactive(props.questions);
const phrase_supports = reactive(props.phrase_supports);
const voc = reactive(props.voc);
const title = props.title;
const selected_question = ref("") ;
const selected_phrase_support = ref("") ;
const selected_voc = ref([]);
const helper_questions = ref(true);//show the supporting questions
const helper_voc = ref(true);//show the vocabulary that you don't have to know by heart
const helper_voc_to_know = ref(true);//show the vocabulary that you should have to know by heart
const show_preferences= ref(false);

function setSelected(event) {
  console.log(selected);
  selected.index = event.target.id;
    

  this.selected_voc = "";
    if(this.props.voc[selected.index].startsWith("*") && this.helper_voc_to_know == true){
        this.selected_voc = (this.props.voc[selected.index]);
    }
    if(!this.props.voc[selected.index].startsWith("*") && this.helper_voc == true){
        this.selected_voc = this.props.voc[selected.index];
    }
}

function toggleShowPreferences(event){
    this.show_preferences = !this.show_preferences;
}

</script>


<template>
    <Head title="Vlot Latijn lezen!" />

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

        <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 bg-zinc-200 text-amber-500 pl-2 pr-2 ml-2 mr-2  w-1/2 md:w-1/2 lg:w-1/3 md:mx-auto font-bold" @click="toggleShowPreferences($event)">
            &#8595 Instellingen &#8595
        </div>
        <div class="pt-2 pb-2 pl-2 pr-2 bg-zinc-200 pl-2 pr-2 ml-2 mr-2 mb-2 text-amber-500  md:w-1/2 lg:w-1/3 md:mx-auto" v-if="show_preferences" >
            <div class="">
              <div class="grid grid-cols-12 gap-1 form-check form-switch">
                <input class="col-start-3 col-span-3 form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm" type="checkbox" role="switch" id="helper_questions" v-model="helper_voc_to_know" checked>
                <label class="col-start-6 col-span-6 form-check-label inline-block text-gray-800" for="helper_voc_to_know">Toon kernvoc.</label>
              </div>
            </div>

            <div class="">
              <div class="grid grid-cols-12 gap-1form-check form-switch">
                <input class="col-start-3 col-span-3  form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm" type="checkbox" role="switch" id="helper_questions" v-model="helper_voc" checked>
                <label class="col-start-6 col-span-6 form-check-label inline-block text-gray-800" for="helper_voc">Toon hulpvoc.</label>
              </div>
            </div>
        </div>

        <h1 class="text-amber-500 text-xl  font-bold text-center pt-2 pb-2 pl-2 pr-2 pt-2 pb-2 pl-2 pr-2 ml-2 mr-2 mt-2 md:w-1/2 lg:w-1/3 md:mx-auto">{{title}}</h1>

        <div class="pt-2 pb-2 pl-2 pr-2 bg-white pt-2 pb-2 pl-2 pr-2 ml-2 mr-2 mt-2 md:w-1/2 lg:w-1/3 md:mx-auto">
            <div @click="setSelected($event)" :id="index" class="inline-block pr-2" 
                    v-bind:class="{ 'text-blue-700 font-bold': (index == selected.index) }" 
                    v-for="(text_word, index) in text_words">{{text_word.text_word}}</div>
        </div>


        <div class="mt-2 ml-2 mr-2 md:w-3/4 lg:w-1/3 md:mx-auto">
            <div class="pt-2 pb-2 pl-2 pr-2 bg-white text-amber-500 font-bold">
                    {{selected_voc}}
            </div> 
        </div>
    
    </div>

</template>


