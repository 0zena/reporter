<script setup lang="ts">
import { ref, provide } from 'vue';
import { RouterLink, RouterView } from 'vue-router';

// Global authentication state
const isAuthenticated = ref(false); // Initially false, meaning the user is logged out

// Provide the state and a method to update it
provide('isAuthenticated', isAuthenticated);
provide('setAuthenticated', (value: boolean) => {
  isAuthenticated.value = value;
});

</script>

<template>
  <RouterView />
</template>

<style scoped>

</style>
