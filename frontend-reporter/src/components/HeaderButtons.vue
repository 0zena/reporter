<template>
  <div class="fixed top-0 right-0 p-4">
    <div v-if="isAuthenticated">
      <!-- Show the logout button if the user is logged in -->
      <Button label="Logout" class="p-button-danger" @click="logout" />
    </div>
    <div v-else>
      <!-- Show login and register buttons if the user is not logged in -->
      <Button label="Login" class="p-button-info mr-2" @click="goToLogin" />
      <Button label="Register" class="p-button-success" @click="goToRegister" />
    </div>
  </div>
</template>
<script setup lang="ts">
import { inject, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Button from 'primevue/button';
const isAuthenticated = inject('isAuthenticated') as any;
const setAuthenticated = inject('setAuthenticated') as (value: boolean) => void;
const router = useRouter();
const logout = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/logout', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
    });
    if (response.ok) {
      setAuthenticated(false); // Set auth state to false on logout
      router.push('/login');
    }
  } catch (error) {
    console.error('Logout failed');
  }
};
// Check user session status on page load
onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/user', {
      credentials: 'include',
    });
    if (response.ok) {
      const data = await response.json();
      if (data.user) {
        setAuthenticated(true); // Set auth state to true if session exists
      } else {
        setAuthenticated(false);
      }
    }
  } catch (error) {
    setAuthenticated(false);
  }
});
const goToLogin = () => {
  router.push('/login');
};
const goToRegister = () => {
  router.push('/register');
};
</script>
