<script setup lang="ts">
import { onMounted, ref } from 'vue';

const isAdmin = ref(false);

onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/user', {
      credentials: 'include',
    });

    if (response.ok) {
      const data = await response.json();

      if (data.user) {
  
        if (data.user['is_admin'] === 1) {
          isAdmin.value = true;
        } else {
          isAdmin.value = false;
        }
      } else {
        isAdmin.value = false;
      }
    }
  } catch (error) {
    isAdmin.value = false;
  }
});

</script>

<template>

    <iframe v-if="isAdmin" src="src/assets/Admin-guide.pdf" class="size-full" />
    <div v-else class="flex flex-col justify-center items-center">
        <i class="pi pi-ban text-red-500 pt-20 pb-10" style="font-size: 20rem;"></i>
        <h1 class="text-black text-3xl font-bold text-center max-w-[450px]">To view the contents of this page you need to be logged in as an admin</h1>
    </div>
</template>
