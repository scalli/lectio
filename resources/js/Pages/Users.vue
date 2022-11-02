<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Menu from "@/Pages/Menu.vue";

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  users: Object,
});

const users = reactive(props.users);

const username = ref("");
const email = ref("");
const password = ref("");

function createNewUser() {
  Inertia.post("/users/new", {
    username: username.value,
    email: email.value,
    password: password.value,
  });

  username.value="";
  email.value="";
  password.value="";
}
</script>

<template>
  <Head title="Gebruikers" />

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
        <Menu> </Menu>
      </template>
    </div>

    <div>
      {{ props.users }}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
      <div
        v-for="user in props.users"
        :id="user.id"
        :key="user.id"
        class="ml-4 mr-4 text-gray-700 font-bold"
      >
        <div
          class="
            border-lime-500
            mb-2
            pl-2
            text-lg text-gray-700
            border-2
            bg-gray-50
            font-bold
            rounded
          "
        >
          <div class="text-pink-500">
            {{ user.name }}
          </div>
        </div>
      </div>
    </div>

    <!-- Fields for textinfo -->
    <div>
      <div class="grid grid-cols-9 gap-4 mb-2 pl-2 mr-2">
        <label class="pr-1 col-span-1" for="method">Naam:</label>
        <input
          class="col-span-2 border-solid border-2 rounded border-black"
          v-model="username"
          name="username"
        />

        <label class="pr-1 col-span-1" for="chapter">E-mail:</label>
        <input
          class="col-span-2 border-solid border-2 rounded border-black"
          v-model="email"
          name="email"
        />

        <label class="pr-1 col-span-1" for="grade">Wachtwoord:</label>
        <input
          class="col-span-2 border-solid border-2 rounded border-black"
          v-model="password"
          name="password"
        />
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
          @click="createNewUser($event)"
        >
          Opslaan
        </button>
      </div>
    </div>
  </div>
</template>