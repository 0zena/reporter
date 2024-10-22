<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import NavigationBar from '../components/navigationbar/NavBar.vue';
import axios from 'axios';

import Button from 'primevue/button';

const route = useRoute();
const router = useRouter();

const vacancy = ref({
  title: '',
  description: '',
  category: '',
  owner: '',
});

const isFavorited = ref(false);

var id = ref("");
const isAdmin = ref(false);

const checkIfFavorited = async () => {
  try {
    const response = await fetch(`http://localhost:8000/api/favorites/${id}`, {
      credentials: 'include',
    });

    if (!response.ok) {
      throw new Error('Failed to check favorite status');
    }

    const data = await response.json();
    isFavorited.value = data.isFavorited;
  } catch (error) {
    console.error('Error checking favorite status:', error);
  }
};

const toggleFavorite = async () => {
  try {
    const response = await fetch(`http://localhost:8000/api/favorites/${id}`, {
      method: 'POST',
      credentials: 'include',
    });

    if (!response.ok) {
      throw new Error('Failed to toggle favorite status');
    }

    const data = await response.json();
    isFavorited.value = !isFavorited.value;
  } catch (error) {
    console.error('Error toggling favorite status:', error);
  }
};

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

const fetchVacancy = async (id: string | string[] | undefined) => {
  if (id) {
    try {
      const response = await fetch(`http://localhost:8000/api/vacancies/${id}`);
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

const downloadPDF = async (id) => {
    try {
        const response = await axios.get(`http://localhost:8000/api/export-user-pdf/${id}`, {
            responseType: 'blob',
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;

        link.setAttribute('download', `user_${id}_details.pdf`);

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } catch (error) {
        console.error('Error downloading the PDF:', error);
    }
};

const deleteVacancy = async () => {
  if (confirm("Are you sure you want to delete this vacancy?")) {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/vacancies/${id}`);
      router.push('/vacancies');
    } catch (error) {
      console.error('Error deleting vacancy:', error);
      alert('Failed to delete vacancy');
    }
  }
};


onMounted(() => {
  id = route.params.id || route.query.id;
  fetchVacancy(id);
  checkIfFavorited();
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
      <div class="flex justify-between">
        <h1 class="text-3xl font-bold text-black mb-2">{{ vacancy.title }}</h1>
        <Button 
          id="fav-button"
          :icon="isFavorited ? 'pi pi-star-fill' : 'pi pi-star'" 
          @click="toggleFavorite"
          severity="help"
          text
          rounded
          style="font-size: 2rem !important;"
        />
      </div>
      <p class="text-lg italic text-black mb-1">{{ vacancy.category }}</p>
      <div class="text-base text-black leading-relaxed" v-html="vacancy.description"></div>
    </div>
    <div id="button-wrapper" class="flex pt-4">
      <Button 
        @click="goBack"
        label="Back"
        class="!bg-blue-600 hover:!bg-blue-500 !border-blue-600 hover:!border-blue-500"
      />
      <Button 
        @click="downloadPDF(vacancy.owner)" 
        icon="pi pi-download"
        label="Get contact info"
        class="mx-2"
      />
  
      <div v-if="isAdmin" id="delete-wrapper" class="ml-auto">
        <Button 
          @click="deleteVacancy"
          severity="danger"
          icon="pi pi-trash"
          label="Delete"
          class=""
        />
      </div>
    </div>

  </div>
</template>

<style>
#fav-button>span {
  font-size: 1.5rem !important;
}
</style>