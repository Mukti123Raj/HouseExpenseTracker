<template>
    <div
        class="flex min-h-screen flex-col justify-center bg-gray-100 py-12 sm:px-6 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white px-4 py-8 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" @submit.prevent="register">
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700"
                            >Name</label
                        >
                        <div class="mt-1">
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm"
                            />
                        </div>
                    </div>

                    <div v-if="errors.name" class="text-sm text-red-600">
                        {{ errors.name[0] }}
                    </div>

                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                            >Email address</label
                        >
                        <div class="mt-1">
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm"
                            />
                        </div>
                    </div>
                    <div v-if="errors.email" class="text-sm text-red-600">
                        {{ errors.email[0] }}
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                            >Password</label
                        >
                        <div class="mt-1">
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm"
                            />
                        </div>
                    </div>
                    <div v-if="errors.password" class="text-sm text-red-600">
                        {{ errors.password[0] }}
                    </div>

                    <div>
                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-gray-700"
                            >Confirm Password</label
                        >
                        <div class="mt-1">
                            <input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm"
                            />
                        </div>
                    </div>
                    <div v-if="errors.password_confirmation" class="text-sm text-red-600">
                        {{ errors.password_confirmation[0] }}
                    </div>

                    <div>
                        <label
                            for="household_code"
                            class="block text-sm font-medium text-gray-700"
                            >Household Code (Optional)</label
                        >
                        <div class="mt-1">
                            <input
                                id="household_code"
                                v-model="form.household_code"
                                type="text"
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm"
                                placeholder="Leave empty to create new household"
                            />
                        </div>
                    </div>
                    <div v-if="errors.household_code" class="text-sm text-red-600">
                        {{ errors.household_code[0] }}
                    </div>

                    <div v-if="generalError" class="text-sm text-red-600">
                        {{ generalError }}
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                        >
                            Register
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-white px-2 text-gray-500">
                                Already have an account?
                                <Link
                                    href="/login"
                                    class="font-medium text-indigo-600 hover:text-indigo-500"
                                >
                                    Sign in
                                </Link>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    household_code: '',
});

const errors = ref<{ [key: string]: string[] }>({});
const generalError = ref('');

const register = async () => {
    errors.value = {}; // Clear previous errors
    generalError.value = ''; // Clear previous general error

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    try {
        const response = await fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(form),
        });

        const data = await response.json();

        if (response.ok) {
            router.visit('/');
        } else {
            if (response.status === 422 && data.errors) {
                errors.value = data.errors;
            } else {
                generalError.value = data.message || 'An unknown error occurred';
            }
        }
    } catch {
        generalError.value = 'An error occurred during registration';
    }
};
</script>