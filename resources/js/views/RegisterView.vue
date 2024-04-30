<script setup lang="ts">
import { ref } from 'vue';
import { postRequest, REGISTER_API } from '../api';
import LoadingEffect from '../components/effect/LoadingEffect.vue';

const name = ref<string>();
const email = ref<string>();
const password = ref<string>();
const passwordConfirmation = ref<string>();
const loading = ref<boolean>(false);
const errors = ref<string[]>([]);
const success = ref<boolean>(false);

const handleRegister = async () => {
    loading.value = true;
    errors.value = [];

    await postRequest(REGISTER_API, {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value,
    }).then((resp) => {
        success.value = true;
    }).catch((err) => {
        const errorMessages = err.response?.data?.errors;
        console.log(errorMessages);

        errors.value = Object.keys(errorMessages).reduce((acc, current) => {
            return [...acc, ...errorMessages[current]]
        }, []);

    }).finally(() => {
        console.log('finally');
        loading.value = false;
    });
};

</script>

<template>
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-80">
            <h2 class="text-2xl font-semibold mb-4 text-center">Register</h2>

            <div v-show="errors.length" class="text-center text-red">
                <p v-for="(error, index) in errors" :key="index">{{ error }}</p>
            </div>

            <div v-if="success" class="my-10 text-center">
                <p class="text-sm">Registration successfuly, go to <RouterLink to="/login"
                        class="text-blue-500 hover:text-blue-800">Login</RouterLink>
                </p>
            </div>

            <LoadingEffect :loading="loading" />

            <form v-show="!success" @submit.prevent="handleRegister">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input
                        class="shadow appearance-none border border-zinc-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="name" v-model="name" id="name" type="text" placeholder="Name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input
                        class="shadow appearance-none border border-zinc-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="email" v-model="email" id="email" type="email" placeholder="Email Address" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input
                        class="shadow appearance-none border border-zinc-300 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" name="password" v-model="password" type="password" placeholder="Password"
                        required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm-password">
                        Confirm Password
                    </label>
                    <input
                        class="shadow appearance-none border border-zinc-300 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="passwordConfirmation" name="password_confirmation" v-model="passwordConfirmation"
                        type="password" placeholder="Confirm Password" required>
                </div>
                <div class="flex items-center justify-center">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit" :disabled="loading">
                        Register
                    </button>

                </div>

                <div class="mt-4 text-center">
                    <p class="text-sm">Already have an account? <RouterLink to="/login"
                            class="text-blue-500 hover:text-blue-800">Login</RouterLink>
                    </p>
                </div>
            </form>
        </div>
    </div>

</template>