<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";
import AppLayout from '@/Layouts/AppLayout.vue';
import Menu from '@/Pages/Menu.vue';

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>
<template>
  <div class="flex flex-wrap py-2">
    <div class="w-full px-4">
      <nav
        class="
          relative
          flex flex-wrap
          items-center
          justify-between
          px-2
          py-3
          bg-pink-500
          rounded
        "
      >
        <div
          class="
            container
            px-4
            mx-auto
            flex flex-wrap
            items-center
            justify-between
          "
        >
          <div
            class="
              w-full
              relative
              flex
              justify-between
              lg:w-auto
              px-4
              lg:static lg:block lg:justify-start
            "
          >
            <div
              class="
                text-xl
                font-bold
                leading-relaxed
                inline-block
                mr-4
                py-2
                whitespace-nowrap
                uppercase
                text-white
              "
            >
            <Link href="/">
              <div class="grid grid-cols-2 gap-2 content-center ">
                <div><img src="././images/lectio-logo-lime.png" class="h-24 mx-auto" /></div>
                <div class="grid place-items-center">LATIJNLEZERS</div>
              </div>
            </Link>
            </div>
            <button
              class="
                text-white
                cursor-pointer
                text-xl
                leading-none
                px-3
                py-1
                border border-solid border-transparent
                rounded
                bg-transparent
                block
                lg:hidden
                outline-none
                focus:outline-none
              "
              type="button"
              v-on:click="toggleNavbar()"
            >
              <i class="fas fa-bars"></i>
            </button>
          </div>
          <div
            v-bind:class="{ hidden: !menuShow, flex: menuShow }"
            class="lg:flex lg:flex-grow items-center"
          >
            <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
              <li class="nav-item">
                
                  <Link class="
                    px-3
                    py-2
                    flex
                    items-center
                    text-xs
                    uppercase
                    font-bold
                    leading-snug
                    text-white
                    hover:opacity-75
                  " :href="'/overview'">LECTIO</Link>
                
              </li>
              <li class="nav-item">
                
                  <Link class="
                    px-3
                    py-2
                    flex
                    items-center
                    text-xs
                    uppercase
                    font-bold
                    leading-snug
                    text-white
                    hover:opacity-75
                  " :href="'/voc/repetitio/step/1'">REPETITIO</Link>
                
              </li>
              <li class="nav-item">
                <a
                  class="
                    px-3
                    py-2
                    flex
                    items-center
                    text-xs
                    uppercase
                    font-bold
                    leading-snug
                    text-white
                    hover:opacity-75
                  "
                  :href="'/'"
                >
                  Instellingen
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="
                    px-3
                    py-2
                    flex
                    items-center
                    text-xs
                    uppercase
                    font-bold
                    leading-snug
                    text-white
                    hover:opacity-75
                  "
                  :href="route('login')"
                >
                  Log in
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  name: "pink-menu",
  data() {
    return {
      menuShow: false,
    };
  },
  methods: {
    toggleNavbar: function () {
      this.menuShow = !this.menuShow;
    },
  },
};
</script>