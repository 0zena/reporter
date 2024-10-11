<script setup lang="ts">
import { ref, provide } from 'vue';
import { RouterLink, RouterView } from 'vue-router';
import Toast from 'primevue/toast';

// Global authentication state
const isAuthenticated = ref(false); // Initially false, meaning the user is logged out

provide('isAuthenticated', isAuthenticated);
provide('setAuthenticated', (value: boolean) => {
  isAuthenticated.value = value;
});

</script>

<template>
  <Toast />
  <RouterView />
</template>

<style scoped>

</style>
