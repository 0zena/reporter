<template>
  <NavBar></NavBar>
  <div class="bg-white">
    <div class="relative isolate px-6 pt-14 lg:px-8">
      <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56 text-center">
        <h1 class="text-balance text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
          Find Your Dream Job with Reporter
        </h1>
        <p class="mt-6 text-lg leading-8 text-gray-600">
          Search through a variety of job listings across different categories.
        </p>
        <div>
          <router-link class="p-button mt-10 flex items-center justify-center gap-x-6" to="/login">
            Get Started
          </router-link>
        </div>
      </div>
    </div>
  </div>


  <section class="mx-auto my-16 flex flex-col lg:flex-row items-center justify-between max-w-7xl px-6">
    <div class="w-full lg:w-1/2 lg:pr-8 mb-8 lg:mb-0">
      <h1 class="text-3xl font-bold text-white mb-4">Efficient Way to Get a Job!</h1>
      <p class="text-lg text-white">
        Discover your dream job with ease! Whether you're starting your career or looking to advance, 
        we provide tools to search through various listings, apply with ease, and get job alerts tailored 
        to your needs.
      </p>
    </div>
    <div class="w-full lg:w-1/2 lg:pl-8">
      <img
        src="@/assets/overview0.jpg"
        alt="Job listings screenshot"
        class="w-full rounded-xl shadow-xl ring-1 ring-gray-400/10"
      />
    </div>
  </section>


  <section class="mx-auto my-16 flex flex-col-reverse lg:flex-row items-center justify-between max-w-7xl px-6 mb-40">
    <div class="w-full lg:w-1/2 lg:pr-8 mt-8 lg:mt-0">
      <img
        src="@/assets/overview1.jpg"
        alt="Advanced search options"
        class="w-full rounded-xl shadow-xl ring-1 ring-gray-400/10"
      />
    </div>
    <div class="w-full lg:w-1/2 lg:pl-8">
      <h1 class="text-3xl font-bold text-white mb-4">Advanced Search</h1>
      <p class="text-lg text-white">
        Filter through job listings with advanced search options to find exactly what you're looking for. 
        Favorite your vacancies to keep them organized, and keep yourself updated with the latest vacancies!
      </p>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';
import NavBar from "@/components/navigationbar/NavBar.vue";

 

</script>