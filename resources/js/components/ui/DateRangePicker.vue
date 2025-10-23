<template>
  <div class="flex items-center space-x-4">
    <div class="flex items-center space-x-2">
      <label for="startDate" class="text-sm font-medium text-gray-700">From:</label>
      <input
        id="startDate"
        v-model="localStartDate"
        type="date"
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      />
    </div>
    <div class="flex items-center space-x-2">
      <label for="endDate" class="text-sm font-medium text-gray-700">To:</label>
      <input
        id="endDate"
        v-model="localEndDate"
        type="date"
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      />
    </div>
    <button
      @click="applyFilter"
      class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Apply Filter
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps<{
  startDate: string;
  endDate: string;
}>();

const emit = defineEmits<{
  'date-change': [startDate: string, endDate: string];
}>();

const localStartDate = ref(props.startDate);
const localEndDate = ref(props.endDate);

const applyFilter = () => {
  emit('date-change', localStartDate.value, localEndDate.value);
};

// Watch for external changes
watch(() => props.startDate, (newVal) => {
  localStartDate.value = newVal;
});

watch(() => props.endDate, (newVal) => {
  localEndDate.value = newVal;
});
</script>

