<script setup>
// Mengimpor layout halaman dan komponen navigasi Inertia.
import Layout from '../../Layouts/App.vue'
// Mengimpor tautan untuk membuka halaman edit dan router untuk menghapus post.
import { Link, router } from '@inertiajs/vue3'

// Menerima daftar post yang disediakan oleh controller.
defineProps({
    posts: Array
});

// Meminta konfirmasi lalu mengirim permintaan penghapusan post.
function deletePost(id) {     
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        // Menghapus post yang dipilih melalui router Inertia.
        router.delete(`/posts/${id}`)
    }
}
</script>

<template>
    <!-- Menampilkan daftar post beserta aksi tambah, edit, dan hapus. -->
    <Layout>
        <div>
            <!-- Flash Message -->
            <div v-if="$page.props.flash?.message" class="alert alert-success mb-4" role="alert">
                {{ $page.props.flash.message }}
            </div>

            <!-- Tombol Tambah Data -->
            <div class="mb-4">
                <Link href="/posts/create" class="btn text-white fw-semibold px-3 py-2" style="background-color: #0d6efd; font-size: 14px;">
                    TAMBAH DATA
                </Link>
            </div>

            <!-- Card & Tabel Data -->
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-4">
                    <table class="table table-borderless align-middle mb-0">
                        <thead>
                            <tr class="border-bottom" style="font-size: 13px;">
                                <th scope="col" class="pb-3 fw-bold">TITLE</th>
                                <th scope="col" class="pb-3 fw-bold">CONTENT</th>
                                <th scope="col" class="pb-3 fw-bold text-end">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in posts" :key="post.id" class="border-bottom" style="font-size: 14px;">
                                <td class="py-3">{{ post.title }}</td>
                                <td class="py-3">{{ post.content }}</td>
                                <td class="py-3 text-end">
                                    <Link :href="`/posts/${post.id}/edit`" class="btn btn-sm text-white px-3 me-1" style="background-color: #0d6efd; font-size: 12px; font-weight: 600;">
                                        EDIT
                                    </Link>
                                    <button @click.prevent="deletePost(post.id)" class="btn btn-sm text-white px-3" style="background-color: #dc3545; font-size: 12px; font-weight: 600;">
                                        DELETE
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>a