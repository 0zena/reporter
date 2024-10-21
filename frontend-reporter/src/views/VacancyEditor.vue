<script setup>
import NavigationBar from '../components/navigationbar/NavBar.vue';
import Editor from 'primevue/editor';
import InputText from 'primevue/inputtext';
import Skeleton from 'primevue/skeleton';
import Select from 'primevue/select';
import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';

import { ref, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';

const title = ref('');
const description = ref('');
const category = ref('');
const speciality = ref(null);
const src = ref(null);
const file = ref(null);
const errorMessage = ref('');
const successMessage = ref('');
const selectedCategoryId = ref(null);
const categories = ref([]);
const specialities = ref([]);

const router = useRouter();

const fetchCategories = async () => {
    try {
        const response = await fetch('http://localhost:8000/api/categories');
        if (response.ok) {
            categories.value = await response.json();
        }
    } catch (error) {
        console.error('Error fetching categories:', error);
    }
};

const fetchSpecialities = async (categoryId) => {
    try {
        const response = await fetch(`http://localhost:8000/api/specialities/${categoryId}`);
        if (response.ok) {
            specialities.value = await response.json();
        } else {
            specialities.value = [];
        }
    } catch (error) {
        console.error('Error fetching specialities:', error);
        specialities.value = [];
    }
};

watch(selectedCategoryId, (newCategoryId) => {
    if (newCategoryId) {
        fetchSpecialities(newCategoryId);
    } else {
        specialities.value = [];
    }
});

function onFileSelect(event) {
    file.value = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        src.value = e.target.result;
    };

    reader.readAsDataURL(file.value);
}

async function submitVacancy() {
    if (!title.value || !description.value || !selectedCategoryId.value) {
        errorMessage.value = "All fields are required.";
        return;
    }

    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('description', description.value);
    formData.append('category_id', selectedCategoryId.value);
    formData.append('speciality_id', speciality.value);

    if (file.value) {
        formData.append('vacancy_image', file.value);
    }

    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
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

onMounted(() => {
  fetchCategories();
});
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

            <div class="flex flex-col w-[750px] my-5">
                <Select
                    v-model="selectedCategoryId"
                    :options="categories"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="Select a Category"
                    class="mb-5"
                />
    
                <Select
                    v-model="speciality"
                    :options="specialities"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="Select a Speciality"
                    :disabled="!selectedCategoryId"
                />
            </div>
    
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