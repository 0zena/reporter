<template>
  <div class="fixed top-0 left-0 p-4"> 
    <Button icon="pi pi-arrow-left" @click="goToHomepage" />
  </div>
  <div id="container" class="flex justify-center items-center h-screen bg-black px-4">
    <div id="card" class="p-6 max-w-md w-full shadow-lg rounded-md bg-zinc-800">
      <h2 class="text-center text-2xl mb-7 text-white">Login</h2>

      <form @submit.prevent="login">
        <FloatLabel class="mb-7">
          <InputText v-model="email" id="email" type="email" class="w-full" required />
          <label for="email" class="block mb-2">Email</label>
        </FloatLabel>

        <FloatLabel class="mb-7">
          <Password v-model="password" toggleMask :feedback="false" id="password" class="w-full" required />
          <label for="password" class="block mb-2">Password</label>
        </FloatLabel>

        <Button label="Login" class="w-full" type="submit" />
      </form>

      <div class="flex justify-between mt-4">
        <Button label="Reset Password" outlined class="border-green-600 w-full mr-1" @click="goToForgotPassword" /> 
        <Button label="Sign Up" outlined class="border-green-600 w-full ml-1" @click="goToRegister" /> 
      </div>

      <p v-if="errorMessage" class="text-red-500 text-center mt-4">{{ errorMessage }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, inject, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import FloatLabel from 'primevue/floatlabel';

const email = ref('');
const password = ref('');
const errorMessage = ref('');
const router = useRouter();

// Inject the global isAuthenticated state and setAuthenticated method
const isAuthenticated = inject('isAuthenticated') as any;
const setAuthenticated = inject('setAuthenticated') as (value: boolean) => void;

const login = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: email.value, password: password.value }),
      credentials: 'include', // session cookie
    });

    if (response.ok) {
      setAuthenticated(true); 
      const data = await response.json();
      router.push('/vacancies');  // Redirect to vacancies after login
    } else {
      errorMessage.value = 'Invalid email or password';
    }
  } catch (error) {
    errorMessage.value = 'Something went wrong. Try again later.';
  }
};

// Check if user is authenticated when the page loads
onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/user', {
      credentials: 'include',
    });
    if (response.ok) {
      const data = await response.json();
      if (data.user) {
        setAuthenticated(true); // Set auth state to true if session is valid
        router.push('/vacancies'); // Redirect if authenticated
      } else {
        setAuthenticated(false);
      }
    }
  } catch (error) {
    setAuthenticated(false);
  }
});


const goToForgotPassword = () => {
  router.push('/forgot-password');
};

const goToRegister = () => {
  router.push('/register'); 
}

const goToHomepage = () => {
  router.push('/'); 
}
</script>



<style>
.p-password-input {
  width: 100%;
}
</style>