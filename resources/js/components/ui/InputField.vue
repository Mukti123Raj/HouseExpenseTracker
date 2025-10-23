<template>
  <div class="mb-4">
    <label :for="id" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }} {{ required ? '*' : '' }}
    </label>
    <input
      v-if="type !== 'textarea'"
      :id="id"
      :type="type"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      :class="{ 'border-red-500': error }"
      :required="required"
    />
    <textarea
      v-else
      :id="id"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      :class="{ 'border-red-500': error }"
      :required="required"
      rows="3"
    ></textarea>
    <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: ''
  },
  label: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: 'text'
  },
  error: {
    type: String,
    default: ''
  },
  required: {
    type: Boolean,
    default: false
  },
  id: {
    type: String,
    default: ''
  }
});

defineEmits(['update:modelValue']);

const id = computed(() => props.id || `input-${props.label.toLowerCase().replace(/\s+/g, '-')}`);
</script>