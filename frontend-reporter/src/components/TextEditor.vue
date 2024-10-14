<template>
  <Editor v-model="content" editorStyle="height: 320px">
    <template v-slot:toolbar>
        <span class="ql-formats">
            <select v-tooltip.bottom="'Header'" class="ql-header" />
        </span>
        <span class="ql-formats">
            <button v-tooltip.bottom="'Bold'" class="ql-bold" />
            <button v-tooltip.bottom="'Italic'" class="ql-italic" />
            <button v-tooltip.bottom="'Underline'" class="ql-underline" />
        </span>
        <span class="ql-formats">
            <button class="ql-list" value="ordered" />
        </span>
        <span class="ql-formats">
            <button v-tooltip.bottom="'Link'" class="ql-link" />
        </span>
    </template>
  </Editor>
</template>

<script setup lang="ts">
import { ref, defineProps, watch } from 'vue';
import Editor from 'primevue/editor';

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  }
});

const emit = defineEmits(['update:modelValue']);
const content = ref(props.modelValue);

watch(content, (newValue) => {
  emit('update:modelValue', newValue);
});
</script>
