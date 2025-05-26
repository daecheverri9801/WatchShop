<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
    categories: Array,
    message: String,
});

const getImageUrl = (imagePath) => {
    // Verifica si la ruta ya contiene '/storage/'
    if (imagePath.includes('/storage/')) {
        return imagePath;
    }

    // Si es una ruta relativa, construye la URL completa
    const baseUrl = usePage().props.appUrl || window.location.origin;
    return `${baseUrl}/storage/${imagePath}`;
};

const handleImageError = (event) => {
    console.error('Error loading image:', event.target.src);
    event.target.src = 'https://via.placeholder.com/150?text=Imagen+no+disponible';
    event.target.onerror = null; // Previene bucles infinitos
};


const showDeleteModal = ref(false);
const categoryToDelete = ref(null);

const confirmDelete = (category) => {
    categoryToDelete.value = category;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showDeleteModal.value = false;
};

const deleteForm = useForm({});

const deletecategory = () => {
    deleteForm.delete(route('categories.destroy', categoryToDelete.value.slug), {
        onSuccess: () => {
            showDeleteModal.value = false;
        },
    });
};

</script>

<template>

    <Head title="Categories" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Categories</h2>
                <Link :href="route('categories.create')"
                    class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600">
                Create Categories
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="message"
                    class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ message }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="categories.length === 0" class="text-center py-4 text-gray-600 dark:text-gray-400">
                            No hay Categories disponibles.
                        </div>
                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Slug
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Image
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="category in categories" :key="category.id">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ category.id }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            <div class="font-medium text-gray-900">{{ category.category_name }}</div>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            <div class="font-medium text-gray-900">{{ category.slug }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div v-if="category.main_image"
                                                class="w-16 h-16 rounded-md overflow-hidden">
                                                <img :src="getImageUrl(category.main_image)" :alt="category.name"
                                                    class="w-full h-full object-cover" @error="handleImageError">
                                            </div>
                                            <div v-else
                                                class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">Sin imagen</span>
                                            </div>
                                        </td>


                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <Link :href="route('categories.show', category.slug)"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                            View
                                            </Link>
                                            <Link :href="route('categories.edit', category.slug)"
                                                class="text-blue-600 hover:text-blue-900">
                                            Edit
                                            </Link>
                                            <button @click="confirmDelete(category)"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="showDeleteModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Estás seguro de que deseas eliminar esta categoria?
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Esta acción no se puede deshacer.
                </p>
                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                    <DangerButton :class="{ 'opacity-25': deleteForm.processing }" :disabled="deleteForm.processing"
                        @click="deletecategory">
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>
