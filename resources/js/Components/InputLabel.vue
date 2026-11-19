<!-- Menyediakan label input dengan teks yang dapat diatur dari parent. -->
<script setup>
// Menerima teks label yang akan ditampilkan.
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <!-- Menampilkan teks dari properti atau isi slot jika tidak tersedia. -->
    <label class="block text-sm font-medium text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
