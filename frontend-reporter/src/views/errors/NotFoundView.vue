<script setup lang="ts">
  import Button from 'primevue/button';
</script>

<template>
  <div class="flex flex-col items-center justify-center mt-[10%]">
    <img src="/src/assets/404.png" alt="Not found" />
    
    <h1 class="flex flex-col space-y-4 text-4xl items-center mb-4">Page not found</h1>
    
    <RouterLink to="/">
      <Button label="Go Back" icon="pi pi-angle-left" />
    </RouterLink>
  </div>
</template>
