<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import NavigationBar from '../components/navigationbar/NavBar.vue';

const route = useRoute();
const router = useRouter();

const vacancy = ref({
  title: '',
  description: '',
  category: '',
});

const fetchVacancy = async (id: string | string[] | undefined) => {
  if (id) {
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/vacancies/${id}`);
      if (!response.ok) {
        throw new Error('Failed to fetch vacancy');
      }
      const data = await response.json();
      vacancy.value = data;
    } catch (error) {
      console.error('Error fetching vacancy:', error);
    }
  }
};

onMounted(() => {
  const id = route.params.id || route.query.id;
  fetchVacancy(id);
});

const goBack = () => {
  router.back();
};
</script>

<template>
  <NavigationBar />
  <div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-3">
    <div id="image-wrapper" class="flex">
      <img v-if="vacancy.image" :src="`http://127.0.0.1:8000${vacancy.image}`" alt="Vacancy Image" class="w-full h-[200px] object-cover object-[0_30%] mb-4">
    </div>
    <div class="mt-6">
      <h1 class="text-3xl font-bold text-black mb-2">{{ vacancy.title }}</h1>
      <p class="text-lg italic text-black mb-1">{{ vacancy.category }}</p>
      <div class="text-base text-black leading-relaxed" v-html="vacancy.description"></div>
    </div>
    <button 
      @click="goBack" 
      class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 transition-all duration-300 transform hover:translate-y-[-2px] mt-4"
    >
      Back
    </button>
  </div>
</template>
