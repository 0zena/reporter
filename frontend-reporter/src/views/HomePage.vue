<script setup>
import NavBar from "@/components/navigationbar/NavBar.vue";
</script>

<template>
  <NavBar />
  <div class="bg-white">
    <div class="relative isolate px-6 pt-14 lg:px-8">
      <div class="mx-auto max-w-2xl py-32 text-center sm:py-48 lg:py-56 ">
        <h1 class="text-heading-1 font-heading tracking-tight text-gray-900">
          Find Your Dream Job with Reporter
        </h1>
        <p class="mt-6 text-lg leading-8 text-gray-600">
          Search through a variety of job listings across different categories.
        </p>
        <div class="flex gap-4 mt-4 w-full justify-center">
          <router-link class="p-button" to="/login">
            Get Started
          </router-link>
          <span class="text-xl">or</span>
          <router-link class="p-button" to="/user-guide">
            User Manual
          </router-link>
        </div>
      </div>
    </div>
  </div>

  <section class="mx-auto my-16 flex flex-col lg:flex-row items-center justify-between max-w-7xl px-6">
    <div class="w-full mb-8 lg:w-1/2 lg:pr-8 lg:mb-0">
      <h1 class="text-3xl font-bold mb-4">Efficient Way to Get a Job!</h1>
      <p class="text-lg">
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


  <section class="mx-auto my-16 flex flex-col-reverse items-center justify-between max-w-7xl px-6 mb-40 lg:flex-row">
    <div class="w-full mt-8 lg:w-1/2 lg:pr-8 lg:mt-0">
      <img
        src="@/assets/overview1.jpg"
        alt="Advanced search options"
        class="w-full rounded-xl shadow-xl ring-1 ring-gray-400/10"
      />
    </div>
    <div class="w-full lg:w-1/2 lg:pl-8">
      <h1 class="text-3xl font-bold mb-4">Advanced Search</h1>
      <p class="text-lg">
        Filter through job listings with advanced search options to find exactly what you're looking for. 
        Favorite your vacancies to keep them organized, and keep yourself updated with the latest vacancies!
      </p>
    </div>
  </section>
</template>
