<script setup lang="ts">
import { ref } from 'vue';
import { LOGIN_API, postRequest } from '../api';
import router from '../router';
import axios from 'axios';
import LoadingEffect from '@/components/effect/LoadingEffect.vue';

const email = ref('')
const password = ref('')
const loading = ref(false);
const error = ref('');

const handleLogin = async () => {
    loading.value = true;

    try {
        const response = await axios.post(LOGIN_API, {
            email: email.value,
            password: password.value
        });

        if (response.status === 200) {
            console.log('Login successful');
            // router.push('/');
            location.reload();
        } else {
            console.error('Login failed:', response.data);
        }
    } catch (err) {
        error.value = err.response?.data?.message;
        console.error('Login error:', error);
    } finally {
        loading.value = false;
    }
}

</script>

<template>
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-80">
            <h2 class="text-2xl font-semibold mb-4 text-center">Login</h2>

            <LoadingEffect :loading="loading" />

            <div v-show="error" class="text-center text-red">
                <p>{{ error }}</p>
            </div>

            <form @submit.prevent="handleLogin">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input
                        class="shadow appearance-none border-2 border-gray rounded border-gray-50 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="Email Address" v-model="email">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input
                        class="shadow appearance-none border-2 border-gray rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" type="password" placeholder="Password" v-model="password">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit" :disabled="loading">
                        Sign In
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                        Forgot Password?
                    </a>
                </div>
            </form>
            <div class="mt-4 text-center">
                <p class="text-sm">Don't have an account? <RouterLink to="/register"
                        class="text-blue-500 hover:text-blue-800">Register</RouterLink>
                </p>
            </div>
        </div>
    </div>

</template>