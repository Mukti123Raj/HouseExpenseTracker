<template>
  <div class="relative">
    <button @click="isOpen = !isOpen" class="flex items-center space-x-2 text-sm focus:outline-none">
      <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white">
        {{ user?.name?.charAt(0) || 'U' }}
      </div>
      <span class="hidden md:inline-block">{{ user?.name }}</span>
      <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
      </svg>
    </button>

    <div v-if="isOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
      <div class="px-4 py-2 border-b">
        <p class="text-sm font-medium text-gray-900">{{ user?.name }}</p>
        <p v-if="user?.household" class="text-xs text-gray-500">Household: {{ user.household.household_code }}</p>
      </div>
      <Link :href="route('logout')" method="post" as="button" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Logout
      </Link>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const isOpen = ref(false);
const user = usePage().props.auth?.user;
</script>