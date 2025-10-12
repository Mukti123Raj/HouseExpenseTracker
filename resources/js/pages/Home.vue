<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-xl font-bold text-gray-800">House Expense Manager</h1>
            </div>
          </div>
          <div class="flex items-center">
            <button @click="logout" class="ml-4 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <div class="py-10">
      <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold leading-tight text-gray-900">
            Home Page for {{ user.role.name }}
          </h1>
        </div>
      </header>
      <main>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <div class="space-y-4">
                <div>
                  <h3 class="text-lg font-medium text-gray-900">User Information</h3>
                  <dl class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                      <dt class="text-sm font-medium text-gray-500">Name</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ user.name }}</dd>
                    </div>
                    <div>
                      <dt class="text-sm font-medium text-gray-500">Email</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ user.email }}</dd>
                    </div>
                  </dl>
                </div>

                <div>
                  <h3 class="text-lg font-medium text-gray-900">Household Information</h3>
                  <dl class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                      <dt class="text-sm font-medium text-gray-500">Household Name</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ user.household.name }}</dd>
                    </div>
                    <div>
                      <dt class="text-sm font-medium text-gray-500">Household Code</dt>
                      <dd class="mt-1 text-sm text-gray-900">{{ user.household.household_code }}</dd>
                    </div>
                  </dl>
                </div>

                <div v-if="user.role.name === 'Admin'" class="bg-gray-50 p-4 rounded-md">
                  <h3 class="text-lg font-medium text-gray-900">Admin Actions</h3>
                  <p class="mt-1 text-sm text-gray-500">
                    Share this household code with family members: <span class="font-bold">{{ user.household.household_code }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'

const props = defineProps<{
  user: {
    name: string
    email: string
    role: {
      name: string
    }
    household: {
      name: string
      household_code: string
    }
  }
}>()

const { user } = props;

const logout = async () => {
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    try {
      await fetch('/logout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken
      }
    })
    router.visit('/login')
  } catch (e) {
    console.error('Logout failed:', e)
  }
}
</script>
