<script setup>
// Mengimpor layout utama untuk membungkus formulir post.
import Layout from '../../Layouts/App.vue'
// Menerima pesan validasi yang dikirim kembali oleh controller.
defineProps({
    errors: Object
})
// Mengimpor reactive untuk mengikat nilai input formulir.
import { reactive } from 'vue'

// Mengimpor router Inertia untuk mengirim data ke server.
import { router } from '@inertiajs/vue3'
// Menyimpan judul dan isi post yang sedang dibuat.
const post = reactive({
    title: '',
    content: ''
})
// Mengirim data post baru untuk disimpan.
function storePost() {
    // Mengirim data formulir ke endpoint pembuatan post.
    router.post('/posts', post)
}
</script>
<template>
    <!-- Menampilkan formulir pembuatan post di dalam layout utama. -->
    <Layout>
        <div class="card border-0 rounded shadow">
            <div class="card-body">
                <h4>TAMBAH POST</h4>
                <hr>
                <!-- Menghubungkan input judul dan isi ke state formulir. -->
                <form @submit.prevent="storePost">
                    <div class="mb-3">
                        <label class="form-label">TITLE POST</label>
                        <input type="text" class="form-control" v-model="post.title" placeholder="Masukkan Title Post">
                        <div v-if="errors.title" class="mt-2 alert alert-danger">
                            {{ errors.title }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CONTENT</label>
                        <textarea class="form-control" rows="5" v-model="post.content"
                            placeholder="Masukkan Content Post"></textarea>
                        <div v-if="errors.content" class="mt-2 alert alert-danger">
                            {{ errors.content }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-md shadow-sm me-2">SIMPAN</button>
                        <button type="reset" class="btn btn-warning btn-md shadow-sm">RESET</button>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>
