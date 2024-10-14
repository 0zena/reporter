<script setup lang="ts">
import TextEditor from "@/components/TextEditor.vue";
import { ref } from 'vue';

const richText = ref('');
</script>

<template>
  <TextEditor v-model="richText" />
</template>