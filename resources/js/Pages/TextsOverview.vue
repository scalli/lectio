<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  text_infos: Object,
});

const text_infos = reactive(props.text_infos);
const title = props.title;

const selected = reactive({ index: 0 });

function setSelected(event) {
  selected.index = event.target.id;
  // console.log(selected.index);
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
      </template>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div
      v-for="(text) in text_infos"
      :id="text.id"
      :key="text.id"
      class="ml-4 mr-4 text-gray-700 font-bold"
      @click="setSelected($event)"
    >
      <div class="mb-2 pl-2 text-lg bg-orange-300 text-gray-600 font-bold">
        <div>
          {{ text.text_title }}
        </div>
        <div class="text-gray-500 text-sm">
          Naar: {{ text.author }}, {{ text.work }} {{ text.passage }}
        </div>
        <div class="text-gray-500 text-sm">
          Uit: {{ text.method }}, {{ text.chapter }} (graad: {{ text.grade }})
        </div>
        <div class="text-gray-500 text-sm">
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
            >In woordgroepen lezen</Link
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