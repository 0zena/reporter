<script setup lang="ts">
import { useRoute, useRouter } from 'vue-router';
import NavigationBar from '../components/navigationbar/NavBar.vue';

const route = useRoute();
const router = useRouter();

console.log(route.query); // Log route parameters for debugging

const vacancy = {
  title: route.query.title,
  category: route.query.category,
  description: route.query.description || "No description available.",
};

const goBack = () => {
  router.back();
};
</script>

<template>
  <NavigationBar />
  <div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-3">
    

    <div class="mt-6">
      <h1 class="text-3xl font-bold text-black mb-2">{{ vacancy.title }}</h1>
      <p class="text-lg italic text-black mb-1">{{ vacancy.category }}</p>
      <p class="text-base text-black leading-relaxed">{{ vacancy.description }}</p>
      <p class="text-base text-black leading-relaxed"></p>
    </div>
    <button 
      @click="goBack" 
      class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 transition-all duration-300 transform hover:translate-y-[-2px] mt-4"
    >
      Back
    </button>
  </div>
  
</template>
