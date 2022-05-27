<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive, ref, computed } from 'vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import ConfettiExplosion from "vue-confetti-explosion";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    // phrases: Object,
    // voc_front: Array,
    // voc_back: Array,
    voc: Array,
    title: String,
    // attempts: Number,
    // corrects: Number
});

// const phrases = props.phrases;
const title = props.title;
const voc = props.voc;

const checkedWords = ref([]);
var exercises = [];
const current_exercise = reactive({ex : ""});
const current_solution = reactive({ex : ""});
const current_phrase = reactive({ex : ""});

const show_preferences= ref(false);
const show_solution = ref(false);

const progress_percentage = reactive({val : 0});
// const word_count = computed(() => checkedWords.value.length);
// const progress_percentage = computed(() => 100 - Math.floor((exercises.length/word_count)*100));

const isOneTwelfth = ref(false);
const isTwoTwelfth = ref(false);
const isThreeTwelfth = ref(false);
const isFourTwelfth = ref(false);
const isFiveTwelfth = ref(false);
const isSixTwelfth = ref(false);
const isSevenTwelfth = ref(false);
const isEightTwelfth = ref(false);
const isNineTwelfth = ref(false);
const isTenTwelfth = ref(false);
const isElevenTwelfth = ref(false);
const isTwelveTwelfth = ref(false);

var box1 = [];
var box2 = [];
var box3 = [];
var box4 = [];

const box1_length = computed(() => box1.length);

const show_phrase = ref(true);

const confetti = ref(false);

const audio_on = ref(false);

const box1To2 = ref(false);
const box2To3 = ref(false);
const box3To4 = ref(false);
const box2To1 = ref(false);
const box3To2 = ref(false);

const wordinfo1CorrectExists = ref(false);

function toggleShowPreferences(event){
    this.show_preferences = !this.show_preferences;
}

function toggleShowSolution(event){
    show_solution.value = !show_solution.value;
}

function start(event){
  //Empty all boxes for a fresh start
  box1.length = 0;
  box2.length = 0;
  box3.length = 0;
  box4.length = 0;

  checkedWords.value.forEach(function (word) {
        word["corrects"] = 0;
        word["attempts"] = 0;
        word["box"] = 1
;       box1.push(word);
    });
  //Shuffle array exercises
  box1 = box1.sort((a, b) => 0.5 - Math.random());
  console.log(box1);
  current_exercise.ex = box1[0];
  console.log("current excercise");
  console.log(current_exercise.ex);
  console.log(current_exercise.ex['word_complete']['wordinfo1']);
  if(current_exercise.ex['word_complete']['wordinfo1'] != null){
    wordinfo1CorrectExists.value = true;
  }
  else{
    wordinfo1CorrectExists.value = false;
  }
  // current_solution.ex = box1[0]["back"];
  // current_phrase.ex = box1[0]["phrase"];
  //Collapse the preferences menu
  show_preferences.value = false;
  show_solution.value = false;
  // count = 0;
  // console.log(show_solution.value);
  progress_percentage.val = 0;

  isOneTwelfth.value = false;
  isTwoTwelfth.value = false;
  isThreeTwelfth.value = false;
  isFourTwelfth.value = false;
  isFiveTwelfth.value = false;
  isSixTwelfth.value = false;
  isSevenTwelfth.value = false;
  isEightTwelfth.value = false;
  isNineTwelfth.value = false;
  isTenTwelfth.value = false;
  isElevenTwelfth.value = false;
  isTwelveTwelfth.value = false;

  confetti.value = false;
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


function moveFirstElementFromBox1ToBox2(box1, box2){
    box1[0]["corrects"] = box1[0]["corrects"] + 1;
    box1[0]["attempts"] = box1[0]["attempts"] + 1;
    box1[0]["box"] = 2;
    box2.push(box1[0]);
    box1.splice(0,1);
    // console.log(box1);
    // console.log(box2);
}

function moveFirstElementFromBox2ToBox3(box2, box3){
    box2[0]["corrects"] = box2[0]["corrects"] + 1;
    box2[0]["attempts"] = box2[0]["attempts"] + 1;
    box2[0]["box"] = 3;
    box3.push(box2[0]);
    box2.splice(0,1);
    // console.log(box2);
    // console.log(box3);
}

function moveFirstElementFromBox3ToBox4(box3, box4){
    box3[0]["corrects"] = box3[0]["corrects"] + 1;
    box3[0]["attempts"] = box3[0]["attempts"] + 1;
    box3[0]["box"] = 4;
    box4.push(box3[0]);
    box3.splice(0,1);
    // console.log(box1);
    // console.log(box2);
}

function moveFirstElementFromBox3ToBox1(box3, box1){
    box3[0]["attempts"] = box3[0]["attempts"] + 1;
    box3[0]["box"] = 1;
    box1.push(box3[0]);
    box3.splice(0,1);
}

function moveFirstElementFromBox2ToBox1(box2, box1){
    box2[0]["attempts"] = box2[0]["attempts"] + 1;
    box2[0]["box"] = 1;
    box1.push(box2[0]);
    box2.splice(0,1);
}

//Set following card to study
function setNextCardToStudy(){
  if((box1.length + box2.length + box3.length) == 0){
    console.log("You know everything!");
    //Splash screen here 
  }
  //With over 80% probability, try to pick a card from most populated box first
  else { if(!getCardFromMostPopulatedBox()){
    getCardFromRandomBox();
    }
  }
}

function getCardFromMostPopulatedBox(){
  var rand = Math.floor(Math.random() * 10);
  console.log(rand);
  if(rand > 6){
    var array = [box1.length, box2.length, box3.length];
    var highestValue = array.indexOf(Math.max(...array));
    // var highestValue = Math.max(...array.map(o => o.y));

    if(highestValue == 0){
      current_exercise.ex = box1[0];
    }
    if(highestValue == 1){
      current_exercise.ex = box2[0];
    }
    if(highestValue == 2){
      current_exercise.ex = box3[0];
    }
    return true;
  }
  return false;
}

function getCardFromRandomBox(){
  var boxNumbersContainingElements = [];
  if(box1.length > 0){
    boxNumbersContainingElements.push(1);
  }
  if(box2.length > 0){
    boxNumbersContainingElements.push(2);
  }
  if(box3.length > 0){
    boxNumbersContainingElements.push(3);
  }
  //Pick random element from the array
  const randomElement = boxNumbersContainingElements[Math.floor(Math.random() * boxNumbersContainingElements.length)];

  if(randomElement == 1){
    current_exercise.ex = box1[0];
  }
  if(randomElement == 2){
    current_exercise.ex = box2[0];
  }
  if(randomElement == 3){
    current_exercise.ex = box3[0];
  }
}

function clearArrows(){
  box1To2.value = false;
  box2To3.value = false;
  box3To4.value = false;
  box2To1.value = false;
  box3To2.value = false;
}

function correctAnswered(){
  if(audio_on.value){
    // var audio = new Audio('https://www.myinstants.com/media/sounds/ding-sound-effect_1.mp3');
    var audio = new Audio('../../correct.mp3');
    audio.play();
  }
  
  toggleShowSolution();

  clearArrows();

  if(current_exercise.ex["box"] == 1){
    box1To2.value = true;
    moveFirstElementFromBox1ToBox2(box1, box2);
    shuffle(box2);
  }
  else{
      if(current_exercise.ex["box"] == 2){
        box2To3.value = true;
        moveFirstElementFromBox2ToBox3(box2, box3);
        shuffle(box3);
      }
      else {
          if(current_exercise.ex["box"] == 3){
            box3To4.value = true;
            moveFirstElementFromBox3ToBox4(box3, box4);
          //No more words left to study
          if((box1.length + box2.length + box3.length) == 0){
             if(audio_on.value){ 
              var audio = new Audio('../../applause.mp3');
              audio.play();
            }
            confetti.value = true;
          }
        }
      }//end of else 2
  }//end of else 1

  
  setNextCardToStudy(); 

  setProgress();
  
}//end of correctAnswered

function wrongAnswered(){
   if(audio_on.value){
    var audio = new Audio('../../wrong.wav');
    audio.play();
   } 
    
  toggleShowSolution();

  clearArrows();

  if(current_exercise.ex["box"] == 2){
    box2To1.value = true;
    moveFirstElementFromBox2ToBox1(box2, box1);
  }
  else {
      if(current_exercise.ex["box"] == 3){
        box2To1.value = true;
        box3To2.value = true;
        moveFirstElementFromBox3ToBox1(box3, box1);
      }
  }//end of else
  shuffle(box1);
  
  setNextCardToStudy();

  setProgress();

}

function setProgress(){
  //Set the progress
  progress_percentage.val = Math.round(((box2.length*1/3 + box3.length*2/3 + box4.length)/checkedWords.value.length)*100);

  if(progress_percentage.val > 0 && progress_percentage.val < 1*100/12){
    isOneTwelfth.value = true;
  }
  if(progress_percentage.val >= 1*100/12 && progress_percentage.val < 2*100/12){
    isTwoTwelfth.value = true;
  }
    if(progress_percentage.val >= 2*100/12 && progress_percentage.val < 3*100/12){
    isThreeTwelfth.value = true;
  }
    if(progress_percentage.val >= 3*100/12 && progress_percentage.val < 4*100/12){
    isFourTwelfth.value = true;
  }
  if(progress_percentage.val >= 4*100/12 && progress_percentage.val < 5*100/12){
    isFiveTwelfth.value = true;
  }
    if(progress_percentage.val >= 5*100/12 && progress_percentage.val < 6*100/12){
    isSixTwelfth.value = true;
  }
   if(progress_percentage.val >= 6*100/12 && progress_percentage.val < 7*100/12){
    isSevenTwelfth.value = true;
  }
  if(progress_percentage.val >= 7*100/12 && progress_percentage.val < 8*100/12){
    isEightTwelfth.value = true;
  }
    if(progress_percentage.val >= 8*100/12 && progress_percentage.val < 9*100/12){
    isNineTwelfth.value = true;
  }
    if(progress_percentage.val >= 9*100/12 && progress_percentage.val < 10*100/12){
    isTenTwelfth.value = true;
  }
  if(progress_percentage.val >= 10*100/12 && progress_percentage.val < 11*100/12){
    isElevenTwelfth.value = true;
  }
    if(progress_percentage.val >= 11*100/12 && progress_percentage.val <= 12*100/12){
    isTwelveTwelfth.value = true;
  }
}

function shuffle(array) {
  let currentIndex = array.length,  randomIndex;

  // While there remain elements to shuffle.
  while (currentIndex != 0) {

    // Pick a remaining element.
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    // And swap it with the current element.
    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex], array[currentIndex]];
  }

  return array;
}

function evaluate(){

}

</script>

<template>
    <Head title="Voc. oefenen" />

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
                  {{this.checkedWords.length}} woorden geselecteerd. Klik hier om te wijzigen.
      </div>
      <div v-if="show_preferences" class="pt-2 pb-2 pl-2 pr-2 bg-white pt-2 pb-2 pl-2 pr-2 ml-2 mr-2 mt-2 md:w-1/2 lg:w-1/3 md:mx-auto">

           <div>
              <input type="checkbox" id="show_phrase" v-model="show_phrase" />
              <label for="show_phrase" class="pl-2 font-bold">Toon woordgroepen</label>
           </div>

           <div>
              <input type="checkbox" id="audio_on" v-model="audio_on" />
              <label for="audio_on" class="pl-2 font-bold">Audio aan</label>
           </div>

            <div class="mb-2">
              Selecteer de woorden die je wil oefenen.
            </div>
            <div class="mb-2">
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectAll">Alles</button>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectNone">Niets</button>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="selectFirstHalf">1e helft</button>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="selectSecondHalf">2e helft</button>
            </div>

            <div class="grid grid-cols-3 gap-1">
              <div v-for="(word, index) in voc" >
                 <div>
                   <input :id="word.id" :value="word" name="word" type="checkbox" v-model="checkedWords" class="pr-1" />
                   <label :for="word.id" class="pl-2 font-bold"><span>{{word["word"]}}</span></label> 
                 </div>
              </div>
            </div>

            <div class="mb-2 flex justify-center pt-2 pb-2 pl-2 pr-2">
              <button class="bg-green-700 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-1 ml-2 mr-2 mt-2 md:mx-auto" @click="start">START</button>
            </div>
      </div>


      <div v-if="!show_solution"  id="currentFront" @click="toggleShowSolution" class="bg-yellow-100 mt-4 px-4 py-4 w-3/4 md:w-1/3 text-3xl mx-auto font-bold">
        <div class="flex justify-center">
          {{current_exercise.ex["word"]}}
        </div>
        <div v-if="show_phrase" class="flex justify-center text-sm">
         {{current_exercise.ex["phrase"]}}
        </div> 
      </div>

      <div v-if="show_solution"  id="currentBack" @click="toggleShowSolution" class="flex justify-center bg-yellow-100 mt-4 px-4 py-4 w-3/4 md:w-1/3 text-xl mx-auto font-bold">
        {{current_exercise.ex["back"]}}
      </div>


      <div>{{current_exercise.ex["word"]}}</div>
      <form>
      <input v-if="wordinfo1CorrectExists" type="text" id="wordinfo1Answer" v-model="wordinfo1Answer" />
      </form>


      <div  id="evaluation" class="flex justify-center mt-4 px-4 py-4 w-3/4 md:w-1/3 text-xl mx-auto font-bold">
        <button class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-1" @click="evaluate">Controleer!</button>
      </div>


      <div class="grid grid-cols-12">
        <div class="grid grid-cols-12 bg-yellow-400 rounded-full pt-2 pb-2 ml-1 mr-1 mt-4 col-start-1 col-end-12 md:col-start-5 md:col-end-9">
          <div :class="{ 'col-span-1': isOneTwelfth,  'col-span-2': isTwoTwelfth, 'col-span-3': isThreeTwelfth, 'col-span-4': isFourTwelfth,  'col-span-5': isFiveTwelfth, 'col-span-6': isSixTwelfth, 
            'col-span-7': isSevenTwelfth,  'col-span-8': isEightTwelfth, 'col-span-9': isNineTwelfth,
            'col-span-10': isTenTwelfth,  'col-span-11': isElevenTwelfth, 'col-span-12': isTwelveTwelfth}"
          class="bg-yellow-200 rounded-full animate-pulse ml-1 mr-1 text-center font-bold text-2xl ">{{progress_percentage.val}}%</div>
        </div>
      </div>

      <div class="grid grid-cols-12 pt-2 pb-2 ml-1 mr-1 mt-4">
        <div class="grid grid-cols-7 gap-1 col-start-1 col-span-12 md:col-start-3 md:col-end-10">
          <div>
            <div class="bg-amber-500 text-zinc-100 border-4 border-red-500 border-t-0 text-center px-4 py-6 font-bold">
              {{box1.length}}
            </div>
            <div class="text-center text-blue-500 text-3xl" v-if="current_exercise.ex['box'] == 1">*</div>
          </div>

          <div>
            <div class="text-green-500 text-center text-3xl animate-ping font-bold" v-if="box1To2">&#8594;</div>
            <div class="text-red-500 text-center text-3xl animate-ping font-bold" v-if="box2To1">&#8592;</div>
          </div>
          
          <div>
            <div class="bg-amber-500 text-zinc-100 border-4 border-orange-500 border-t-0 text-center px-4 py-6 font-bold">{{box2.length}}</div>
            <div class="text-center text-blue-500 text-3xl" v-if="current_exercise.ex['box'] == 2">*</div>
          </div>
          
          <div>
            <div class="text-green-500 text-center text-3xl animate-ping font-bold" v-if="box2To3">&#8594;</div>
            <div class="text-red-500 text-center text-3xl animate-ping font-bold" v-if="box3To2">&#8592;</div>
          </div>

          <div>
            <div class="bg-amber-500 text-zinc-100 border-4 border-yellow-500 border-t-0 text-center px-4 py-6 font-bold">{{box3.length}}</div>
              <div class="text-center text-blue-500 text-3xl" v-if="current_exercise.ex['box'] == 3">*</div>
          </div>
          
          <div>
            <div class="text-green-500 text-center text-3xl animate-ping font-bold" v-if="box3To4">&#8594;</div>
          </div>
          
          <div>
            <div class="bg-amber-500 text-zinc-100 border-4 border-green-500 border-t-0 text-center px-4 py-6 font-bold">{{box4.length}}</div>
            </div>
          </div>
      </div>

      <ConfettiExplosion v-if="confetti" :particleCount="200"/>

    </div>

</template>