import { ref } from 'vue';

interface Toast {
  message: string;
  type: 'success' | 'error' | 'info' | 'warning';
  id: number;
}

// Create a single instance that can be imported across components
const toasts = ref<Toast[]>([]);
let nextId = 0;

export function useToast() {
  const toast = (message: string, type: 'success' | 'error' | 'info' | 'warning' = 'info') => {
    const id = nextId++;
    toasts.value.push({ message, type, id });
    
    // Auto remove after 3 seconds
    setTimeout(() => {
      removeToast(id);
    }, 3000);
  };

  const removeToast = (id: number) => {
    const index = toasts.value.findIndex(t => t.id === id);
    if (index !== -1) {
      toasts.value.splice(index, 1);
    }
  };

  return {
    toasts,
    toast,
    removeToast
  };
}