<script setup>
import Select from 'primevue/select';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';

const category = ref('');
const speciality = ref('');
const selectedCategoryId = ref(null);
const categories = ref([]);
const toast = useToast();

const isValidInput = (input) => {
    const regex = /^[A-Za-z]+(?: [A-Za-z]+)*$/;
    return regex.test(input) && input.length <= 30;
};

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

const categoryExists = async (categoryName) => {
    try {
        const response = await fetch(`http://localhost:8000/api/categories/check`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name: categoryName }),
        });
        if (response.ok) {
            const data = await response.json();
            return data.exists;
        }
    } catch (error) {
        console.error('Error checking category existence:', error);
    }
    return false;
};

const specialityExists = async (specialityName, categoryId) => {
    try {
        const response = await fetch(`http://localhost:8000/api/specialities/check`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name: specialityName, category_id: categoryId }),
        });
        if (response.ok) {
            const data = await response.json();
            return data.exists;
        }
    } catch (error) {
        console.error('Error checking speciality existence:', error);
    }
    return false;
};

const createCategory = async () => {
    if (!isValidInput(category.value)) {
        toast.add({ severity: 'error', summary: 'Invalid Input', detail: 'Category name must be alphabetic, max 30 chars, and only one space between words.', life: 3000 });
        return;
    }

    if (await categoryExists(category.value)) {
        toast.add({ severity: 'warn', summary: 'Category Exists', detail: 'This category already exists.', life: 3000 });
        return;
    }

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
            toast.add({ severity: 'success', summary: 'Success', detail: 'Category added successfully.', life: 3000 });
        } else {
            console.error('Error creating category:', await response.json());
        }
    } catch (error) {
        console.error('Error creating category:', error);
    }
};

const createSpeciality = async () => {
    if (!isValidInput(speciality.value)) {
        toast.add({ severity: 'error', summary: 'Invalid Input', detail: 'Speciality name must be alphabetic, max 30 chars, and only one space between words.', life: 3000 });
        return;
    }

    if (await specialityExists(speciality.value, selectedCategoryId.value)) {
        toast.add({ severity: 'warn', summary: 'Speciality Exists', detail: 'This speciality already exists in the selected category.', life: 3000 });
        return;
    }

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
            toast.add({ severity: 'success', summary: 'Success', detail: 'Speciality added successfully.', life: 3000 });
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
    <Toast />
    <div id="main-wrapper" class="text-black mx-10 my-3 flex">
        <div id="category" class="flex flex-col my-3 mr-10">
            <h2 class="font-bold">Create category:</h2>
            <div id="category-input" class="my-2">
                <InputText type="text" v-model="category" placeholder="Category Name" class="mr-2 w-[325px]" />
                <Button label="Add" icon="pi pi-check" iconPos="right" @click="createCategory" />
            </div>
            <p>Enter the name of the category then click add</p>
        </div>

        <div id="speciality" class="flex flex-col my-3 max-w-[450px]">
            <h2 class="font-bold">Create speciality:</h2>
            <div id="speciality-input" class="my-2">
                <Select
                    v-model="selectedCategoryId"
                    :options="categories"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="Select a Category"
                    class="w-[325px]"
                />
                <p v-if="!selectedCategoryId">To add a speciality first select category</p>
                <div v-if="selectedCategoryId">
                    <InputText type="text" v-model="speciality" placeholder="Speciality Name" class="mt-2 mr-2 w-[325px]" />
                    <Button label="Add" icon="pi pi-check" iconPos="right" @click="createSpeciality" />
                    <p>Enter the name of the speciality then click add</p>
                </div>
            </div>
        </div>
    </div>
</template>
