<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Menu from "@/Pages/Menu.vue";

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>


<template>
  <Head title="Latijnlezers" />

  <div class="bg-gray-100 dark:bg-gray-900">
    <div v-if="canLogin" class="px-6 py-4 bg-white">
      <Link
        v-if="$page.props.user"
        :href="route('dashboard')"
        class="text-sm text-gray-700 underline"
      >
        Dashboard
      </Link>

      <template v-else>
        <div class="bg-white"><Menu> </Menu></div>
        <!--
        <div class="grid grid-cols-2 justify-items-end bg-slate-50">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <Link
              :href="route('login')"
              class="text-sm text-gray-700 underline text-right"
            >
              Log in
            </Link>
          </h2>

          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <Link
              v-if="canRegister"
              :href="route('register')"
              class="ml-4 text-sm text-gray-700 underline text-right"
            >
              Register
            </Link>
          </h2>
        </div>
        -->
      </template>
    </div>

    <!-- Start of layout for mobile -->
    <div class="md:hidden">
      <div class="flex justify-center mb-4">
        <div
          class="
            w-128
            p-8
            text-4xl
            text-center
            text-pink-500
            font-bold
            bg-white
          "
        >
          Waar Latijn lezen
          <div class="italic inline"><i>fun</i></div>
          is!
        </div>
      </div>

      <div class="flex justify-center p-8">
        <div class="flex-initial md:w-128 p-2">
          <div
            class="
              border-lime-500
              bg-gray-50
              border-2
              rounded
              shadow-lg
              text-center
            "
          >
            <div class="p-2 opacity-50">
              <img src="././images/old-books.jpg" class="" />
            </div>
            <div
              class="
                inline-block
                text-lime-500
                font-bold
                align-middle
                place-items-center
              "
            >
              <div class="text-xl text-center">LECTIO</div>
              <div>Latijn lezen zonder zorgen</div>
              <div
                class="
                  p-4
                  m-2
                  bg-lime-500
                  text-white text-center
                  font-bold
                  rounded
                  border-2
                "
              >
                <Link :href="'/overview'">Nu lezen</Link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="flex justify-center p-8">
        <div class="flex-initial w-128 p-2">
          <div
            class="
              border-lime-500
              bg-gray-50
              border-2
              rounded
              shadow-lg
              text-center
            "
          >
            <div class="p-2 opacity-50">
              <img src="././images/old-dictionary.jpg" class="" />
            </div>
            <div
              class="
                inline-block
                text-center text-lime-500
                font-bold
                align-middle
                place-items-center
              "
            >
              <div class="text-xl">REPETITIO</div>
              <div>Efficiënt vocabularium oefenen</div>
              <div
                class="
                  p-4
                  m-2
                  bg-lime-500
                  text-white text-center
                  font-bold
                  rounded
                  border-2
                "
              >
                <Link :href="'/voc/repetitio/step/1'">Nu oefenen</Link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        class="
          flex
          justify-center
          text-center
          bg-white
          mx-auto
          pt-4
          pb-4
        "
      >
        <div
          class="flex-initial p-16 m-4 bg-gray-100 text-pink-500 font-bold"
        >
          <div class="text-4xl">18</div>
          <div>klassieke auteurs</div>
          <div class="p-4 text-center">
            <img src="././images/greek.png" class="h-24 mx-auto" />
          </div>
        </div>
      </div>
      <div
        class="
          flex
          justify-center
          text-center
          bg-white
          mx-auto
          pt-4
          pb-4
        "
      >
        <div
          class="flex-initial bg-gray-100 text-pink-500 font-bold p-16 m-4"
        >
          <div class="text-4xl">48</div>
          <div>Latijnse teksten</div>
          <div class="p-4 text-center">
            <img src="././images/poem.png" class="h-24 mx-auto" />
          </div>
        </div>
      </div>
      <div
        class="
          flex
          justify-center
          text-center
          bg-white
          mx-auto
          pt-4
          pb-4
        "
      >
        <div
          class="flex-initial bg-gray-100 text-pink-500 font-bold p-16 m-4"
        >
          <div class="text-4xl">1364</div>
          <div>Latijnse woorden</div>
          <div class="p-2 text-center">
            <img src="././images/book.png" class="h-24 mx-auto" />
          </div>
        </div>
      </div>

      <div class="flex justify-center p-8">
        <div>
          <p
            class="
              border-pink-500
              bg-gray-50
              border-2
              rounded
              shadow-lg
              text-center text-pink-500
              font-bold
              p-2
            "
          >
            Zelf leerkracht Latijn? Wil jij op deze manier ook graag teksten aan
            leerlingen aanbieden?
          </p>
          <p class="mt-2">
            We werken er hard aan om dit mogelijk te maken. Stuur een mailtje
            met je gegevens naar pascal_pieters@yahoo.com en we houden je zeker
            op de hoogte indien deze functie beschikbaar wordt.
          </p>
        </div>
      </div>
    </div>

    <!-- End of layout for mobile -->

    <!-- start of layout for medium screens and up -->
    <div class="hidden md:block">
      <div class="mb-4 ">
        <div
          class="
            text-4xl
            text-center
            text-pink-500
            font-bold
            bg-white
            pt-8
            pb-8
          "
        >
          Waar Latijn lezen <span class="italic">fun</span> is!
        </div>
      </div>

      <div class="flex justify-center p-8">
        <div class="flex-initial md:w-128 p-2">
          <div
            class="
              grid grid-cols-2
              gap-1
              border-lime-500
              bg-gray-50
              border-2
              rounded
              shadow-lg
            "
          >
            <div class="p-2 opacity-50">
              <img src="././images/old-books.jpg" class="" />
            </div>
            <div
              class="
                inline-block
                text-center text-lime-500
                font-bold
                align-middle
                grid
                place-items-center
              "
            >
              <div class="md:text-xl">LECTIO</div>
              <div>Latijn lezen zonder zorgen</div>
              <div
                class="
                  p-4
                  m-2
                  bg-lime-500
                  text-white text-center
                  font-bold
                  rounded
                  border-2
                "
              >
                <Link :href="'/overview'">Nu lezen</Link>
              </div>
            </div>
          </div>
        </div>

        <div class="flex-initial w-128 p-2">
          <div
            class="
              grid grid-cols-2
              gap-1
              border-lime-500
              bg-gray-50
              border-2
              rounded
              shadow-lg
            "
          >
            <div class="p-2 opacity-50">
              <img src="././images/old-dictionary.jpg" class="" />
            </div>
            <div
              class="
                inline-block
                text-center text-lime-500
                font-bold
                align-middle
                grid
                place-items-center
              "
            >
              <div class="md:text-xl">REPETITIO</div>
              <div>Efficiënt vocabularium oefenen</div>
              <div
                class="
                  p-4
                  m-2
                  bg-lime-500
                  text-white text-center
                  font-bold
                  rounded
                  border-2
                "
              >
                <Link :href="'/voc/repetitio/step/1'">Nu oefenen</Link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        class="
          flex flex-row
          justify-center
          text-center
          bg-white
          mx-auto
          mt-4
          mb-4
          pt-4
          pb-4
        "
      >
        <div class="basis-1/3 p-2 border-r-4 border-lime-300 text-pink-500 font-bold p-4 m-4">
          <div class="text-4xl">18</div>
          <div>klassieke auteurs</div>
          <div class="p-2 text-center">
            <img src="././images/greek.png" class="h-24 mx-auto" />
          </div>
        </div>
        <div class="basis-1/3 p-2 border-r-4 border-lime-300 text-pink-500 font-bold p-4 m-4">
          <div class="text-4xl">48</div>
          <div>Latijnse teksten</div>
          <div class="p-2 text-center">
            <img src="././images/poem.png" class="h-24 mx-auto" />
          </div>
        </div>
        <div class="basis-1/3 p-2 text-pink-500 font-bold p-4 m-4">
          <div class="text-4xl">1364</div>
          <div>Latijnse woorden</div>
          <div class="p-2 text-center">
            <img src="././images/book.png" class="h-24 mx-auto" />
          </div>
        </div>
      </div>

      <div class="flex justify-center p-4">

          <div
            class="
              border-pink-500
              bg-gray-50
              border-2
              rounded
              shadow-lg
              text-center text-pink-500
              font-bold
              p-2
            "
          >
            Zelf leerkracht Latijn? Wil jij op deze manier ook graag teksten aan
            leerlingen aanbieden?
          </div>
      </div>
      <div class="flex justify-center p-4">
          <div class="mt-2">
            <p>We werken er hard aan om dit mogelijk te maken.</p> <p>Stuur een mailtje
            met je gegevens naar pascal_pieters@yahoo.com en we houden je zeker
            op de hoogte indien deze functie beschikbaar wordt.</p>
          </div>

      </div>
    </div>
    <!-- end of layout for medium screens and up -->
  </div>
</template>




