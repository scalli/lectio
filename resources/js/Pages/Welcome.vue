<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>


<template>

  <Head title="Welcome" />

  <div class="bg-gray-100 dark:bg-gray-900 h-screen">
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

      <div class="grid grid-cols-3 gap-4">
        <div></div>
        <div>
          <div class="ml-4 text-lg text-gray-700">Welkom!</div>
          <div class="ml-4 mb-4 text-gray-700">
            Latijn lezen mag en hoeft geen hele klus te zijn! Het kan
            ontspannend, leerrijk en fijn zijn. Om dit te bereiken is een beetje
            hulp bij het lezen echter vaak welkom. Dat is precies waarom deze
            website werd opgezet. Hij geeft je de nodige ondersteuning, zodat
            Latijn lezen (weer) fun wordt!
          </div>
          <div class="ml-4 mb-4 text-gray-700">
            Je krijgt de mogelijkheid om Latijnse teksten te lezen met
            verschillende vormen van ondersteuning (LECTIO). Zo kan eenieder Latijn lezen
            op de manier die hem/haar het beste past. Indien je dat graag wil,
            kun je ook het vocabularium inoefenen van teksten die je reeds las (REPETITIO).
            Maak hieronder je keuze.
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div
              class="
                pt-4
                pb-4
                pl-4
                pr-4
                bg-orange-300
                text-gray-700 text-center
                font-bold
              "
            >
              <Link :href="'/overview'">LECTIO</Link>
            </div>
            <div
              class="
                pt-4
                pb-4
                pl-4
                pr-4
                bg-orange-300
                text-gray-700 text-center
                font-bold
              "
            >
              <Link :href="'/voc/repetitio/step/1'"
                >REPETITIO</Link
              >
            </div>
          </div>
          <div></div>
        </div>
      </div>
    </div>
  </div>

</template>




