<script setup>
import { reactive, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  vocs: Object,
  part_of_speeches: Object,
});

const vocs = props.vocs;
const part_of_speeches = props.part_of_speeches;

const message = ref("");
const textarea_phrases = ref([]);
const text_words_arr = ref([]);
const text_words_arr_new = ref([]);
//array containing the string representations of each phrase
const text_phrases = ref([]);
//array containing the supporting question of each phrase
// const supporting_questions = ref([]);
//array containing the phrase support of each phrase
// const phrase_supports = ref([]);

const form = useForm({
  groundword: null,
  memorize: 0,
  wordinfo1: null,
  wordinfo2: null,
  wordinfo3: null,
  wordinfo4: null,
  meaning1: null,
  meaning2: null,
  meaning3: null,
  meaning4: null,
  part_of_speech: null,
  parentheses: null,
  redirect_url: "newtext",
});

// const groundword = ref("");
// const memorize = ref(0);
// const wordinfo1 = ref("");
// const wordinfo2 = ref("");
// const wordinfo3 = ref("");
// const wordinfo4 = ref("");
// const meaning1 = ref("");
// const meaning2 = ref("");
// const meaning3 = ref("");
// const meaning4 = ref("");
// const part_of_speech = ref("");
// const parentheses = ref("");
// const contributor = 1; //TODO get user id of contributor

function logSupportingQuestion($event) {
  // console.log(supporting_questions.value);
  // console.log(phrase_supports.value);

  // console.log(vocs);
  console.log(text_words_arr.value);
  console.log(text_phrases.value);
}

// function addSupportingQuestion() {
//   supporting_questions.value.forEach(function (supporting_question, index) {
//     text_words_arr.value.forEach(function (word, wordindex) {
//       if (
//         (word.phrase_number == index &&
//           wordindex > 0 &&
//           text_words_arr.value[wordindex - 1].phrase_number !=
//             word.phrase_number) ||
//         word.position == 1
//       ) {
//         word.supporting_question = supporting_question;
//         // console.log(supporting_question);
//       }
//     });
//   });
// }

// function addPhraseSupport() {
//   phrase_supports.value.forEach(function (phrase_support, index) {
//     text_words_arr.value.forEach(function (word, wordindex) {
//       if (
//         (word.phrase_number == index &&
//           wordindex - 1 > -1 &&
//           text_words_arr.value[wordindex - 1].phrase_number !=
//             word.phrase_number) ||
//         word.position == 1
//       ) {
//         word.phrase_support = phrase_support;
//         // console.log(supporting_question);
//       }
//       // word.phrase_support = phrase_support;
//     });
//   });
// }

function updateText(event) {
  console.log(message.value);
  textarea_phrases.value = message.value.split("\n");
  console.log(textarea_phrases.value);
  text_phrases.value = Array(textarea_phrases.value.length + 1).fill("");
  //   supporting_questions.value = Array(textarea_phrases.value.length).fill("");
  //   phrase_supports.value = Array(textarea_phrases.value.length).fill("");

  var position = 1;
  var phrase_number = 1;
  var text_words = [];
  text_words_arr_new.value = [];

  textarea_phrases.value.forEach(function (phrase) {
    let phrase_arr = phrase.split(" ");
    console.log(phrase_arr);

    phrase_arr.forEach(function (word) {
      console.log(word);

      let word_obj = {
        text_info_id: 0,
        position: position,
        text_word: word,
        word_voc: 0,
        phrase_number: phrase_number,
        supporting_question: "",
        phrase_support: "",
      };

      position = position + 1;
      // console.log(text_words_arr.value);

      text_words_arr_new.value.push(word_obj);
    });

    phrase_number = phrase_number + 1;
  });

  console.log(text_words_arr_new.value);

  //Try to keep the changes already made to voc in lower part of screen
  text_words_arr_new.value.forEach(function (newWord) {
    text_words_arr.value.forEach(function (oldWord) {
      if (newWord["text_word"] == oldWord["text_word"]) {
        if (oldWord["word_voc"] != 0) {
          newWord["word_voc"] = oldWord["word_voc"];
        }
        if (oldWord["supporting_question"] != "") {
          newWord["supporting_question"] = oldWord["supporting_question"];
        }
        if (oldWord["phrase_support"] != "") {
          newWord["phrase_support"] = oldWord["phrase_support"];
        }
      }
    });
  });

  text_words_arr.value = [];
  text_words_arr.value = text_words_arr_new.value;

  // text_phrases.value = Array(24).fill("");
  text_words_arr.value.forEach(function (word) {
    text_phrases.value[word.phrase_number] =
      text_phrases.value[word.phrase_number] + word.text_word + " ";
  });

  console.log(text_phrases);
  console.log(text_words_arr.value);
  //   console.log(supporting_questions.value);
}

function isFirstWordInPhrase($word, $phrase) {
  return $phrase.startsWith($word);
}
</script>

<template>
  <!-- Textarea to put text in -->
  <div class="ml-2 mt-2 text-center">
    <div class="ml-2 mr-2">
      <textarea
        v-model="message"
        class="w-5/6"
        placeholder="Voeg hier je tekst in cola in."
      ></textarea>
    </div>
    <div class="text-center">
      <button
        class="
          bg-blue-500
          hover:bg-blue-700
          text-white
          font-bold
          py-2
          px-4
          rounded
          mr-1
          text-center
        "
        @click="updateText($event)"
      >
        Wijzig
      </button>
    </div>
  </div>

  <div class="grid grid-cols-3 gap-4 ml-2 mr-2">
    <!-- left column for page for text-->
    <div class="col-span-2 ml-2 scroll-auto max-h-screen overflow-scroll">
      <div v-for="(phrase, index) in text_phrases" v-bind:key="phrase">
        <div
          v-if="phrase != ''"
          class="mt-2 bg-blue-700 text-white font-bold py-2 px-4"
        >
          {{ phrase }}
        </div>
        <div class="pl-2 w-full bg-blue-100">
          <div
            class="mb-2"
            v-for="word in text_words_arr"
            v-bind:key="word.position"
          >
            <div>
              <div
                class="w-full mb-2"
                v-if="
                  word.phrase_number == index &&
                  isFirstWordInPhrase(word.text_word, phrase)
                "
              >
                <label class="pr-1" for="supporting_question"
                  >Ondersteuningsvraag:</label
                >
                <input
                  class="w-full border-solid border-2 rounded border-black"
                  v-model="word.supporting_question"
                  @click="logSupportingQuestion($event)"
                  name="supporting_question"
                  placeholder="Typ hier de ondersteuningsvraag bij lectuur"
                />
              </div>
              <div
                class="w-full mb-2"
                v-if="index != 0 && isFirstWordInPhrase(word.text_word, phrase)"
              >
                <label class="pr-1" for="phrase_support">Extra hulp:</label>
                <input
                  class="w-full border-solid border-2 rounded border-black"
                  v-model="word.phrase_support"
                  @click="logSupportingQuestion($event)"
                  name="phrase_support"
                  placeholder="Typ hier de extra hulp bij lectuur"
                />
              </div>
              <div
                v-if="word.phrase_number == index"
                class="grid grid-cols-6 gap-4"
              >
                <div class="col-span-2">
                  {{ word.text_word }}
                </div>
                <div class="col-span-4">
                  <select v-model="word.word_voc">
                    <option
                      v-for="voc_word in vocs"
                      :key="voc_word"
                      :value="voc_word.id"
                    >
                      {{ voc_word.word }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- right column for page to add voc to dictionary-->
    <form
      @submit.prevent="
        form.post('/voc', {
          preserveState: true,
          preserveScroll: true,
          onSuccess: () => form.reset(),
        })
      "
    >
      <div class="col-span-1 bg-orange-300 pl-1 mr-2">
        <div class="pr-1 mb-1 pt-2 pb-2 font-bold text-center bg-orange-500">
          Toevoegen aan woordenboek
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="groundword">Grondwoord:</label>
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.groundword"
            name="groundword"
            id="groundword"
          />
          <div class="text-red-700" v-if="form.errors.groundword">
            {{ form.errors.groundword }}
          </div>
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="wordinfo1">Woordinformatie 1:</label>
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.wordinfo1"
            name="wordinfo1"
            id="wordinfo1"
          />
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="wordinfo2">Woordinformatie 2:</label>
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.wordinfo2"
            name="wordinfo2"
            id="wordinfo2"
          />
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="wordinfo3">Woordinformatie 3:</label>
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.wordinfo3"
            name="wordinfo3"
            id="wordinfo3"
          />
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="wordinfo4">Woordinformatie 4:</label>
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.wordinfo4"
            name="wordinfo4"
            id="wordinfo4"
          />
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="meaning1">Betekenis 1:</label>
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.meaning1"
            name="meaning1"
            id="meaning1"
          />
          <div class="text-red-700" v-if="form.errors.meaning1">
            {{ form.errors.meaning1 }}
          </div>
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="meaning2">Betekenis 2:</label>
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.meaning2"
            name="meaning2"
            id="meaning2"
          />
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="meaning3">Betekenis 3:</label>
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.meaning3"
            name="meaning3"
            id="meaning3"
          />
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="meaning4">Betekenis 4:</label>
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.meaning4"
            name="meaning4"
            id="meaning4"
          />
        </div>
        <div class="pr-1 mb-1">
          <label class="pr-1" for="pos">Woordsoort</label>
          <select v-model="form.part_of_speech" name="pos" id="pos">
            <option v-for="pos in part_of_speeches" :key="pos" :value="pos.id">
              {{ pos.part_of_speech }}
            </option>
          </select>
          <div class="text-red-700" v-if="form.errors.part_of_speech">
            {{ form.errors.part_of_speech }}
          </div>
        </div>

        <div class="pr-1 mb-1">
          <label class="pr-1" for="parentheses"
            >Extra info (tussen haakjes):</label
          >
          <input
            class="w-full border-solid border-2 rounded border-black"
            v-model="form.parentheses"
            name="parentheses"
            id="parentheses"
          />
        </div>

        <div class="pr-1">
          <label class="pr-1" for="memorize">Te memoriseren:</label>
          <input
            type="checkbox"
            v-model="form.memorize"
            name="memorize"
            id="memorize"
          />
        </div>
        <div class="text-center mt-3 mb-2">
          <button
            type="submit"
            class="
              bg-orange-500
              hover:bg-orange-700
              text-white
              font-bold
              py-2
              px-4
              rounded
              mr-1
              text-center
            "
          >
            Voeg toe
          </button>
        </div>
      </div>
    </form>
  </div>
</template>