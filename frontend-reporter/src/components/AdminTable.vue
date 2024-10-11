<script setup>
import ToggleSwitch from 'primevue/toggleswitch';
import Button from 'primevue/button';
import { ref, onMounted } from 'vue';

const users = ref([]);

const fetchUsers = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/users');
    if (response.ok) {
      const data = await response.json();
      users.value = data.map(user => ({
        ...user,
        is_admin: Boolean(user.is_admin),
      }));
    }
  } catch (error) {
    console.error('Error fetching users:', error);
  }
};

const toggleAdminStatus = async (user, value) => {
  try {
    const response = await fetch(`http://localhost:8000/api/users/${user.id}/toggle-admin`, {
      method: 'PATCH',
    });
    if (response.ok) {
      user.is_admin = value;
    } else {
      console.error('Error toggling admin status');
    }
  } catch (error) {
    console.error('Error toggling admin status:', error);
  }
};

const deleteUser = async (userId) => {
  try {
    const response = await fetch(`http://localhost:8000/api/users/${userId}`, {
      method: 'DELETE',
    });
    if (response.ok) {
      users.value = users.value.filter(user => user.id !== userId);
    } else {
      console.error('Error deleting user');
    }
  } catch (error) {
    console.error('Error deleting user:', error);
  }
};

onMounted(() => {
  fetchUsers();
});
</script>

<template>
  <div class="container mx-10 py-6">
    <div class="overflow-x-auto">
      <table class="min-w-[1000px] table-auto bg-white rounded-lg shadow-md">
        <thead class="rounded-t-lg">
          <tr class="bg-gray-800 text-white">
            <th class="px-4 py-2 rounded-tl-lg">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Surname</th>
            <th class="px-4 py-2">E-mail</th>
            <th class="px-4 py-2">Admin</th>
            <th class="px-4 py-2 rounded-tr-lg"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="border-b bg-gray-50 text-gray-900">
            <td class="px-4 py-2 text-center">{{ user.id }}</td>
            <td class="px-4 py-2 text-center">{{ user.name }}</td>
            <td class="px-4 py-2 text-center">{{ user.surname }}</td>
            <td class="px-4 py-2 text-center">{{ user.email }}</td>
            <td class="px-4 py-2 text-center">
              <ToggleSwitch 
                :model-value="user.is_admin"
                @update:modelValue="(value) => toggleAdminStatus(user, value)"
              />
            </td>
            <td class="py-2 text-center">
              <Button class="h-[35px] p-button-danger" icon="pi pi-trash" @click="deleteUser(user.id)" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
