<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Desktop Navigation -->
    <header class="bg-white shadow hidden md:block">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <TopNav />
      </div>
    </header>

    <!-- Main Content -->
    <main>
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot />
      </div>
    </main>

    <!-- Mobile Navigation -->
    <footer class="fixed bottom-0 left-0 right-0 bg-white shadow md:hidden">
      <BottomNav />
    </footer>
  </div>
</template>

<script setup lang="ts">
import TopNav from '@/components/navigation/TopNav.vue';
import BottomNav from '@/components/navigation/BottomNav.vue';
</script>