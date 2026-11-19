<!DOCTYPE html>
<!-- Menetapkan bahasa dokumen sesuai locale aplikasi. -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Mengatur encoding karakter dan skala tampilan perangkat. -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Mengisi judul halaman dari konfigurasi aplikasi. -->
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- FONTS -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- --- BARIS PENTING: PANGGIL BOOTSTRAP CSS DISINI --- -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- -------------------------------------------------- -->

        <!-- SCRIPTS & INERTIA HEAD -->
        <!-- Mendaftarkan helper route, aset frontend, dan metadata Inertia. -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    
    <!-- Beri style background abu-abu persis di gambar -->
    <body class="font-sans antialiased" style="background-color: #cccccc;">
        <!-- Menjadi tempat Inertia memasang halaman Vue. -->
        @inertia
    </body>
</html>