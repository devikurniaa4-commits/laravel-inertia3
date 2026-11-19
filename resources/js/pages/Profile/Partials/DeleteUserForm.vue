<script setup>
// Mengimpor tombol, pesan error, label, modal, dan input untuk konfirmasi hapus.
import DangerButton from '@/Components/DangerButton.vue';
// Mengimpor komponen pesan validasi.
import InputError from '@/Components/InputError.vue';
// Mengimpor label input kata sandi.
import InputLabel from '@/Components/InputLabel.vue';
// Mengimpor dialog konfirmasi penghapusan akun.
import Modal from '@/Components/Modal.vue';
// Mengimpor tombol pembatalan dialog.
import SecondaryButton from '@/Components/SecondaryButton.vue';
// Mengimpor input kata sandi konfirmasi.
import TextInput from '@/Components/TextInput.vue';
// Mengimpor helper formulir Inertia, nextTick, dan ref untuk state komponen.
import { useForm } from '@inertiajs/vue3';
// Mengimpor fungsi tick berikutnya dan ref reaktif dari Vue.
import { nextTick, ref } from 'vue';

// Mengontrol status dialog dan menyimpan referensi kolom kata sandi.
const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

// Menyiapkan kata sandi yang diminta sebelum penghapusan akun.
const form = useForm({
    password: '',
});

// Membuka dialog konfirmasi dan memfokuskan kolom kata sandi.
const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

// Mengirim permintaan penghapusan akun beserta kata sandi konfirmasi.
const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

// Menutup dialog serta membersihkan error dan data formulir.
const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <!-- Menampilkan aksi hapus akun dan dialog konfirmasi kata sandi. -->
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Delete Account
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Before deleting your account, please
                download any data or information that you wish to retain.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">Delete Account</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900"
                >
                    Are you sure you want to delete your account?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your account is deleted, all of its resources and data
                    will be permanently deleted. Please enter your password to
                    confirm you would like to permanently delete your account.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Password"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
