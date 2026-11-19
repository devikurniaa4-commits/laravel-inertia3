<script setup>
// Mengimpor komponen untuk menampilkan input, label, error, dan tombol.
import InputError from '@/Components/InputError.vue';
// Mengimpor label untuk kolom kata sandi.
import InputLabel from '@/Components/InputLabel.vue';
// Mengimpor tombol utama untuk menyimpan perubahan.
import PrimaryButton from '@/Components/PrimaryButton.vue';
// Mengimpor komponen input kata sandi.
import TextInput from '@/Components/TextInput.vue';
// Mengimpor helper formulir Inertia dan ref untuk fokus input.
import { useForm } from '@inertiajs/vue3';
// Mengimpor ref untuk menyimpan referensi elemen input.
import { ref } from 'vue';

// Menyimpan referensi input kata sandi agar fokus dapat dipindahkan saat error.
const passwordInput = ref(null);
const currentPasswordInput = ref(null);

// Menyiapkan nilai awal kata sandi saat ini, kata sandi baru, dan konfirmasi.
const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

// Mengirim perubahan kata sandi dan memfokuskan kembali kolom yang bermasalah.
const updatePassword = () => {
    // Mengirim perubahan kata sandi tanpa mengubah posisi scroll.
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            // Mengosongkan dan memfokuskan kolom kata sandi baru jika validasinya gagal.
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            // Mengosongkan dan memfokuskan kata sandi saat ini jika tidak cocok.
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <!-- Menampilkan formulir perubahan kata sandi dan umpan baliknya. -->
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Update Password
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Ensure your account is using a long, random password to stay
                secure.
            </p>
        </header>

        <!-- Mengirim formulir saat pengguna menyimpan kata sandi baru. -->
        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <InputLabel for="current_password" value="Current Password" />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                />

                <InputError
                    :message="form.errors.current_password"
                    class="mt-2"
                />
            </div>

            <div>
                <InputLabel for="password" value="New Password" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2"
                />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
