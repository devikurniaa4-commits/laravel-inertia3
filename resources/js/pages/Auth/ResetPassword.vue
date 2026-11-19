<script setup>
// Mengimpor layout dan komponen input untuk formulir reset kata sandi.
import GuestLayout from '@/Layouts/GuestLayout.vue';
// Mengimpor komponen pesan error validasi.
import InputError from '@/Components/InputError.vue';
// Mengimpor label untuk kolom kata sandi.
import InputLabel from '@/Components/InputLabel.vue';
// Mengimpor tombol untuk menyimpan kata sandi baru.
import PrimaryButton from '@/Components/PrimaryButton.vue';
// Mengimpor kolom kata sandi dan konfirmasi.
import TextInput from '@/Components/TextInput.vue';
// Mengimpor metadata halaman dan helper formulir Inertia.
import { Head, useForm } from '@inertiajs/vue3';

// Menerima email dan token reset yang dikirim dari server.
const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

// Menyiapkan token, email, kata sandi baru, dan konfirmasinya.
const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

// Mengirim token dan kata sandi baru untuk mengatur ulang akun.
const submit = () => {
    // Mengirim data reset ke route penyimpanan kata sandi baru.
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <!-- Menampilkan formulir pengaturan ulang kata sandi. -->
    <GuestLayout>
        <Head title="Reset Password" />

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

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
