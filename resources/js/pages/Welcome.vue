<script setup>
// Mengimpor komponen tautan untuk navigasi tanpa memuat ulang halaman.
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="landing-container text-white d-flex flex-column justify-content-between min-vh-100">
    <!-- Menyediakan navbar dengan tautan ke halaman login dan pendaftaran. -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 px-4 shadow-sm border-bottom border-secondary">
      <div class="container-fluid">
        <Link href="/" class="navbar-brand fw-bold fs-4 tracking-wide text-uppercase">
          LARAVEL + VUE + INERTIA.JS
        </Link>
        
        <div class="d-flex align-items-center gap-3">
          <Link href="/login" class="btn btn-outline-light px-4 rounded-pill fw-semibold shadow-sm">
            Log in
          </Link>
          <Link href="/register" class="btn btn-primary px-4 rounded-pill fw-semibold shadow-sm">
            Register
          </Link>
        </div>
      </div>
    </nav>

    <!-- Memperkenalkan fungsi utama aplikasi dan ajakan untuk mulai menggunakannya. -->
    <main class="container text-center my-auto py-5">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <span class="badge bg-secondary px-3 py-2 rounded-pill text-uppercase mb-3 tracking-wider">
            Web Application Platform
          </span>
          <h1 class="display-3 fw-bold mb-4">
            Kelola Posts & Konten Kamu Lebih Cepat
          </h1>
          <p class="lead text-light opacity-75 mb-5 px-md-5">
            Platform modern berbasis Laravel, Vue 3, dan Inertia.js untuk mengelola postingan secara terstruktur, aman, dan efisien.
          </p>
          <div class="d-flex justify-content-center gap-3">
            <Link href="/login" class="btn btn-primary btn-lg px-5 rounded-pill fw-semibold shadow">
              Mulai Sekarang
            </Link>
            <Link href="/register" class="btn btn-outline-light btn-lg px-5 rounded-pill fw-semibold">
              Buat Akun
            </Link>
          </div>
        </div>
      </div>
    </main>

    <!-- Menampilkan informasi hak cipta di bagian bawah halaman. -->
    <footer class="text-center py-4 border-top border-secondary text-secondary small">
      <p class="mb-0">&copy; {{ new Date().getFullYear() }} Laravel + Vue + Inertia. All rights reserved.</p>
    </footer>
  </div>
</template>

<style scoped>
/* Mengatur latar gradasi khusus untuk halaman sambutan. */
.landing-container {
  background: linear-gradient(135deg, #121212 0%, #212529 100%);
}
/* Mengatur jarak antarhuruf pada elemen yang memakai kelas tracking. */
.tracking-wide {
  letter-spacing: 1px;
}
/* Memberi jarak huruf yang lebih lebar pada teks penanda halaman. */
.tracking-wider {
  letter-spacing: 1.5px;
}
</style>