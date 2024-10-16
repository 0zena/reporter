<script setup lang="ts">
import { defineProps } from 'vue';
import { useRouter } from 'vue-router';

const props = defineProps<{
  id: number;
  image: string;
  title: string;
  category: string;
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
  <div id="listing" class="w-3/5 h-[100px] bg-zinc-100 m-[20px] rounded-md flex items-center cursor-pointer" @click="goToFullScreen">
    <img
      :src="props.image"
      alt="Vacancy Image"
      class="w-16 h-16 object-cover rounded mx-4"
    />
    <div id="text-wrapper" class="text-black">
      <h1 id="title" class="text-2xl font-bold">{{ props.title }}</h1>
      <p id="category">{{ props.category }}</p>
    </div>
  </div>
</template>
