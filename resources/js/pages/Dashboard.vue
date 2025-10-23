<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Monthly Summary Section -->
      <div>
        <h2 class="text-lg font-medium text-gray-900">Monthly Summary</h2>
        <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-3">
          <SummaryCard title="Total Income" :value="monthlySummary.totalIncome" />
          <SummaryCard title="Total Expenses" :value="monthlySummary.totalExpenses" valueColor="text-red-600" />
          <SummaryCard 
            title="Remaining Balance" 
            :value="monthlySummary.remainingBalance" 
            :valueColor="monthlySummary.remainingBalance >= 0 ? 'text-green-600' : 'text-red-600'" 
          />
        </div>
      </div>

      <!-- Actions Section -->
      <div>
        <h2 class="text-lg font-medium text-gray-900">Quick Actions</h2>
        <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2">
          <ActionButton 
            buttonText="Add Income" 
            buttonColor="bg-green-600 hover:bg-green-700 focus:ring-green-500" 
            :latestTransaction="latestIncome"
            @click="showIncomeModal = true"
          />
          <ActionButton 
            buttonText="Create Expense" 
            buttonColor="bg-red-600 hover:bg-red-700 focus:ring-red-500" 
            :latestTransaction="latestExpense"
            @click="showExpenseModal = true"
          />
        </div>
      </div>
    </div>

    <!-- Income Modal -->
    <Modal :show="showIncomeModal" title="Add New Income" @close="showIncomeModal = false">
      <IncomeForm @success="onIncomeAdded" />
    </Modal>

    <!-- Expense Modal -->
    <Modal :show="showExpenseModal" title="Create New Expense" @close="showExpenseModal = false">
      <ExpenseForm @success="onExpenseAdded" />
    </Modal>
  </AppLayout>
</template>

<script setup lang="ts">
import { defineProps, ref, watch } from 'vue';
import { useToast } from '@/composables/useToast';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SummaryCard from '@/components/dashboard/SummaryCard.vue';
import ActionButton from '@/components/dashboard/ActionButton.vue';
import Modal from '@/components/ui/Modal.vue';
import IncomeForm from '@/components/forms/IncomeForm.vue';
import ExpenseForm from '@/components/forms/ExpenseForm.vue';

defineProps<{
  monthlySummary: {
    totalIncome: number;
    totalExpenses: number;
    remainingBalance: number;
  };
  latestIncome: any | null;
  latestExpense: any | null;
}>();

const showIncomeModal = ref(false);
const showExpenseModal = ref(false);
const { toast } = useToast();

// Debug: Log modal state changes
watch(showIncomeModal, (newVal) => {
  console.log('Income modal state:', newVal);
});

watch(showExpenseModal, (newVal) => {
  console.log('Expense modal state:', newVal);
});

function onIncomeAdded() {
  showIncomeModal.value = false;
  toast('Income added successfully!', 'success');
  // Reload the dashboard to get updated data
  router.reload();
}

function onExpenseAdded() {
  showExpenseModal.value = false;
  toast('Expense added successfully!', 'success');
  // Reload the dashboard to get updated data
  router.reload();
}
</script>