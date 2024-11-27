<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import NavigationBar from '../components/navigationbar/NavBar.vue';
import VacancySmallListing from '@/components/VacancySmallListing.vue';
import Button from 'primevue/button';

import InputText from 'primevue/inputtext';
import { useRouter } from 'vue-router';

import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';

const router = useRouter();
const vacancies = ref<any[]>([]);
const searchTerm = ref('');
const isFilterMenuVisible = ref(false); // New state for menu visibility

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

const filteredVacancies = computed(() => {
  let filtered = vacancies.value;

  if (searchTerm.value.trim()) {
    const term = searchTerm.value.toLowerCase();
    filtered = filtered.filter(vacancy => 
      vacancy.title.toLowerCase().includes(term)
    );
  }

  return filtered;
});

onMounted(() => {
  fetchVacancies();
});
</script>

<template>
  <div class="w-full min-h-screen h-auto bg-zinc-500">
    <NavigationBar></NavigationBar>
    <div id="main" class="w-full h-auto min-h-full flex flex-row-reverse">

      <!-- Menu -->
      <div
        id="menu"
        :class="[
          'bg-zinc-400 min-w-[350px] min-h-[calc(100vh-64px)] p-4',
          isFilterMenuVisible ? 'absolute top-0 left-0 w-full h-full z-50' : 'hidden lg:block'
        ]"
      >
        <!-- Close Button (Visible on small screens) -->
        <Button
          v-if="isFilterMenuVisible"
          icon="pi pi-times"
          class="absolute top-4 right-4"
          @click="isFilterMenuVisible = false"
        />

        <!-- Search -->
        <IconField class="mt-5">
          <InputIcon class="pi pi-search" />
          <InputText
            v-model="searchTerm"
            placeholder="Search vacancies by title..."
            class="w-full px-4 py-2 rounded-md border border-gray-300 text-black"
          />
        </IconField>
      </div>

      <!-- Main Content -->
      <div class="flex flex-col w-full">
        <!-- Filter Button -->
        <div id="button-wrapper" class="flex h-[70px] w-full justify-end">
          <Button
            icon="pi pi-filter"
            class="h-10 m-5 lg:!hidden"
            style="width: 2.5rem;"
            @click="isFilterMenuVisible = !isFilterMenuVisible"
          />
        </div>

        <!-- Vacancies Listing -->
        <div
          id="listing-wrapper"
          class="w-full h-full flex flex-col items-center pb-[50px]"
        >
          <div
            v-if="filteredVacancies.length"
            class="w-full flex flex-wrap justify-center"
          >
            <VacancySmallListing
              v-for="(vacancy, index) in filteredVacancies"
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
  </div>
</template>
