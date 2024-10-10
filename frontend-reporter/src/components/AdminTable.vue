<script setup>
import ToggleSwitch from 'primevue/toggleswitch';
import Button from 'primevue/button';

import { inject, onMounted, ref } from 'vue';

const checked = ref(true);
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
          <tr class="border-b bg-gray-50 text-gray-900">
            <td class="px-4 py-2 text-center">1</td>
            <td class="px-4 py-2 text-center">John</td>
            <td class="px-4 py-2 text-center">Doe</td>
            <td class="px-4 py-2 text-center">john.doe@example.com</td>
            <td class="px-4 py-2 text-center"><ToggleSwitch v-model="checked" /></td>
            <td class="py-2 text-center"><Button class="h-[35px] p-button-danger" icon="pi pi-trash" /></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>