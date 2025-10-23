<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Page Header -->
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Income & Expenses
          </h2>
        </div>
      </div>

      <!-- View Toggle -->
      <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg w-fit">
        <button
          @click="currentView = 'income'"
          :class="[
            'px-4 py-2 text-sm font-medium rounded-md transition-colors',
            currentView === 'income' 
              ? 'bg-white text-gray-900 shadow-sm' 
              : 'text-gray-500 hover:text-gray-700'
          ]"
        >
          Income
        </button>
        <button
          @click="currentView = 'expense'"
          :class="[
            'px-4 py-2 text-sm font-medium rounded-md transition-colors',
            currentView === 'expense' 
              ? 'bg-white text-gray-900 shadow-sm' 
              : 'text-gray-500 hover:text-gray-700'
          ]"
        >
          Expenses
        </button>
      </div>

      <!-- Date Range Picker -->
      <div class="bg-white p-4 rounded-lg shadow">
        <DateRangePicker
          :start-date="dateRange.start"
          :end-date="dateRange.end"
          @date-change="handleDateChange"
        />
      </div>

      <!-- Transaction Lists -->
      <div v-if="currentView === 'income'">
        <TransactionList
          :transactions="incomes"
          type="income"
          @edit="handleEdit"
          @delete="handleDelete"
        />
      </div>

      <div v-if="currentView === 'expense'">
        <TransactionList
          :transactions="expenses"
          type="expense"
          @edit="handleEdit"
          @delete="handleDelete"
        />
      </div>
    </div>

    <!-- Edit Modal -->
    <Modal :show="showEditModal" :title="`Edit ${editingType === 'income' ? 'Income' : 'Expense'}`" @close="closeEditModal">
      <IncomeForm
        v-if="editingType === 'income'"
        :initial-data="editingTransaction"
        @success="handleEditSuccess"
        @close="closeEditModal"
      />
      <ExpenseForm
        v-if="editingType === 'expense'"
        :initial-data="editingTransaction"
        @success="handleEditSuccess"
        @close="closeEditModal"
      />
    </Modal>

    <!-- Delete Confirmation Dialog -->
    <ConfirmDialog
      :show="showDeleteConfirm"
      :title="`Delete ${deletingType === 'income' ? 'Income' : 'Expense'}`"
      :message="`Are you sure you want to delete this ${deletingType} transaction? This action cannot be undone.`"
      confirm-text="Delete"
      @confirm="handleDeleteConfirm"
      @cancel="closeDeleteConfirm"
    />
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, reactive, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from '@/composables/useToast';
import AppLayout from '@/Layouts/AppLayout.vue';
import DateRangePicker from '@/components/ui/DateRangePicker.vue';
import TransactionList from '@/components/transactions/TransactionList.vue';
import Modal from '@/components/ui/Modal.vue';
import ConfirmDialog from '@/components/ui/ConfirmDialog.vue';
import IncomeForm from '@/components/forms/IncomeForm.vue';
import ExpenseForm from '@/components/forms/ExpenseForm.vue';

const props = defineProps<{
  incomes: any[];
  expenses: any[];
  initialStartDate: string;
  initialEndDate: string;
}>();

const { toast } = useToast();

// State
const currentView = ref<'income' | 'expense'>('expense');
const dateRange = reactive({
  start: props.initialStartDate,
  end: props.initialEndDate
});

// Edit modal state
const showEditModal = ref(false);
const editingTransaction = ref(null);
const editingType = ref<'income' | 'expense'>('income');

// Delete confirmation state
const showDeleteConfirm = ref(false);
const deletingTransaction = ref(null);
const deletingType = ref<'income' | 'expense'>('income');

// Watch for date range changes
watch([() => dateRange.start, () => dateRange.end], () => {
  refetchData();
});

// Watch for view changes
watch(currentView, () => {
  // Optional: You might want to refetch data when switching views
});

function handleDateChange(startDate: string, endDate: string) {
  dateRange.start = startDate;
  dateRange.end = endDate;
}

function refetchData() {
  router.get(route('transactions.index'), {
    startDate: dateRange.start,
    endDate: dateRange.end
  }, {
    preserveState: true,
    replace: true
  });
}

function handleEdit(transaction: any) {
  editingTransaction.value = transaction;
  editingType.value = transaction.income_date ? 'income' : 'expense';
  showEditModal.value = true;
}

function handleDelete(transaction: any) {
  deletingTransaction.value = transaction;
  deletingType.value = transaction.income_date ? 'income' : 'expense';
  showDeleteConfirm.value = true;
}

function closeEditModal() {
  showEditModal.value = false;
  editingTransaction.value = null;
  editingType.value = 'income';
}

function closeDeleteConfirm() {
  showDeleteConfirm.value = false;
  deletingTransaction.value = null;
  deletingType.value = 'income';
}

function handleEditSuccess() {
  closeEditModal();
  toast('Transaction updated successfully!', 'success');
  refetchData();
}

function handleDeleteConfirm() {
  if (!deletingTransaction.value) return;

  const routeName = deletingType.value === 'income' ? 'income.destroy' : 'expense.destroy';
  const routeParams = { [deletingType.value]: deletingTransaction.value.id };

  router.delete(route(routeName, routeParams), {
    preserveState: true,
    onSuccess: () => {
      toast(`${deletingType.value === 'income' ? 'Income' : 'Expense'} deleted successfully!`, 'success');
      closeDeleteConfirm();
    },
    onError: () => {
      toast('Failed to delete transaction', 'error');
    }
  });
}
</script>
