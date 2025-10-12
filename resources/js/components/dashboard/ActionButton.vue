<template>
  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <button :class="['w-full py-2 px-4 rounded-md text-white font-medium focus:outline-none focus:ring-2 focus:ring-offset-2', buttonColor || 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500']">
        {{ buttonText }}
      </button>
      
      <div class="mt-4" v-if="latestTransaction">
        <h4 class="text-sm font-medium text-gray-500">Latest Transaction</h4>
        <div class="mt-2 text-sm text-gray-900">
          <p><span class="font-medium">Amount:</span> {{ formatCurrency(latestTransaction.amount) }}</p>
          <p><span class="font-medium">Date:</span> {{ formatDate(latestTransaction.income_date || latestTransaction.expense_date) }}</p>
          <p><span class="font-medium">By:</span> {{ latestTransaction.user?.name }}</p>
          <p v-if="latestTransaction.source"><span class="font-medium">Source:</span> {{ latestTransaction.source }}</p>
          <p v-if="latestTransaction.category"><span class="font-medium">Category:</span> {{ latestTransaction.category }}</p>
          <p v-if="latestTransaction.description"><span class="font-medium">Description:</span> {{ latestTransaction.description }}</p>
        </div>
      </div>
      <div class="mt-4 text-sm text-gray-500" v-else>
        No transactions yet
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  buttonText: string;
  buttonColor?: string;
  latestTransaction: any | null;
}>();

function formatCurrency(value: number): string {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD'
  }).format(value);
}

function formatDate(dateString: string): string {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
}
</script>