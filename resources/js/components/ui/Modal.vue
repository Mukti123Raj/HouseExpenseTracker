<template>
  <div v-if="show" class="fixed inset-0 z-[9999] overflow-y-auto" style="z-index: 9999;">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <!-- Backdrop -->
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="$emit('close')"></div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      
      <!-- Modal panel -->
      <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" @click.stop>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                {{ title }}
              </h3>
              <div class="mt-2">
                <slot></slot>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <slot name="footer"></slot>
          <button 
            type="button" 
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
            @click="$emit('close')"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps({
  show: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    required: true
  }
});

defineEmits(['close']);
</script>