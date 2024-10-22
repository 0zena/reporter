<script setup lang="ts">
import { ref, computed, onMounted, watch} from 'vue'; // Ensure 'watch' is imported
import NavigationBar from '../components/navigationbar/NavBar.vue';
import VacancySmallListing from '@/components/VacancySmallListing.vue';

import InputText from 'primevue/inputtext';
import { useRouter } from 'vue-router';

import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';

const router = useRouter();
const vacancies = ref<any[]>([]);
const searchTerm = ref('');

const fetchVacancies = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/get-favorites', {
      credentials: 'include',
    });
    const data = await response.json();
    vacancies.value = data;
  } catch (error) {
    console.error('Failed to fetch vacancies:', error);
  }
};

onMounted(() => {
  fetchVacancies();
});

</script>

<template>
  <div class="w-full min-h-screen h-auto bg-zinc-500">
    <NavigationBar></NavigationBar>
    <div id="main" class="w-full h-auto min-h-full flex flex-row-reverse">

      <div id="menu" class="bg-zinc-400 w-[350px] min-h-[calc(100vh-64px)] p-4">

        <IconField class="mt-5 ">
          <InputIcon class="pi pi-search" />
          <InputText 
            v-model="searchTerm" 
            placeholder="Search vacancies by title..." 
            class="w-full px-4 py-2 rounded-md border border-gray-300 text-black"
          />
        </IconField>

      </div>

      <div id="listing-wrapper" class="w-full h-full flex flex-col justify-center items-center pt-[75px] pb-[50px]">
        <div v-if="vacancies.length" class="w-full flex flex-wrap justify-center">
          <VacancySmallListing 
            v-for="(vacancy, index) in vacancies" 
            :key="index" 
            :id="vacancy.id"
            :image="vacancy.vacancy_image ? 'http://127.0.0.1:8000/storage/' + vacancy.vacancy_image.image_path : undefined" 
            :title="vacancy.title" 
            :category="vacancy.category"
            :speciality="vacancy.speciality"
          />
        </div>
        <p v-else>You haven't saved any vacancies</p>
      </div>
      
    </div>
  </div>
</template>
