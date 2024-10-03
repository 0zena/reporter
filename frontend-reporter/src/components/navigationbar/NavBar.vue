<template>
  <header>
    <nav>
      <div class="flex justify-between h-16 px-10 shadow items-center bg-white">
        <!-- Logo and Nav links -->
        <div class="flex items-center space-x-8">
          <h1 class="text-xl font-bold cursor-pointer text-black">Reporter</h1>

          <!-- Desktop Menu -->
          <div class="hidden md:flex justify-around space-x-4">
            <a href="#" class="relative text-gray-700 link-underline">Vacancies</a>
            <a href="#" class="relative text-gray-700 link-underline">My Vacancies</a>
            <a href="#" class="relative text-gray-700 link-underline">Favorites</a>
          </div>
        </div>

        <!-- Menu for Login/Signup -->
        <HeaderButtons />

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
          <button @click="isOpen = !isOpen" class="text-gray-800 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-if="isOpen" class="md:hidden bg-white shadow-lg px-6 py-4 space-y-2">
        <a href="#" class="block text-gray-700 link-underline">Vacancies</a>
        <a href="#" class="block text-gray-700 link-underline">My Vacancies</a>
        <a href="#" class="block text-gray-700 link-underline">Favorites</a>

        <!-- Logout Button -->
        <div class="border-t mt-2 pt-2">
          <Quit />
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { ref } from 'vue';
import Quit from '@/components/Logout.vue';
import HeaderButtons from '@/components/HeaderButtons.vue';

// Manage the mobile menu open/close state
const isOpen = ref(false);

</script>

<style scoped>
.link-underline::before {
  content: "";
  position: absolute;
  width: 0;
  height: 3px;
  bottom: -2px;
  left: 0;
  background-color: black; /* Indigo color */
  visibility: hidden;
  transition: all 0.5s ease-in-out;
}

.link-underline:hover::before {
  visibility: visible;
  width: 100%;
}
</style>
