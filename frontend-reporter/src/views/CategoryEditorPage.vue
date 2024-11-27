<script setup>
import NavBar from "@/components/navigationbar/NavBar.vue";
import CategoryEditor from "@/components/CategoryEditor.vue";

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
  <div class="w-full min-h-screen h-auto bg-zinc-400 ">
    <NavBar></NavBar>
    
    <div v-if="isAdmin" class="flex">
      <CategoryEditor></CategoryEditor>
    </div>
    <div v-else class="flex flex-col justify-center items-center">
      <i class="pi pi-ban text-red-500 pt-20 pb-10" style="font-size: 20rem;"></i>
      <h1 class="text-black text-3xl font-bold text-center max-w-[450px]">To view the contents of this page you need to be logged in as an admin</h1>
    </div>

  </div>
</template>