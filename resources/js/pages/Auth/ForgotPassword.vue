<script setup>
// Mengimpor layout dan komponen input untuk permintaan reset kata sandi.
import GuestLayout from '@/Layouts/GuestLayout.vue';
// Mengimpor komponen pesan error validasi.
import InputError from '@/Components/InputError.vue';
// Mengimpor label untuk kolom email.
import InputLabel from '@/Components/InputLabel.vue';
// Mengimpor tombol untuk mengirim permintaan reset.
import PrimaryButton from '@/Components/PrimaryButton.vue';
// Mengimpor kolom untuk memasukkan alamat email.
import TextInput from '@/Components/TextInput.vue';
// Mengimpor metadata halaman dan helper formulir Inertia.
import { Head, useForm } from '@inertiajs/vue3';

// Menerima status hasil pengiriman tautan reset dari server.
defineProps({
    status: {
        type: String,
    },
});

// Menyiapkan alamat email yang akan menerima tautan reset.
const form = useForm({
    email: '',
});

// Meminta tautan untuk mengatur ulang kata sandi melalui email.
const submit = () => {
    // Mengirim permintaan tautan reset ke server.
    form.post(route('password.email'));
};
</script>

<template>
    <!-- Menampilkan halaman permintaan reset kata sandi. -->
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
