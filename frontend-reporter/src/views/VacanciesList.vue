<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import NavigationBar from '../components/navigationbar/NavBar.vue';
import VacancySmallListing from '@/components/VacancySmallListing.vue';

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';  // Import PrimeVue InputText
import { useRouter } from 'vue-router';

import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';


const router = useRouter();
const vacancies = ref([]);
const searchTerm = ref('');

const goToEditor = () => {
  router.push('/editor');
};

// Fetch the vacancies using fetch API
const fetchVacancies = async () => {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/vacancies'); // Replace with your actual API endpoint
    const data = await response.json();

    // Assign the response data to the vacancies ref
    vacancies.value = data;
  } catch (error) {
    console.error('Failed to fetch vacancies:', error);
  }
};

onMounted(() => {
  fetchVacancies();
});

// Computed property for filtered vacancies
const filteredVacancies = computed(() => {
  if (!searchTerm.value.trim()) {
    return vacancies.value;
  }
  const term = searchTerm.value.toLowerCase();
  return vacancies.value.filter((vacancy: any) =>
    vacancy.title.toLowerCase().includes(term)
  );
});
</script>

<template>
  <div class="w-full min-h-screen h-auto bg-zinc-500">
    <NavigationBar></NavigationBar>
    <div id="main" class="w-full h-auto min-h-full flex flex-row-reverse">

      <div id="menu-placeholder" class="bg-zinc-400 w-[350px] h-auto min-h-full">

        <IconField class="mt-5 ">
          <InputIcon class="pi pi-search" />
          <InputText 
            v-model="searchTerm" 
            placeholder="Search vacancies by title..." 
            class="w-full px-4 py-2 rounded-md border border-gray-300 text-black"
          />
        </IconField>

      </div>

      <Button icon="pi pi-plus" class="h-10 m-5" style="width: 3rem;" @click="goToEditor"/>

      <div id="listing-wrapper" class="w-full h-full flex flex-col justify-center items-center pt-[75px] pb-[50px]">
        <div v-if="filteredVacancies.length" class="w-full flex flex-wrap justify-center">
          <VacancySmallListing 
            v-for="(vacancy, index) in filteredVacancies" 
            :key="index" 
            :id="vacancy.id"
            :image="vacancy.vacancy_image ? 'http://127.0.0.1:8000/storage/' + vacancy.vacancy_image.image_path : '/default-image.png'" 
            :title="vacancy.title" 
            :category="vacancy.category"
          />
        </div>
        <p v-else>No vacancies found.</p>
      </div>
      
    </div>
  </div>
</template>
