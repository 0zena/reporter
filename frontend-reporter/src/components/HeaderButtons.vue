<template>
  <div class="top-0 right-0 p-4">
    <div v-if="isAuthenticated">
      <!-- Show the 'Edit Profile' and 'Logout' buttons if the user is logged in -->
      <Button v-if="isAdmin" label="Admin" class="mr-2" icon="pi pi-cog" @click="router.push('/admin')" />
      <Button label="Edit Profile" class="p-button-warning mr-2" icon="pi pi-user" @click="openEditProfileModal" />
      <Button label="Logout" class="p-button-danger" @click="logout" />
    </div>
    <div v-else>
      <!-- Show login and register buttons if the user is not logged in -->
      <Button label="Login" class="p-button-info mr-2" @click="goToLogin" />
      <Button label="Register" class="p-button" @click="goToRegister" />
    </div>

    <!-- Modal for editing profile -->
    <EditProfileModal
      v-if="isEditProfileModalVisible"
      :visible="isEditProfileModalVisible"
      :user="currentUser"  
      @close="closeEditProfileModal"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, inject, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Button from 'primevue/button';
import EditProfileModal from '@/components/EditProfileModal.vue';

const isAuthenticated = inject('isAuthenticated') as any;
const setAuthenticated = inject('setAuthenticated') as (value: boolean) => void;
const isEditProfileModalVisible = ref(false); // State for modal visibility
const currentUser = ref(null); // Store user data for editing
const router = useRouter();
const isAdmin = ref(false);

// Functions for logout and modal visibility
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

const openEditProfileModal = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/user', {
      credentials: 'include',
    });
    if (response.ok) {
      const data = await response.json();
      currentUser.value = data.user; // Set the current user data for the modal
      isEditProfileModalVisible.value = true; // Open the edit profile modal
    }
  } catch (error) {
    console.error('Failed to fetch user data', error);
  }
};

const closeEditProfileModal = () => {
  isEditProfileModalVisible.value = false; // Close the edit profile modal
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
        setAuthenticated(true);
        currentUser.value = data.user;

        if (data.user['is_admin'] === 1) {
          isAdmin.value = true;
        } else {
          isAdmin.value = false;
        }

      } else {
        setAuthenticated(false);
        isAdmin.value = false;
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
