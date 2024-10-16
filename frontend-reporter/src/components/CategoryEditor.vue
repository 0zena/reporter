<script setup>
import Select from 'primevue/select';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import Button from 'primevue/button';

import { ref } from 'vue';

const category = ref('');
const speciality = ref('');
const selectedCategoryId = ref(null);
const categories = ref([]);

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

// Create a new category
const createCategory = async () => {
    try {
        const response = await fetch('http://localhost:8000/api/categories', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name: category.value }),
        });

        if (response.ok) {
            const newCategory = await response.json();
            categories.value.push(newCategory);
            category.value = '';
        } else {
            console.error('Error creating category:', await response.json());
        }
    } catch (error) {
        console.error('Error creating category:', error);
    }
};

const createSpeciality = async () => {
    try {
        const response = await fetch('http://localhost:8000/api/specialities', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                name: speciality.value,
                category_id: selectedCategoryId.value,
            }),
        });

        if (response.ok) {
            speciality.value = '';
        } else {
            console.error('Error creating speciality:', await response.json());
        }
    } catch (error) {
        console.error('Error creating speciality:', error);
    }
};

fetchCategories();
</script>

<template>
    <div id="main-wrapper" class="text-black mx-10 my-3 flex flex-col">
        <div id="category" class="flex flex-col my-3">
            <h2 class="font-bold">Create category:</h2>
            <div id="category-input">
                <InputText type="text" v-model="category" class="mr-2 w-[224px]" />
                <Button label="Save" icon="pi pi-check" iconPos="right" @click="createCategory" />
            </div>
        </div>

        <div id="speciality" class="flex flex-col max-w-[400px]">
            <h2 class="font-bold">Create speciality:</h2>
            <div id="speciality-input" class="my-2">
                <Select
                    v-model="selectedCategoryId"
                    :options="categories"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="Select a Category"
                    class="w-full md:w-56"
                />
                <InputText type="text" v-model="speciality" class="my-2 mr-2 w-[224px]" />
                <Button label="Save" icon="pi pi-check" iconPos="right" @click="createSpeciality" />
            </div>
        </div>
    </div>
</template>
