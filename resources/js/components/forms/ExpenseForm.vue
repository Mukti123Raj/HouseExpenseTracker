<template>
  <form @submit.prevent="submit">
    <InputField
      v-model="form.amount"
      label="Amount"
      type="number"
      step="0.01"
      required
      :error="form.errors.amount"
    />
    
    <InputField
      v-model="form.category"
      label="Category"
      required
      :error="form.errors.category"
    />
    
    <InputField
      v-model="form.description"
      label="Description"
      type="textarea"
      :error="form.errors.description"
    />
    
    <InputField
      v-model="form.expense_date"
      label="Date"
      type="date"
      required
      :error="form.errors.expense_date"
    />
    
    <div class="flex justify-end">
      <button
        type="submit"
        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
        :disabled="form.processing"
      >
        {{ form.processing ? 'Saving...' : (isEditing ? 'Update Expense' : 'Save Expense') }}
      </button>
    </div>
  </form>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputField from '@/components/ui/InputField.vue';

const props = defineProps<{
  initialData?: any;
}>();

const emit = defineEmits(['close', 'success']);

const isEditing = computed(() => !!props.initialData);

const form = useForm({
  amount: props.initialData?.amount || '',
  category: props.initialData?.category || '',
  description: props.initialData?.description || '',
  expense_date: props.initialData?.expense_date || new Date().toISOString().slice(0, 10)
});

const submit = () => {
  if (isEditing.value) {
    form.put(route('expense.update', props.initialData.id), {
      onSuccess: () => {
        emit('success');
        emit('close');
      }
    });
  } else {
    form.post(route('expense.store'), {
      onSuccess: () => {
        emit('success');
        emit('close');
      }
    });
  }
};
</script>