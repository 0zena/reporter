<script setup lang="ts">
import { defineProps } from 'vue';

const props = defineProps<{
    image: string;
    title: string;
    category: string;
}>();

</script>

<template>
    <div id="listing" class="w-3/5 h-[100px] bg-zinc-100 m-[20px] rounded-md flex items-center cursor-pointer">
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
