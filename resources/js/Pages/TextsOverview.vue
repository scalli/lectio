<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";
import { Inertia } from '@inertiajs/inertia';
import Menu from '@/Pages/Menu.vue';

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  text_infos: Object,
});

const text_infos = reactive(props.text_infos);
const title = props.title;

const selected = reactive({ index: 0 });

const show_filter= ref(false);

//Fields from the filter
const text_title = ref("");
const method = ref("");
const grade = ref("");
const author = ref("");
const work = ref("");
const selected_texts = text_infos;

function setSelected(event) {
  selected.index = event.target.id;
  // console.log(selected.index);
}

function toggleShowFilter(event){
    this.show_filter = !this.show_filter;
}

function applyFilter(event){

  console.log(props.text_infos);

  Inertia.post('/filterTextsOverwiew', {
    title: this.text_title,
    method: this.method,
    grade: this.grade,
    author: this.author,
    work: this.work
  })

  this.toggleShowFilter();

  // console.log(this.selected_texts);
  
  // console.log(this.text_infos);
  // console.log(this.selected_texts);
  // this.selected_texts = [];

  // this.text_infos.forEach(text => {;
  //   if(
  //     // text.text_title.includes(this.text_title) && text.method.includes(this.method)
  //      textTitleFilter(text) && textMethodFilter(text)
  //       && text.grade.includes(this.grade) && text.author.includes(this.author)
  //       && text.work.includes(this.work)){
  //     this.selected_texts.push(text);
  //   }
  // });


  // this.toggleShowFilter();

  // console.log(this.selected_texts);
}

// function textTitleFilter (text){
//   // if(!(this.text_title.value) == ''){
//   //       return true;
//   // }
//   // else{
//   //   return text.text_title.includes(this.text_title);
//   // }

//   return (text.text_title.includes(this.text_title) || this.text_title.length == 0);
// }

// function textMethodFilter (text){
//   // if(!(this.method.value.length) == ''){
//   //   return true;
//   // }
//   // else{
//   //   return text.method.includes(this.method);
//   // }
//     return (text.method.includes(this.method) || this.method.length == 0);
// }

function clearFilter(event){
  // this.selected_texts = this.text_infos;

    this.text_title = "";
    this.method = "";
    this.grade = "";
    this.author = "";
    this.work = "";

this.toggleShowFilter();

  Inertia.post('/filterTextsOverwiew', {
    title: this.text_title,
    method: this.method,
    grade: this.grade,
    author: this.author,
    work: this.work
  })
}
</script>

<template>
  <Head title="Beschikbare teksten" />

  <div class="bg-gray-100 dark:bg-gray-900">
    <div v-if="canLogin" class="px-6 py-4">
      <Link
        v-if="$page.props.user"
        :href="route('dashboard')"
        class="text-sm text-gray-700 underline"
      >
        Dashboard
      </Link>

      <template v-else>
        <Menu>
        </Menu>
        <!--
        <div class="grid grid-cols-2 justify-items-end">
          <div>
            <Link
              :href="route('login')"
              class="text-sm text-gray-700 underline text-right"
            >
              Log in
            </Link>
          </div>

          <div>
            <Link
              v-if="canRegister"
              :href="route('register')"
              class="ml-4 text-sm text-gray-700 underline text-right"
            >
              Register
            </Link>
          </div>
        </div>
        -->
      </template>
    </div>

    <div class="flex justify-center pt-2 pb-2 pl-2 pr-2 text-pink-500 bg-zinc-200 pl-2 pr-2 ml-2 mr-2  w-1/2 md:w-1/2 lg:w-1/3 md:mx-auto font-bold" @click="toggleShowFilter($event)">
        &#8595; Filter &#8595;
    </div>
    <div class="pt-2 pb-2 pl-2 pr-2 bg-zinc-200 pl-2 pr-2 ml-2 mr-2 mb-2  md:w-1/2 lg:w-1/3 md:mx-auto" v-if="show_filter" >
            <div class="grid grid-cols-9 gap-4 mb-2 pl-2 mr-2 pt-2">
              <label class="col-span-2 pr-2" for="text_title">Titel:</label>
              <input
                class="col-span-7 border-solid border-2 rounded border-pink-500"
                v-model="text_title"
                name="text_title"
                size="60"
              />
            </div>

            <div class="grid grid-cols-9 gap-4 mb-2 pl-2 mr-2 pt-2">
              <label class="col-span-2 pr-2 mr-2" for="method">Methode:</label>
              <input
                class="col-span-7 border-solid border-2 rounded border-pink-500"
                v-model="method"
                name="method"
                size="60"
              />
            </div>

            <div class="grid grid-cols-9 gap-4 mb-2 pl-2 mr-2 pt-2">
              <label class="col-span-2 pr-2" for="grade">Graad:</label>
              <input
                class="col-span-7 border-solid border-2 rounded border-pink-500"
                v-model="grade"
                name="grade"
                size="60"
              />
            </div>

            <div class="grid grid-cols-9 gap-4 mb-2 pl-2 mr-2 pt-2">
              <label class="col-span-2 pr-2" for="author">Auteur:</label>
              <input
                class="col-span-7 border-solid border-2 rounded border-pink-500"
                v-model="author"
                name="author"
                size="60"
              />
            </div>

            <div class="grid grid-cols-9 gap-4 mb-2 pl-2 mr-2 pt-2">
              <label class="col-span-2 pr-2" for="work">Werk:</label>
              <input
                class="col-span-7 border-solid border-2 rounded border-pink-500"
                v-model="work"
                name="work"
                size="60"
              />
            </div>

            <div class="col-span-1 text-center">
              <button
                :class="{ 'bg-green-500': step == 1 }"
                class="
                  bg-lime-500
                  hover:bg-lime-400
                  text-white
                  font-bold
                  py-2
                  px-4
                  rounded
                  mr-1
                  text-center
                "
                @click="applyFilter($event)"
              >
                Filter toepassen
              </button>

              <button
                :class="{ 'bg-green-500': step == 1 }"
                class="
                  bg-lime-500
                  hover:bg-lime-400
                  text-white
                  font-bold
                  py-2
                  px-4
                  rounded
                  mr-1
                  text-center
                "
                @click="clearFilter($event)"
              >
                Filter wissen
              </button>
            </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
    <div
      v-for="(text) in props.text_infos"
      :id="text.id"
      :key="text.id"
      class="ml-4 mr-4 text-gray-700 font-bold"
      @click="setSelected($event)"
    >
      <div class="border-lime-500 mb-2 pl-2 text-lg text-gray-700 border-2 bg-gray-50 font-bold rounded">
        <div class="text-pink-500">
          {{ text.text_title }}
        </div>
        <div class="text-sm break-words">
          Naar: {{ text.author }}, {{ text.work }} {{ text.passage }}
        </div>
        <div class="text-sm">
          Uit: {{ text.method }}, {{ text.chapter }} (graad: {{ text.grade }})
        </div>
        <div class="text-sm">
          {{ text.extra_info }}
        </div>

        <div class="pt-2">
          <Link
            :href="'/text/normal/' + text.id"
            class="ml-4 text-sm text-gray-700 underline text-right"
            >Lezen</Link
          >
          <Link
            :href="'/text/classic/' + text.id"
            class="ml-4 text-sm text-gray-700 underline text-right"
            >Lineair lezen</Link
          >
          <Link
            :href="'/text/cola/' + text.id"
            class="ml-4 text-sm text-gray-700 underline text-right"
            >In cola lezen</Link
          >
        </div>
        <div>
          <Link
            :href="'/voc/quick/' + text.id"
            class="ml-4 text-sm text-gray-700 underline text-right"
            >Snel voc. oefenen</Link
          >
          <Link
            :href="'/voc/profound/' + text.id"
            class="ml-4 text-sm text-gray-700 underline text-right"
            >Intensief voc. oefenen</Link
          >
        </div>
      </div>

    </div>
    </div>
  </div>
</template>