<template>
  <div v-if="visible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
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

        <label for="current_password" class="block text-sm font-medium text-gray-300">Current Password</label>
        <Password v-model="currentPassword" id="current_password" toggleMask class="w-full input-password" :feedback="false" />
        <p v-if="currentPasswordError" class="text-red-500">{{ currentPasswordError }}</p>

        <div class="mb-4 mt-4">
          <label for="new_password" class="block text-sm font-medium text-gray-300">New Password</label>
          <Password v-model="newPassword" id="new_password" toggleMask class="w-full input-password" />
          <p v-if="newPasswordError" class="text-red-500">{{ newPasswordError }}</p>
        </div>

        <label for="confirm_password" class="block text-sm font-medium text-gray-300">Confirm New Password</label>
        <Password v-model="confirmNewPassword" id="confirm_password" toggleMask class="w-full input-password" :feedback="false"/>
        <p v-if="confirmPasswordError" class="text-red-500">{{ confirmPasswordError }}</p>

        <div class="flex justify-between">
          <div v-if="!user.email_verified_at" class="flex justify-end mt-4">
            <Button label="Confirm email" class="p-button" icon="pi pi-check-square" @click="showConfirmModal = true" />
          </div>

          <div class="flex justify-end mt-4">
            <Button label="Save" class="p-button-primary" type="submit" icon="pi pi-check" iconPos="right" />
          </div>
        </div>

      <div v-if="showConfirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-[#373737] p-6 rounded-lg shadow-lg max-w-md">
      <h3 class="text-gray-300 text-xl mb-4 font-semibold">Confirm Email Verification</h3>
      <p class="text-gray-400 mb-4">We will send a verification link to your email. Are you sure?</p>
      <div class="flex justify-end">
        <Button label="Send Verification Email" class="p-button-primary" @click="sendVerificationEmail" />
        <Button label="Cancel" class="p-button-secondary ml-2" @click="showConfirmModal = false" />
      </div>
    </div>
  </div>
        <!-- Delete Account Button -->
      <div class="flex justify-end mt-4">
        <Button label="Delete Account" class="p-button-danger" icon="pi pi-trash" @click="showDeleteModal = true" />
      </div>

      <!-- Delete Confirmation Modal -->
      <div v-if="showDeleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-[#373737] p-6 rounded-lg shadow-lg max-w-md">
          <h3 class="text-gray-300 text-xl mb-4 font-semibold">Confirm Account Deletion</h3>
          <p class="text-gray-400 mb-4">Please enter your password to confirm account deletion.</p>
          <Password v-model="deletePassword" class="w-full input-password mb-4" placeholder="Enter your password" toggleMask :feedback="false" />
          <p v-if="deletePasswordError" class="text-red-500">{{ deletePasswordError }}</p>

          <div class="flex justify-end">
            <Button label="Cancel" class="p-button-secondary mr-2" @click="showDeleteModal = false" />
            <Button label="Delete" class="p-button-danger" icon="pi pi-trash" @click="deleteAccount" />
          </div>
        </div>
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

const showConfirmModal = ref(false);
const emit = defineEmits(['close']);

const sendVerificationEmail = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/send-verification-email', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      credentials: 'include', // Keep user logged in
    });

    if (response.ok) {
      const data = await response.json();
      toast.add({ severity: 'success', summary: 'Success', detail: data.message, life: 3000 });
      showConfirmModal.value = false; // Close modal after success
    } else {
      const errorData = await response.json();
      toast.add({ severity: 'error', summary: 'Error', detail: errorData.message, life: 3000 });
    }
  } catch (error) {
    console.error('Failed to send verification email', error);
    toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to send verification email', life: 3000 });
  }
};

 
const userData = ref({
  name: '',
  surname: '',
  email: '',
  phone_number: '',
  password: ''
});

// Delete confirmation modal fields
const showDeleteModal = ref(false);
const deletePassword = ref('');
const deletePasswordError = ref('');

const currentPassword = ref('');
const newPassword = ref('');
const confirmNewPassword = ref('');

const nameError = ref('');
const surnameError = ref('');
const emailError = ref('');
const phoneError = ref('');
const currentPasswordError = ref('');
const newPasswordError = ref('');
const confirmPasswordError = ref('');

const toast = useToast();

watch(
  () => props.user,
  (newUser) => {
    if (newUser) {
      userData.value = { ...newUser, password: '' };
    }
  },
  { immediate: true }
);

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

  // Name validation
  if (!validateName(userData.value.name)) {
    nameError.value = 'Name must contain only letters and be between 3 and 30 characters long.';
    return;
  }

  // Surname validation
  if (!validateName(userData.value.surname)) {
    surnameError.value = 'Surname must contain only letters and be between 3 and 30 characters long.';
    return;
  }

  // Phone number validation (if provided)
  if (userData.value.phone_number && !validatePhoneNumber(userData.value.phone_number)) {
    phoneError.value = 'Phone number must be either 8 digits or 12 characters long with an "+". (Example: 24647358; +37124647358)';
    return;
  }

  // Email validation
  if (!validateEmail(userData.value.email)) {
    emailError.value = 'Please enter a valid email (e.g., name@example.com)';
    return;
  }

  // If current password is entered, new password must also be entered
  if (currentPassword.value && !newPassword.value) {
    newPasswordError.value = 'Please provide a new password if you enter your current password';
    return;
  }

  // If new password is provided, confirm the password matches and check length
  if (newPassword.value) {
    if (!validatePassword(newPassword.value)) {
      newPasswordError.value = 'New password must be at least 8 characters';
      return;
    }
    if (newPassword.value !== confirmNewPassword.value) {
      confirmPasswordError.value = 'Passwords do not match';
      return;
    }
    if (!currentPassword.value) {
      currentPasswordError.value = 'Please provide your current password';
      return;
    }
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
        password: newPassword.value,
        password_confirmation: confirmNewPassword.value,
      }),
    });

    if (response.ok) {
      const data = await response.json();
      toast.add({ severity: 'success', summary: 'Success', detail: 'Profile successfully updated', life: 3000 });
      emit('close');
    } else {
      const errorData = await response.json();
      if (errorData.message === 'Current password is incorrect') {
        currentPasswordError.value = errorData.message;
      } else {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to update profile', life: 3000 });
      }
    }
  } catch (error) {
    console.error('Failed to update profile', error);
  }
};

// Delete account logic
const deleteAccount = async () => {
  deletePasswordError.value = '';

  if (!deletePassword.value) {
    deletePasswordError.value = 'Password is required';
    return;
  }

  try {
    const response = await fetch('http://localhost:8000/api/delete-account', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify({ password: deletePassword.value }),
    });


    if (response.ok) {
      const data = await response.json();
      toast.add({ severity: 'success', summary: 'Account Deleted', detail: data.message, life: 2000 });
      showDeleteModal.value = false;
      setTimeout(() => {
        window.location.reload();
      }, 2000); 
    } else {
      const errorData = await response.json();
      deletePasswordError.value = errorData.message;
    }
  } catch (error) {
    console.error('Failed to delete account', error);
  }
};

</script>
