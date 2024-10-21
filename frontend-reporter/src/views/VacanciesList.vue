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
const selectedSortOption = ref('');

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

const sortVacancies = (vacanciesArray: any[]) => {
  switch (selectedSortOption.value) {
    case 'name-asc':
      return vacanciesArray.sort((a, b) => a.title.localeCompare(b.title));
    case 'name-desc':
      return vacanciesArray.sort((a, b) => b.title.localeCompare(a.title));
    case 'category-asc':
      return vacanciesArray.sort((a, b) => a.category.localeCompare(b.category));
    case 'category-desc':
      return vacanciesArray.sort((a, b) => b.category.localeCompare(a.category));
    case 'date-newest':
      return vacanciesArray.sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime()); // Sort by newest
    case 'date-oldest':
      return vacanciesArray.sort((a, b) => new Date(a.created_at).getTime() - new Date(b.created_at).getTime()); // Sort by oldest
    default:
      return vacanciesArray;
  }
};


const filteredVacancies = computed(() => {
  let filtered = vacancies.value;
  
  if (searchTerm.value.trim()) {
    const term = searchTerm.value.toLowerCase();
    filtered = filtered.filter((vacancy: any) =>
      vacancy.title.toLowerCase().includes(term)
    );
  }
  
  return sortVacancies(filtered);
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

        <div class="mt-4">
          <h3 class="text-lg text-black font-semibold mb-2">Sort by:</h3>
          <select v-model="selectedSortOption" class="w-full px-4 py-2 rounded-md border border-gray-300 text-black">
            <option value="">Default</option>
            <option value="name-asc">Name (A-Z)</option>
            <option value="name-desc">Name (Z-A)</option>
            <option value="category-asc">Category (A-Z)</option>
            <option value="category-desc">Category (Z-A)</option>
            <option value="date-newest">Newest</option>
            <option value="date-oldest">Oldest</option>

          </select>
        </div>

      </div>

      <Button icon="pi pi-plus" class="h-10 m-5" style="width: 3rem;" @click="goToEditor"/>

      <div id="listing-wrapper" class="w-full h-full flex flex-col justify-center items-center pt-[75px] pb-[50px]">
        <div v-if="filteredVacancies.length" class="w-full flex flex-wrap justify-center">
          <VacancySmallListing 
            v-for="(vacancy, index) in filteredVacancies" 
            :key="index" 
            :id="vacancy.id"
            :image="vacancy.vacancy_image ? 'http://127.0.0.1:8000/storage/' + vacancy.vacancy_image.image_path : undefined" 
            :title="vacancy.title" 
            :category="vacancy.category"
          />
        </div>
        <p v-else>No vacancies found.</p>
      </div>
      
    </div>
  </div>
</template>
