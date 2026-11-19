<!-- Menyediakan checkbox yang nilainya tersinkron dengan komponen induk. -->
<script setup>
// Mengimpor computed untuk menyelaraskan nilai checkbox dengan parent.
import { computed } from 'vue';

// Mendeklarasikan event pembaruan nilai yang dikirim ke parent.
const emit = defineEmits(['update:checked']);

// Menerima nilai checkbox dan nilai yang diwakilinya dari parent.
const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
});

// Menyediakan getter dan setter agar v-model meneruskan perubahan ke parent.
const proxyChecked = computed({
    get() {
        // Membaca nilai checkbox saat ini dari properti parent.
        return props.checked;
    },

    set(val) {
        // Mengirim nilai baru melalui event update:checked.
        emit('update:checked', val);
    },
});
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
    />
</template>
