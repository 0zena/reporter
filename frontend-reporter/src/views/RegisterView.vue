<template>
  <NavigationBar></NavigationBar>
  <div class="fixed top-0 left-0 p-4"> 
    <Button icon="pi pi-arrow-left" @click="goToHomepage" />
  </div>
  <div id="container" class="flex justify-center items-center h-screen bg-black px-4">
    <div id="card" class="p-6 max-w-md w-full shadow-lg rounded-md bg-zinc-800">
      <h2 class="text-center text-2xl mb-7 text-white">Register</h2>

      <p v-if="successMessage" class="text-green-500 text-center mb-4">{{ successMessage }}</p>

      <form @submit.prevent="register">
        <FloatLabel class="mb-7">
          <label for="name" class="block mb-2">Name</label>
          <InputText v-model="name" id="name" type="text" class="w-full" required />
          <p v-if="nameError" class="text-red-500">{{ nameError }}</p>
        </FloatLabel>

        <FloatLabel class="mb-7">
          <label for="surname" class="block mb-2">Surname</label>
          <InputText v-model="surname" id="surname" type="text" class="w-full" required />
          <p v-if="surnameError" class="text-red-500">{{ surnameError }}</p>
        </FloatLabel>

        <FloatLabel class="mb-7">
          <label for="email" class="block mb-2">Email</label>
          <InputText v-model="email" id="email" type="email" class="w-full" required />
          <p v-if="emailError" class="text-red-500">{{ emailError }}</p>
        </FloatLabel>

        <FloatLabel class="mb-7">
          <label for="phone_number" class="block mb-2">Phone Number (Optional)</label>
          <InputText v-model="phoneNumber" id="phone_number" type="tel" class="w-full" />
          <p v-if="phoneError" class="text-red-500">{{ phoneError }}</p>
        </FloatLabel>

        <FloatLabel class="mb-7 w-full">
          <Password v-model="password" type="password" toggleMask id="password" class="w-full input-password" required />
          <label for="password" class="block mb-2">Password</label>
        </FloatLabel>

        <FloatLabel class="mb-7">
          <Password v-model="passwordConfirmation" toggleMask :feedback="false" id="password_confirmation" class="w-full input-password" required />
          <label for="password_confirmation" class="block mb-2">Confirm Password</label>
        </FloatLabel>
        
        <Button label="Register" class="w-full" type="submit" />
      </form>

      <div class="text-center mt-4"> 
        <Button label="Log In" outlined class="border-green-600 w-full" @click="goToLogin" /> 
      </div>

      <p v-if="errorMessage" class="text-red-500 text-center mt-4">{{ errorMessage }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import FloatLabel from 'primevue/floatlabel';

const name = ref('');
const surname = ref('');
const email = ref('');
const phoneNumber = ref('');
const password = ref('');
const passwordConfirmation = ref('');
const errorMessage = ref('');
const successMessage = ref('');
const phoneError = ref('');
const nameError = ref('');
const surnameError = ref('');
const emailError = ref('');
const router = useRouter();

const validateName = (value: string) => /^[a-zA-Z]{3,30}$/.test(value);
const validatePhoneNumber = (value: string) => {
  return (
    (value.length === 8 && /^\d+$/.test(value)) || // 8-digit phone number
    (value.length === 12 && /^\+\d+$/.test(value)) // 12-character phone number with "+"
  );
};
const validateEmail = (value: string) => {
  const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return emailRegex.test(value) && value.length <= 254;
};

const register = async () => {
  // Clear previous errors
  errorMessage.value = '';
  phoneError.value = '';
  nameError.value = '';
  surnameError.value = '';
  emailError.value = '';

  // Name validation
  if (!validateName(name.value)) {
    nameError.value = 'Name must contain only letters and be between 3 and 30 characters long.';
    return;
  }

  // Surname validation
  if (!validateName(surname.value)) {
    surnameError.value = 'Surname must contain only letters and be between 3 and 30 characters long.';
    return;
  }

  // Phone number validation (if provided)
  if (phoneNumber.value && !validatePhoneNumber(phoneNumber.value)) {
    phoneError.value = 'Phone number must be either 8 digits or 12 characters long with an "+". (Example: 24647358; +37124647358)';
    return;
  }

  // Email validation
  if (!validateEmail(email.value)) {
    emailError.value = 'Please enter a valid email (e.g. name@example.com).';
    return;
  }

  // Password match validation
  if (password.value !== passwordConfirmation.value) {
    errorMessage.value = 'Passwords do not match';
    return;
  }

  // Password length validation
  if (password.value.length < 8) {
    errorMessage.value = 'Password must be at least 8 characters long';
    return;
  }

  // Registration logic
  try {
    const response = await fetch('http://localhost:8000/api/register', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        name: name.value,
        surname: surname.value,
        email: email.value,
        phone_number: phoneNumber.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value,
      }),
    });

    if (response.ok) {
      successMessage.value = 'You are registered!';
      setTimeout(() => {
        router.push('/login');
      }, 2000);
    } else {
      const data = await response.json();
      if (data.message === 'Email already in use') {
        emailError.value = 'This email is already registered.';
      } else {
        errorMessage.value = 'Failed to register. Please try again.';
      }
    }
  } catch (error) {
    errorMessage.value = 'An error occurred. Please try again later.';
  }
};

const goToLogin = () => {
  router.push('/login'); 
};

const goToHomepage = () => {
  router.push('/'); 
};
</script>

<style>
.p-password-input {
  width: 100%;
}
</style>
