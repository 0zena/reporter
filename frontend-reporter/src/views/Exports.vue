<script setup lang="ts">
import Button from 'primevue/button';
import InputNumber from 'primevue/inputnumber';

import { ref } from 'vue';
import axios from 'axios';

const user_id = ref(1);

const downloadPDF = async () => {
    try {
        const response = await axios.get(`http://127.0.0.1:8000/api/export-user-pdf/${user_id.value}`, {
            responseType: 'blob',
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;

        link.setAttribute('download', `user_${user_id.value}_details.pdf`); // Use user_id.value here

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } catch (error) {
        console.error('Error downloading the PDF:', error);
    }
};
</script>

<template>
    <div id="wrapper" class="flex content-start flex-wrap">
        <InputNumber v-model="user_id" inputId="horizontal-buttons" :min="1" showButtons buttonLayout="horizontal" :step="1" class="w-[250px] m-[25px]">
            <template #incrementbuttonicon>
                <span class="pi pi-plus" />
            </template>
            <template #decrementbuttonicon>
                <span class="pi pi-minus" />
            </template>
        </InputNumber>

        <Button label="Get User" icon="pi pi-download" class="w-[125px] m-[25px]" @click="downloadPDF" />
    </div>
</template>
