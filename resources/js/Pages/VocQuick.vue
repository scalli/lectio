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
    title: String,
    attempts: Number,
    corrects: Number
});

const phrases = props.phrases;
const title = props.title;
// const voc_front = props.voc_front;
// const voc_back = props.voc_back;
const voc = props.voc;

const checkedWords = ref([]);
var exercises = [];
const current_exercise = reactive({ex : ""});
const current_solution = reactive({ex : ""});
const current_phrase = reactive({ex : ""});

const show_preferences= ref(false);
const show_solution = ref(false);

var progress_percentage = 0;

function toggleShowPreferences(event){
    this.show_preferences = !this.show_preferences;
}

function toggleShowSolution(event){
    show_solution.value = !show_solution.value;
}

function start(event){
  exercises = [];
  checkedWords.value.forEach(function (word) {
        exercises.push(word);
    });
  //Shuffle array exercises
  exercises = exercises.sort((a, b) => 0.5 - Math.random());
  console.log(exercises);
  current_exercise.ex = exercises[0]["word"];
  current_solution.ex = exercises[0]["back"];
  current_phrase.ex = exercises[0]["phrase"];
  //Collapse the preferences menu
  show_preferences.value = false;
  show_solution.value = false;
  // console.log(show_solution.value);
}

function setSelected(event) {
  // console.log(checkedWords);
  // exercises = checkedWords.value;
  // exercises = [];
  // checkedWords.value.forEach(function (word) {
  //       exercises.push(word);
  //   });
  // console.log(exercises);
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

function correctAnswered(){
  toggleShowSolution();
  console.log("here");
  console.log(exercises[0]);
  console.log(exercises);
  exercises[0]["corrects"] = exercises[0]["corrects"] + 1;
  exercises[0]["attempts"] = exercises[0]["attempts"] + 1;
  
  //Pupil knows the word
  if((exercises[0]["corrects"] >= 2) && (exercises[0]["corrects"]/exercises[0]["attempts"] > 0.5)){
    exercises.splice(0,1);
    progress_percentage = 100 - Math.floor((exercises.length/checkedWords.value.length)*100);
    console.log(exercises.length);
    // console.log(this.checkedWords.length);
    console.log(progress_percentage);
  }
  //Swap the word with a random word in the array
  else{
    var random_index = Math.floor(Math.random() * (exercises.length-2)) + 1;
    var temp = exercises[0];
    exercises[0] = exercises[random_index];
    exercises[random_index] = temp;
  }

  current_exercise.ex = exercises[0]["word"];
  current_solution.ex = exercises[0]["back"];
  current_phrase.ex = exercises[0]["phrase"];
}

function wrongAnswered(){
  toggleShowSolution();

  exercises[0]["attempts"] = exercises[0]["attempts"] + 1;

  //Swap the word with a random word in the array
  var random_index = Math.floor(Math.random() * (exercises.length-2)) + 1;
  var temp = exercises[0];
  exercises[0] = exercises[random_index];
  exercises[random_index] = temp;

  current_exercise.ex = exercises[0]["word"];
  current_solution.ex = exercises[0]["back"];
  current_phrase.ex = exercises[0]["phrase"];
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

        <h2 class="flex justify-center pt-2 pb-2 pl-2 pr-2 pl-2 pr-2 ml-2 mr-2   md:w-1/2 lg:w-1/3 md:mx-auto font-bold">{{title}}: vocabularium oefenen </h2>

      <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 bg-zinc-200 text-amber-500 pl-2 pr-2 ml-2 mr-2   md:w-1/2 lg:w-1/3 md:mx-auto font-bold" @click="toggleShowPreferences($event)">
                  &#8595 Instellingen &#8595
      </div>
      <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 text-sm bg-zinc-200 text-amber-500 pl-2 pr-2 ml-2 mr-2   md:w-1/2 lg:w-1/3 md:mx-auto font-bold" @click="toggleShowPreferences($event)">
                  Er zijn momenteel {{this.checkedWords.length}} woorden geselecteerd. Klik hier om te wijzigen.
      </div>
      <div v-if="show_preferences" class="pt-2 pb-2 pl-2 pr-2 bg-white pt-2 pb-2 pl-2 pr-2 ml-2 mr-2 mt-2 md:w-1/2 lg:w-1/3 md:mx-auto">

            <div class="mb-2">
              Selecteer de woorden die je wil oefenen.
            </div>
            <div class="mb-2">
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectAll">Alles</button>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectNone">Niets</button>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectFirstHalf">1e helft</button>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="selectSecondHalf">2e helft</button>
            </div>

            <div class="text-center inline-block pr-1" 
                    v-for="(word, index) in voc" >
               <input :id="word.id" :value="word" name="word" type="checkbox" v-model="checkedWords" class="pr-1" />
               <label :for="word.id" class="pl-2 font-bold"><span>{{word["word"]}}</span></label> 
            </div>

            <div class="mb-2 flex justify-center pt-2 pb-2 pl-2 pr-2">
              <button class="bg-green-700 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-1 ml-2 mr-2 mt-2 md:mx-auto" @click="start">START</button>
            </div>
      </div>


      <div v-if="!show_solution"  id="currentFront" @click="toggleShowSolution" class="bg-yellow-100 mt-4 px-4 py-4 w-3/4 md:w-1/3 text-3xl mx-auto font-bold">
        <div class="flex justify-center">
          {{current_exercise.ex}}
        </div>
        <div class="flex justify-center text-sm">
         {{current_phrase.ex}}
        </div> 
      </div>

      <div v-if="show_solution"  id="currentBack" @click="toggleShowSolution" class="flex justify-center bg-yellow-100 mt-4 px-4 py-4 w-3/4 md:w-1/3 text-xl mx-auto font-bold">
        {{current_solution.ex}}
      </div>

      <div v-if="show_solution"  id="evaluation" class="flex justify-center mt-4 px-4 py-4 w-3/4 md:w-1/3 text-xl mx-auto font-bold">
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-1  animate-bounce" @click="correctAnswered">Ik wist het!</button>
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-1 animate-bounce" @click="wrongAnswered" >Ik wist het niet ...</button>
      </div>


      <div class="grid grid-cols-12 bg-yellow-400 rounded-full pt-2 pb-2 ml-1 mr-1 mt-4 lg:w-1/2">
        <div class="col-span-6 bg-yellow-200 rounded-full animate-pulse ml-1 mr-1 text-center font-bold text-2xl">{{this.progress_percentage}}%</div>
      </div>


    </div>

</template>