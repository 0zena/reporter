<script setup lang="ts">
import NavigationBar from '../components/navigationbar/NavBar.vue';

import Editor from 'primevue/editor';
import InputText from 'primevue/inputtext';
import Skeleton from 'primevue/skeleton';
import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';
import { ref, onMounted } from 'vue';

var title = ref();
var description = ref();

const src = ref(null);

function onFileSelect(event) {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        src.value = e.target.result;
    };

    reader.readAsDataURL(file);
}

</script>

<template>
  <div class="w-full min-h-screen h-auto bg-zinc-500">
    <NavigationBar />
    <div id="main" class="w-full h-auto flex flex-col justify-center items-center">

        <div id="editor-wrapper" class="mt-10">
            <div id="img-wrapper" class="flex items-end">
                <Skeleton v-if="!src" size="10rem"></Skeleton>
                <img v-if="src" :src="src" alt="Image" class="shadow-md rounded-xl w-full sm:w-64" />
                <FileUpload mode="basic" @select="onFileSelect" customUpload auto severity="secondary" class="p-button-outlined mx-2" accept="image/*"/>
            </div>

            <InputText v-model="title" type="text" size="large" class="w-[750px] my-5" placeholder="Title" />

            <Editor 
                v-model="description" 
                editorStyle="height: 320px" 
                class="my-5 w-[850px]" 
            />

            <div id="save-wrapper" class="flex justify-end">
                <Button label="Save" icon="pi pi-check" class="mr-2" />
                <Button label="Cancel" icon="pi pi-times" />
            </div>
            
        </div>

    </div>
  </div>
</template>
