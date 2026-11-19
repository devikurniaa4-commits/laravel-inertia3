<!-- Menampilkan pesan validasi ketika suatu input memiliki error. -->
<script setup>
// Menerima teks error validasi dari komponen parent.
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <!-- Menampilkan pesan hanya ketika isinya tersedia. -->
    <div v-show="message">
        <p class="text-sm text-red-600">
            {{ message }}
        </p>
    </div>
</template>
