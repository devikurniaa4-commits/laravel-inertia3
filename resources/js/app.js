// Menyiapkan aplikasi Vue dan Inertia serta memuat halaman berdasarkan nama komponennya.
// Memuat stylesheet utama dan konfigurasi awal Axios.
import '../css/app.css';
// Menjalankan konfigurasi awal klien HTTP.
import './bootstrap';

// Mengimpor integrasi Inertia, resolver halaman Vite, Vue, dan dukungan route Ziggy.
import { createInertiaApp } from '@inertiajs/vue3';
// Mengimpor helper untuk menyelesaikan nama halaman ke file komponen.
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
// Mengimpor pembuat aplikasi Vue dan fungsi render.
import { createApp, h } from 'vue';
// Mengimpor plugin agar route Laravel dapat digunakan dari Vue.
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Mengambil nama aplikasi dari environment dengan nilai cadangan.
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Membuat aplikasi Inertia dengan pengaturan judul, resolusi halaman, dan progress.
createInertiaApp({
    // Menambahkan nama aplikasi pada judul setiap halaman.
    title: (title) => `${title} - ${appName}`,
    // Mencari file komponen Vue berdasarkan nama halaman dari server.
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    // Membuat instance Vue, memasang plugin, lalu menautkannya ke elemen halaman.
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    // Mengatur warna indikator pemuatan halaman Inertia.
    progress: {
        color: '#4B5563',
    },
});
