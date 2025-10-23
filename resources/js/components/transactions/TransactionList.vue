<template>
  <div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-gray-200">
      <li v-for="transaction in transactions" :key="transaction.id" class="px-6 py-4">
        <div class="flex items-center justify-between">
          <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-900 truncate">
                  {{ formatCurrency(transaction.amount) }}
                </p>
                <p class="text-sm text-gray-500">
                  {{ transaction.source || transaction.category }}
                </p>
                <p v-if="transaction.description" class="text-sm text-gray-500 mt-1">
                  {{ transaction.description }}
                </p>
              </div>
              <div class="flex flex-col items-end">
                <p class="text-sm text-gray-500">
                  {{ formatDate(transaction.income_date || transaction.expense_date) }}
                </p>
                <p class="text-xs text-gray-400">
                  By {{ transaction.user?.name || 'Unknown' }}
                </p>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-1"
                      :class="transaction.income_date ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                  {{ transaction.income_date ? 'Income' : 'Expense' }}
                </span>
              </div>
            </div>
          </div>
          <div class="ml-4 flex-shrink-0 flex space-x-2">
            <button
              @click="$emit('edit', transaction)"
              class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Edit
            </button>
            <button
              @click="$emit('delete', transaction)"
              class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            >
              Delete
            </button>
          </div>
        </div>
      </li>
    </ul>
    <div v-if="transactions.length === 0" class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">No {{ type }} transactions</h3>
      <p class="mt-1 text-sm text-gray-500">Get started by adding a new {{ type }} transaction.</p>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  transactions: any[];
  type: 'income' | 'expense';
}>();

defineEmits<{
  edit: [transaction: any];
  delete: [transaction: any];
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
