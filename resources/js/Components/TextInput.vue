<!-- Menyediakan input teks yang dapat menerima fokus awal. -->
<script setup>
// Mengimpor hook lifecycle dan ref untuk mengelola elemen input.
import { onMounted, ref } from 'vue';

// Menghubungkan nilai input dengan model v-model milik parent.
const model = defineModel({
    type: String,
    required: true,
});

// Menyimpan referensi ke elemen input agar dapat difokuskan.
const input = ref(null);

// Memeriksa atribut autofocus setelah komponen terpasang.
onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        // Memindahkan fokus ke input bila autofocus diaktifkan.
        input.value.focus();
    }
});

// Membuka metode focus agar dapat dipanggil oleh komponen parent.
defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <!-- Menampilkan input teks yang terhubung ke model dan referensi elemen. -->
    <input
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        v-model="model"
        ref="input"
    />
</template>
