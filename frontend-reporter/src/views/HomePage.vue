<template>
  <div class="relative h-screen flex flex-col justify-center items-center">
    
    <div
      class="absolute inset-0 bg-cover bg-center"
      :style="{ backgroundImage: `url('./src/assets/image.png')` }"
    ></div>

    
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    
    <div class="relative z-10 text-center text-white">
      <h1 class="text-5xl font-bold mb-4">Welcome to Our Site</h1>
      <p class="text-xl mb-8">Discover amazing listings and more</p>
    </div>

    
    <div class="absolute bottom-10">
      <Button
        label="Go to Listings"
        class="bg-black text-white text-2xl w-64 py-4 hover:bg-gray-100 transition-colors duration-300"
        @click="goToListings"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Button from "primevue/button";
import { useRouter } from 'vue-router'; 

export default defineComponent({
  components: {
    Button,
  },
  setup() {
    const router = useRouter(); 
    const goToListings = () => {
      router.push('/vacancies'); // Redirect to the vacancies page
    };
    return {
      goToListings
    };
  }
});
</script>