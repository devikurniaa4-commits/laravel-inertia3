// Menyiapkan Axios sebagai klien HTTP global untuk aplikasi.
// Mengimpor Axios untuk melakukan permintaan HTTP.
import axios from 'axios';

// Menyediakan Axios pada window agar dapat digunakan di seluruh aplikasi.
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
