<template>
  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <dt class="text-sm font-medium text-gray-500 truncate">
        {{ title }}
      </dt>
      <dd :class="['mt-1 text-3xl font-semibold', valueColor || 'text-gray-900']">
        {{ formatCurrency(value) }}
      </dd>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string;
  value: number;
  valueColor?: string;
}>();

function formatCurrency(value: number): string {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD'
  }).format(value);
}
</script>