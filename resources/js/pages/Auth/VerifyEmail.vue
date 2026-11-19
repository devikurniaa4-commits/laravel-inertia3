<script setup>
// Mengimpor computed untuk menghitung status tautan verifikasi.
import { computed } from 'vue';
// Mengimpor layout dan tombol yang digunakan halaman verifikasi.
import GuestLayout from '@/Layouts/GuestLayout.vue';
// Mengimpor tombol utama untuk mengirim ulang verifikasi.
import PrimaryButton from '@/Components/PrimaryButton.vue';
// Mengimpor metadata, tautan, dan helper formulir Inertia.
import { Head, Link, useForm } from '@inertiajs/vue3';

// Menerima status pengiriman tautan verifikasi dari server.
const props = defineProps({
    status: {
        type: String,
    },
});

// Membuat formulir kosong untuk permintaan kirim ulang verifikasi.
const form = useForm({});

// Meminta pengiriman ulang tautan verifikasi email.
const submit = () => {
    // Meminta server mengirim ulang email verifikasi.
    form.post(route('verification.send'));
};

// Menandai apakah tautan verifikasi baru saja berhasil dikirim.
const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <!-- Menampilkan informasi verifikasi dan aksi untuk mengirim ulang tautan. -->
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="mb-4 text-sm text-gray-600">
            Thanks for signing up! Before getting started, could you verify your
            email address by clicking on the link we just emailed to you? If you
            didn't receive the email, we will gladly send you another.
        </div>

        <div
            class="mb-4 text-sm font-medium text-green-600"
            v-if="verificationLinkSent"
        >
            A new verification link has been sent to the email address you
            provided during registration.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >Log Out</Link
                >
            </div>
        </form>
    </GuestLayout>
</template>
