<script setup lang="ts">
import { ref, computed, onMounted, watch} from 'vue'; // Ensure 'watch' is imported
import NavigationBar from '../components/navigationbar/NavBar.vue';
import VacancySmallListing from '@/components/VacancySmallListing.vue';

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';  // Import PrimeVue InputText
import Select from 'primevue/select';
import { useRouter } from 'vue-router';

import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';

const router = useRouter();
const vacancies = ref<any[]>([]);
const searchTerm = ref('');
const selectedSortOption = ref('');

// Category and speciality filter states
const selectedCategoryId = ref<number | null>(null);
const selectedSpecialityId = ref<number | null>(null);
const categories = ref<any[]>([]);
const specialities = ref<any[]>([]);


const goToEditor = () => {
  router.push('/editor');
};

// Fetch the vacancies using fetch API
const fetchVacancies = async () => {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/vacancies');
    const data = await response.json();
    vacancies.value = data;
  } catch (error) {
    console.error('Failed to fetch vacancies:', error);
  }
};

// Fetch categories and specialities
const fetchCategories = async () => {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/categories');
    categories.value = await response.json();
  } catch (error) {
    console.error('Failed to fetch categories:', error);
  }
};

const fetchSpecialities = async (categoryId: number) => {
  try {
    const response = await fetch(`http://127.0.0.1:8000/api/specialities/${categoryId}`);
    specialities.value = await response.json();
  } catch (error) {
    console.error('Failed to fetch specialities:', error);
    specialities.value = [];
  }
};

// Watch for category selection changes and fetch the corresponding specialities
watch(selectedCategoryId, (newCategoryId) => {
  if (newCategoryId) {
    fetchSpecialities(newCategoryId);
  } else {
    specialities.value = [];
    selectedSpecialityId.value = null;
  }
});

onMounted(() => {
  fetchCategories();
  fetchVacancies();
});

// Computed property for filtered vacancies
const filteredVacancies = computed(() => {
  let filtered = vacancies.value;

  // Filter by search term
  if (searchTerm.value.trim()) {
    const term = searchTerm.value.toLowerCase();
    filtered = filtered.filter(vacancy => 
      vacancy.title.toLowerCase().includes(term)
    );
  }

 // Filter by category if a category is selected
 if (selectedCategoryId.value !== null) {
    filtered = filtered.filter(vacancy => vacancy.category_id === selectedCategoryId.value);
  }

  // Filter by speciality if a speciality is selected
  if (selectedSpecialityId.value !== null) {
    filtered = filtered.filter(vacancy => vacancy.speciality_id === selectedSpecialityId.value);
  }

  return filtered;
});

// Computed property for sorted vacancies
const sortedVacancies = computed(() => {
  const sortOption = selectedSortOption.value;
  const sortedList = [...filteredVacancies.value];

  if (sortOption === 'name-asc') {
    return sortedList.sort((a, b) => a.title.localeCompare(b.title));
  } else if (sortOption === 'name-desc') {
    return sortedList.sort((a, b) => b.title.localeCompare(a.title));
  } else if (sortOption === 'category-asc') {
    return sortedList.sort((a, b) => a.category.localeCompare(b.category));
  } else if (sortOption === 'category-desc') {
    return sortedList.sort((a, b) => b.category.localeCompare(a.category));
  } else if (sortOption === 'date-newest') {
    // Sort by ID (assuming higher ID means newer)
    return sortedList.sort((a, b) => b.id - a.id); // Newest first (higher id comes first)
  } else if (sortOption === 'date-oldest') {
    // Sort by ID (lower ID means older)
    return sortedList.sort((a, b) => a.id - b.id); // Oldest first (lower id comes first)
  }

  return sortedList;
});

// Function to reset all filters and sorting
const resetFilters = () => {
  selectedSortOption.value = '';
  selectedCategoryId.value = null;
  selectedSpecialityId.value = null;
  searchTerm.value = '';
};
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
        
        <div class="mt-4">
          <h3 class="text-lg text-black font-semibold mb-2">Filter:</h3>

           <p class="text-black">Categories</p>
          <Select
            v-model="selectedCategoryId"
            :options="[{ id: null, name: 'All' }, ...categories]"
            optionLabel="name"
            optionValue="id"
            placeholder="Select Category"
            class="w-full mb-4"
          />

          <p class="text-black">Specialities</p>
          <Select
            v-model="selectedSpecialityId"
            :options="[{ id: null, name: 'All' }, ...specialities]"
            optionLabel="name"
            optionValue="id"
            placeholder="Select Speciality"
            :disabled="!selectedCategoryId"
            class="w-full mb-4"
          />

        </div>

        <Button label="Reset Filters" class="w-full" @click="resetFilters" />

      </div>

      <Button icon="pi pi-plus" class="h-10 m-5" style="width: 3rem;" @click="goToEditor"/>

      <div id="listing-wrapper" class="w-full h-full flex flex-col justify-center items-center pt-[75px] pb-[50px]">
        <div v-if="sortedVacancies.length" class="w-full flex flex-wrap justify-center">
          <VacancySmallListing 
            v-for="(vacancy, index) in sortedVacancies" 
            :key="index" 
            :id="vacancy.id"
            :image="vacancy.vacancy_image ? 'http://127.0.0.1:8000/storage/' + vacancy.vacancy_image.image_path : undefined" 
            :title="vacancy.title" 
            :category="vacancy.category"
            :speciality="vacancy.speciality"
          />
        </div>
        <p v-else>No vacancies found.</p>
      </div>
      
    </div>
  </div>
</template>
