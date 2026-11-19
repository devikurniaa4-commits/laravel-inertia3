<!-- Menyediakan tautan navigasi dengan tampilan sesuai status aktifnya. -->
<script setup>
// Mengimpor computed untuk menghitung kelas dan Link untuk navigasi Inertia.
import { computed } from 'vue';
// Mengimpor komponen tautan Inertia.
import { Link } from '@inertiajs/vue3';

// Menerima tujuan tautan dan status apakah tautan sedang aktif.
const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

// Memilih gaya visual berdasarkan status aktif tautan.
const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out',
);
</script>

<template>
    <!-- Menampilkan tautan navigasi dengan kelas yang telah dihitung. -->
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
