<template>
  <div class="fixed top-4 right-4 z-50 space-y-2">
    <div 
      v-for="toast in toasts" 
      :key="toast.id"
      :class="[
        'px-4 py-3 rounded-lg shadow-md transition-all duration-300 transform translate-x-0',
        getToastClass(toast.type)
      ]"
    >
      <div class="flex items-center">
        <span class="mr-2">
          <svg v-if="toast.type === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <svg v-else-if="toast.type === 'error'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
          <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </span>
        <span>{{ toast.message }}</span>
        <button 
          @click="removeToast(toast.id)" 
          class="ml-auto text-gray-700 hover:text-gray-900 focus:outline-none"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useToast } from '@/composables/useToast';

const { toasts, removeToast } = useToast();

function getToastClass(type: string) {
  switch (type) {
    case 'success':
      return 'bg-green-100 text-green-800 border-l-4 border-green-500';
    case 'error':
      return 'bg-red-100 text-red-800 border-l-4 border-red-500';
    case 'warning':
      return 'bg-yellow-100 text-yellow-800 border-l-4 border-yellow-500';
    default:
      return 'bg-blue-100 text-blue-800 border-l-4 border-blue-500';
  }
}
</script>