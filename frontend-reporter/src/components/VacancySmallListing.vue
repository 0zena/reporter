<script setup lang="ts">
import { defineProps } from 'vue';
import { useRouter } from 'vue-router';

const props = defineProps<{
  id: number;
  image?: string;
  title: string;
  category: string;
  speciality: string;
}>();

const router = useRouter();

const goToFullScreen = () => {
  router.push({
    name: 'vacancy-fullscreen',
    query: {
      id: props.id,
    },
  });
};
</script>

<template>
  <div id="listing" class="w-full 2xl:w-3/5 min-h-[100px] h-auto md:h-[100px] bg-zinc-100 m-[20px] rounded-md flex items-center cursor-pointer p-5" @click="goToFullScreen">
    <div v-if="props.image" class="mr-5 sm:mr-0">
      <img
        :src="props.image"
        alt="Vacancy Image"
        class="w-16 h-16 object-cover rounded mr-4"
      />
    </div>
    <div v-else class="p-2">

    </div>
    <div id="text-wrapper" class="text-black">
      <h1 id="title" class="text-2xl font-bold">{{ props.title }}</h1>
      <p id="category"><strong>Category: </strong>{{ props.category }}</p>
      <p id="speciality"><strong>Vacancy: </strong>{{ props.speciality }}</p>
    </div>
  </div>
</template>
