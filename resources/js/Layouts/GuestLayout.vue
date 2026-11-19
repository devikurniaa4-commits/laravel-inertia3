<!-- Mengatur tata letak halaman yang dapat diakses tanpa login. -->
<script setup>
// Mengimpor logo aplikasi dan tautan untuk navigasi Inertia.
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
// Mengimpor komponen tautan Inertia.
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <!-- Menyusun konten halaman pengunjung di tengah layar. -->
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <!-- Mengarahkan logo ke halaman utama. -->
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
            </Link>
        </div>

        <!-- Menyediakan slot untuk isi halaman seperti formulir login atau daftar. -->
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
