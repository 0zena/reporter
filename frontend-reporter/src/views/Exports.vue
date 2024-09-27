<script setup lang="ts">
import Button from 'primevue/button';

import { ref } from 'vue';
import axios from 'axios';

const downloadPDF = async () => {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/export-user-pdf/1', {
            responseType: 'blob',
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;

        link.setAttribute('download', 'user_1_details.pdf');

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
        <Button label="Get User" icon="pi pi-download" class="w-[125px] m-[25px]" @click="downloadPDF" />
    </div>
</template>