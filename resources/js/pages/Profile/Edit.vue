<!-- Menampilkan halaman pengaturan profil dan formulir terkait. -->
<script setup>
// Mengimpor layout pengguna terautentikasi dan bagian formulir profil.
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// Mengimpor formulir penghapusan akun.
import DeleteUserForm from './Partials/DeleteUserForm.vue';
// Mengimpor formulir pembaruan kata sandi.
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
// Mengimpor formulir pembaruan informasi profil.
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
// Mengimpor komponen untuk mengatur judul halaman melalui Inertia.
import { Head } from '@inertiajs/vue3';

// Menerima status verifikasi email dan status notifikasi dari server.
defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <!-- Menetapkan judul halaman dan membungkus konten dengan layout autentikasi. -->
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Profile
            </h2>
        </template>

        <div class="py-12">
            <!-- Menyusun formulir informasi, kata sandi, dan penghapusan akun. -->
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
