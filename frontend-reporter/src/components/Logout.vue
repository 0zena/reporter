<template>
  <div>
    <Button label="Logout" class="p-button-danger" @click="logout" />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Button from 'primevue/button';

const router = useRouter();
const errorMessage = ref('');

const logout = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/logout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (response.ok) {
      router.push('/login');
    } else {
      errorMessage.value = 'Logout failed. Please try again.';
    }
  } catch (error) {
    errorMessage.value = 'An error occurred. Please try again later.';
  }
};
</script>
