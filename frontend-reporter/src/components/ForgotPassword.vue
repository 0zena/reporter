<template>

  <div id="container" class="flex justify-center items-center h-screen bg-black px-4">
    <div id="card" class="p-6 max-w-md w-full shadow-lg rounded-md bg-zinc-800">
      <h2 class="text-center text-2xl mb-4 text-white">Forgot Password? Make a new account!</h2>

      <form @submit.prevent="requestPasswordReset">
        <Button label="Ok" class="w-full" type="submit" />
      </form>

      <div class="text-center mt-4"> 
        <Button label="Log In" outlined class="border-green-600 w-full" @click="goToLogin" /> 
      </div>

      <p v-if="message" class="text-green-500 text-center mt-4">{{ message }}</p>
      <p v-if="errorMessage" class="text-red-500 text-center mt-4">{{ errorMessage }}</p>

    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

const email = ref('');
const message = ref('');
const errorMessage = ref('');
const router = useRouter();

const requestPasswordReset = async () => {
  router.push('/register');
};

const goToLogin = () => {
  router.push('/login'); 
}
</script>
