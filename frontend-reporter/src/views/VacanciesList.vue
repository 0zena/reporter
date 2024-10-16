<script setup lang="ts">
import NavigationBar from '../components/navigationbar/NavBar.vue';
import VacancySmallListing from '@/components/VacancySmallListing.vue';

import Button from 'primevue/button';
import { useRouter } from 'vue-router';

const router = useRouter();

const goToEditor = () => {
  router.push('/editor');
};
</script>

<template>
  <div class="w-full min-h-screen h-auto bg-zinc-500">
    <NavigationBar></NavigationBar>
     <div id="main" class="w-full h-auto min-h-full flex flex-row-reverse">
      <div id="menu-placeholder" class="bg-zinc-400 w-[350px] h-auto min-h-full"></div>

      <Button icon="pi pi-plus" class="h-10 m-5" style="width: 3rem;" @click="goToEditor"/>

      <div id="listing-wrapper" class="w-full h-full flex flex-col justify-center items-center pt-[75px] pb-[50px]">
        <VacancySmallListing image="http://127.0.0.1:8000/storage/vacancy_images/prYCWmKFdRPFVsa015ow7xqoueNNLe0Pc9UWAcD5.jpg" title="InnovateX - Senior Full Stack Developer" category="IT - Programming" @click="console.log('test')"/>
      </div>

    </div>
  </div>
</template>
