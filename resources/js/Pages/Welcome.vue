<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    phrases: Array,
    questions: Array,
    voc: Array
});
</script>

<template>
    <Head title="Welcome" />

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

        <div class="pt-2 pb-2 pl-2 pr-2 bg-white pt-2 pb-2 pl-2 pr-2 ml-2 mr-2  md:w-1/2 lg:w-1/3 md:mx-auto">
            <div class=" inline-block pr-2" v-for="phrase in phrases">{{phrase}}</div>
        </div>

        <div class="ml-2 mr-2 md:w-3/4 lg:w-1/3 md:mx-auto">
            <div class="mt-4 pt-2 pb-2 pl-2 pr-2 bg-white">
                  <p>Over welke stad gaat het in de tekst?</p>
            </div>
        </div>

        <div class="ml-2 mr-2 md:w-3/4 lg:w-1/3 md:mx-auto">
            <div class="mt-4 pt-2 pb-2 pl-2 pr-2 bg-white">
                    <p>Troia, Troiae: Troje</p>
                    <p>urbs, urbis: de stad</p>
            </div> 
        </div>
    
    </div>

</template>


