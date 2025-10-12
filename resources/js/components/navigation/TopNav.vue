<template>
  <div class="flex justify-between h-16">
    <div class="flex">
      <div class="flex-shrink-0 flex items-center">
        <h1 class="text-xl font-bold text-gray-800">FinTrack</h1>
      </div>
      <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
        <Link :href="'/' " class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
          Dashboard
        </Link>
        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
          Expenses
        </a>
        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
          Analysis
        </a>
      </div>
    </div>
    <div class="flex items-center">
      <ProfileDropdown />
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import ProfileDropdown from './ProfileDropdown.vue';
</script>