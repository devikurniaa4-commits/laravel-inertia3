<!-- Menyediakan tautan navigasi yang dapat digunakan di dalam dropdown. -->
<script setup>
// Mengimpor komponen Link untuk navigasi tanpa memuat ulang halaman.
import { Link } from '@inertiajs/vue3';

// Menerima alamat tujuan tautan dari komponen parent.
defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <!-- Membuat tautan dropdown dan menampilkan isi dari slot parent. -->
    <Link
        :href="href"
        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
    >
        <slot />
    </Link>
</template>
