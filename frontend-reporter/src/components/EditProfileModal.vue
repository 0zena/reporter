<template>
  <div v-if="visible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-black p-6 rounded-lg shadow-lg w-full max-w-md">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-gray-300 text-xl font-semibold">Edit Profile</h3>
        <Button icon="pi pi-times" class="p-dialog-header-icon" @click="$emit('close')" />
      </div>
      <form @submit.prevent="updateProfile">
        <!-- Name Field -->
        <FloatLabel class="mb-7 mt-7">
          <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
          <InputText v-model="userData.name" id="name" class="w-full" required />
          <p v-if="nameError" class="text-red-500">{{ nameError }}</p>
        </FloatLabel>

        <!-- Surname Field -->
        <FloatLabel class="mb-7">
          <label for="surname" class="block text-sm font-medium text-gray-300">Surname</label>
          <InputText v-model="userData.surname" id="surname" class="w-full" required />
          <p v-if="surnameError" class="text-red-500">{{ surnameError }}</p>
        </FloatLabel>

        <!-- Email Field -->
        <FloatLabel class="mb-7">
          <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
          <InputText v-model="userData.email" id="email" type="email" class="w-full" required />
          <p v-if="emailError" class="text-red-500">{{ emailError }}</p>
        </FloatLabel>

        <!-- Phone Number Field -->
        <FloatLabel class="mb-7">
          <label for="phone_number" class="block text-sm font-medium text-gray-300">Phone Number</label>
          <InputText v-model="userData.phone_number" id="phone_number" type="tel" class="w-full" />
          <p v-if="phoneError" class="text-red-500">{{ phoneError }}</p>
        </FloatLabel>

        <h3 class="text-gray-300 text-xl mb-3 font-semibold">Reset Password</h3>

        <!-- Current Password Field -->
        
          <label for="current_password" class="block text-sm font-medium text-gray-300">Current Password</label>
          <Password v-model="currentPassword" id="current_password" toggleMask class="w-full input-password" :feedback="false" />
          <p v-if="currentPasswordError" class="text-red-500">{{ currentPasswordError }}</p>
      

        <!-- New Password Field -->
        <div class="mb-4 mt-4">
          <label for="new_password" class="block text-sm font-medium text-gray-300">New Password</label>
          <Password v-model="newPassword" id="new_password" toggleMask class="w-full input-password" />
          <p v-if="newPasswordError" class="text-red-500">{{ newPasswordError }}</p>
        </div>

        <!-- Confirm New Password Field -->
          <label for="confirm_password" class="block text-sm font-medium text-gray-300">Confirm New Password</label>
          <Password v-model="confirmNewPassword" id="confirm_password" toggleMask class="w-full input-password" :feedback="false"/>
          <p v-if="confirmPasswordError" class="text-red-500">{{ confirmPasswordError }}</p>
        

        <!-- Save Button -->
        <div class="flex justify-end mt-4">
          <Button label="Save" class="p-button-primary" type="submit" icon="pi pi-check" iconPos="right" />
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel';
import { useToast } from 'primevue/usetoast';

const props = defineProps({
  visible: Boolean,
  user: Object,
});

const emit = defineEmits(['close']);

const userData = ref({
  name: '',
  surname: '',
  email: '',
  phone_number: '',
  password: ''
});

// Password-related fields
const currentPassword = ref('');
const newPassword = ref('');
const confirmNewPassword = ref('');

// Error messages
const nameError = ref('');
const surnameError = ref('');
const emailError = ref('');
const phoneError = ref('');
const currentPasswordError = ref('');
const newPasswordError = ref('');
const confirmPasswordError = ref('');

// PrimeVue Toast
const toast = useToast();

// Watch for user prop changes
watch(
  () => props.user,
  (newUser) => {
    if (newUser) {
      userData.value = { ...newUser, password: '' }; // Don't pre-fill password
    }
  },
  { immediate: true }
);

// Validation functions
const validateName = (value: string) => /^[a-zA-Z]+$/.test(value);
const validatePhoneNumber = (value: string) => /^\+?\d+$/.test(value);  // Optional "+" at the beginning
const validateEmail = (email: string) => /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email);
const validatePassword = (password: string) => password.length >= 8;

const updateProfile = async () => {
  // Clear errors
  nameError.value = '';
  surnameError.value = '';
  emailError.value = '';
  phoneError.value = '';
  currentPasswordError.value = '';
  newPasswordError.value = '';
  confirmPasswordError.value = '';

  // Validate fields
  if (!userData.value.name) {
    nameError.value = 'Name is required';
    return;
  }
  if (!userData.value.surname) {
    surnameError.value = 'Surname is required';
    return;
  }
  if (!validateEmail(userData.value.email)) {
    emailError.value = 'Invalid email format';
    return;
  }
  if (newPassword.value && !validatePassword(newPassword.value)) {
    newPasswordError.value = 'New password must be at least 8 characters';
    return;
  }
  if (newPassword.value !== confirmNewPassword.value) {
    confirmPasswordError.value = 'Passwords do not match';
    return;
  }
  if (newPassword.value && !currentPassword.value) {
    currentPasswordError.value = 'Please provide your current password';
    return;
  }

  // Profile update logic here...
  try {
    const response = await fetch('http://localhost:8000/api/update', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify({
        ...userData.value,
        current_password: currentPassword.value,
        new_password: newPassword.value,
        confirm_new_password: confirmNewPassword.value,
      }),
    });
    if (response.ok) {
      const data = await response.json();
      toast.add({ severity: 'success', summary: 'Success', detail: 'Profile successfully updated', life: 3000 });
      emit('close');
    } else {
      toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to update profile', life: 3000 });
    }
  } catch (error) {
    console.error('Failed to update profile', error);
  }
};
</script>
