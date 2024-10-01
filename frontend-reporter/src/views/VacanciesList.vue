<script setup lang="ts">
 import NavigationBar from '../components/navigationbar/NavBar.vue';
 
</script>

<template>

 
  <div class="w-full min-h-screen h-auto bg-zinc-500">
    <NavigationBar></NavigationBar>
     <div id="main" class="w-full h-auto flex flex-row-reverse">
      <div id="menu-placeholder" class="bg-zinc-400 w-[350px] h-auto"></div>

      <div id="listing-wrapper" class="w-full h-full flex flex-col justify-center items-center pt-[75px] pb-[50px]">
        <div id="listing-placeholder" class="w-3/5 h-[100px] bg-zinc-100 m-[25px] rounded-md"></div>
        <div id="listing-placeholder" class="w-3/5 h-[100px] bg-zinc-100 m-[25px] rounded-md"></div>
        <div id="listing-placeholder" class="w-3/5 h-[100px] bg-zinc-100 m-[25px] rounded-md"></div>
        <div id="listing-placeholder" class="w-3/5 h-[100px] bg-zinc-100 m-[25px] rounded-md"></div>
        <div id="listing-placeholder" class="w-3/5 h-[100px] bg-zinc-100 m-[25px] rounded-md"></div>
        <div id="listing-placeholder" class="w-3/5 h-[100px] bg-zinc-100 m-[25px] rounded-md"></div>
        <div id="listing-placeholder" class="w-3/5 h-[100px] bg-zinc-100 m-[25px] rounded-md"></div>
        <div id="listing-placeholder" class="w-3/5 h-[100px] bg-zinc-100 m-[25px] rounded-md"></div>
      </div>

    </div>
  </div>
</template>
