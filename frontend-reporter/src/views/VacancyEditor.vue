<script setup> 
import NavigationBar from '../components/navigationbar/NavBar.vue';
import Editor from 'primevue/editor';
import InputText from 'primevue/inputtext';
import Skeleton from 'primevue/skeleton';
import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const title = ref('');
const description = ref('');
const category = ref('');
const src = ref(null);
const file = ref<File | null>(null);
const errorMessage = ref('');
const successMessage = ref('');

const router = useRouter();

function onFileSelect(event) {
    file.value = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        src.value = e.target.result;
    };

    reader.readAsDataURL(file.value);
}

async function submitVacancy() {
    if (!title.value || !description.value || !category.value) {
        errorMessage.value = "All fields are required.";
        return;
    }

    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('description', description.value);
    formData.append('category', category.value);

    if (file.value) {
        formData.append('vacancy_image', file.value);
    }

    try {
        const response = await fetch('http://localhost:8000/api/vacancies', {
            method: 'POST',
            body: formData,
            credentials: 'include',
        });

        if (response.ok) {
            successMessage.value = "Vacancy created successfully!";
            setTimeout(() => {
                router.push('/vacancies');
            }, 2000);
        } else {
            errorMessage.value = "Failed to create vacancy. Please try again.";
        }
    } catch (error) {
        errorMessage.value = "An error occurred. Please try again later.";
    }
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
    
            <InputText v-model="title" type="text" size="large" class="w-[750px] my-5 block" placeholder="Title" />
            <InputText v-model="category" type="text" size="large" class="w-[750px] my-5" placeholder="Category" />
    
            <Editor v-model="description" editorStyle="height: 320px" class="my-5 w-[850px]">
                <template v-slot:toolbar>
                    <span class="ql-formats">
                        <select class="ql-header">
                            <option value="1"></option>
                            <option value="2"></option>
                            <option selected></option>
                        </select>

                        <button v-tooltip.bottom="'Bold'" class="ql-bold"></button>
                        <button v-tooltip.bottom="'Italic'" class="ql-italic"></button>
                        <button v-tooltip.bottom="'Underline'" class="ql-underline"></button>
                    </span>

                    <span class="ql-formats">
                        <button v-tooltip.bottom="'Numbered List'" class="ql-list" value="ordered"></button>
                        <button v-tooltip.bottom="'Bulleted List'" class="ql-list" value="bullet"></button>

                        <select class="ql-align">
                            <option selected></option>
                            <option value="center"></option>
                            <option value="right"></option>
                            <option value="justify"></option>
                        </select>
                    </span>
                </template>
            </Editor>

            <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
            <p v-if="successMessage" class="text-green-500">{{ successMessage }}</p>
    
            <div id="save-wrapper" class="flex justify-end">
                <Button label="Save" icon="pi pi-check" class="mr-2" @click="submitVacancy" />
                <Button label="Cancel" icon="pi pi-times" />
            </div>
        </div>
  
      </div>
    </div>
</template>

<style>
/* Salabo bulleted lists rādās kā numbered list (bugs no primevue puses) */
.ql-editor ol li[data-list="bullet"]::before {
    content: '\2022';
}
</style>