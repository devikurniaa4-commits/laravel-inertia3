<script setup>
// Mengimpor Link untuk navigasi dan usePage untuk membaca data halaman Inertia.
import { Link, usePage } from '@inertiajs/vue3'

// Menyimpan konteks halaman yang dibagikan oleh server.
const page = usePage()
</script>

<template>
  <!-- Membungkus seluruh halaman dengan latar dan tipografi dasar aplikasi. -->
  <div style="background-color: #cccccc; min-height: 100vh; font-family: system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <!-- NAVBAR PERSIS GAMBAR -->
    <nav style="background-color: #212529; padding: 12px 24px;">
      <div class="d-flex justify-content-between align-items-center">
        
        <!-- Menampilkan identitas aplikasi dan tautan navigasi utama. -->
        <div class="d-flex align-items-center gap-4">
          <Link href="/" class="text-white text-decoration-none fw-bold fs-5" style="letter-spacing: 0.5px;">
            LARAVEL + VUE + INERTIA.JS
          </Link>
          <div class="d-flex gap-3 align-items-center" style="font-size: 14px;">
            <Link href="/" class="text-white text-decoration-none">POSTS</Link>
            <a href="#" class="text-secondary text-decoration-none">EBOOK</a>
            <a href="#" class="text-secondary text-decoration-none">TUTORIAL SET</a>
          </div>
        </div>

        <!-- Menyediakan pencarian serta tombol autentikasi pengguna. -->
        <div class="d-flex align-items-center gap-2">
          <!-- Menampilkan formulir pencarian pada navbar. -->
          <form @submit.prevent class="d-flex gap-2">
            <input 
              type="text" 
              class="form-control form-control-sm" 
              placeholder="Search" 
              style="width: 200px; background-color: #fff; border: 1px solid #ced4da;"
            >
            <button type="submit" class="btn btn-sm text-white px-3" style="background-color: #198754;">
              Search
            </button>
          </form>

          <!-- Menampilkan aksi login/daftar atau identitas dan logout. -->
          <div class="d-flex align-items-center ms-2 gap-2">
            <template v-if="!$page.props.auth?.user">
              <!-- Tautan autentikasi untuk pengunjung yang belum login. -->
              <Link href="/login" class="btn btn-sm text-white px-3" style="background-color: #0d6efd;">
                Log in
              </Link>
              <Link href="/register" class="btn btn-sm btn-outline-light px-3">
                Register
              </Link>
            </template>

            <template v-else>
              <!-- Nama akun dan tombol keluar untuk pengguna yang sudah login. -->
              <span class="text-white text-sm me-1">{{ $page.props.auth.user.name }}</span>
              <Link href="/logout" method="post" as="button" class="btn btn-sm text-white px-3" style="background-color: #dc3545;">
                Logout
              </Link>
            </template>
          </div>
        </div>

      </div>
    </nav>

    <!-- Menyediakan area konten utama untuk halaman yang dibungkus layout. -->
    <div style="max-width: 1000px; margin: 0 auto; padding: 40px 20px;">
      <slot />
    </div>
  </div>
</template>