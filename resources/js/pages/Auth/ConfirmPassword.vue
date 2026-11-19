<script setup>
// Mengimpor layout pengunjung dan komponen formulir untuk konfirmasi kata sandi.
import GuestLayout from '@/Layouts/GuestLayout.vue';
// Mengimpor komponen untuk menampilkan error validasi.
import InputError from '@/Components/InputError.vue';
// Mengimpor label kolom formulir.
import InputLabel from '@/Components/InputLabel.vue';
// Mengimpor tombol aksi utama.
import PrimaryButton from '@/Components/PrimaryButton.vue';
// Mengimpor input teks yang dapat digunakan kembali.
import TextInput from '@/Components/TextInput.vue';
// Mengimpor metadata halaman dan helper formulir Inertia.
import { Head, useForm } from '@inertiajs/vue3';

// Menyimpan nilai kata sandi yang dimasukkan pengguna.
const form = useForm({
    password: '',
});

// Mengirim kata sandi untuk mengonfirmasi identitas pengguna.
const submit = () => {
    // Mengirim kata sandi ke route konfirmasi.
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <!-- Menampilkan formulir konfirmasi kata sandi. -->
    <GuestLayout>
        <Head title="Confirm Password" />

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 flex justify-end">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirm
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
