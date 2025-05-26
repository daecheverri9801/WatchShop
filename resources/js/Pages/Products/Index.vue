<script setup>
import { computed, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    products: Array,
    categories: Array,
    brands: Array,
    message: String,
});

const selectedCategory = ref("");
const selectedBrand = ref("");
const selectedGenre = ref("");
const showDeleteModal = ref(false);
const productToDelete = ref(null);

const filteredProducts = computed(() => {
    let filtered = props.products;

    if (selectedCategory.value) {
        filtered = filtered.filter(
            (product) => product.fk_category_id == selectedCategory.value
        );
    }

    if (selectedBrand.value) {
        filtered = filtered.filter(
            (product) => product.fk_brand_id == selectedBrand.value
        );
    }

    if (selectedGenre.value) {
        filtered = filtered.filter(
            (product) => product.genre == selectedGenre.value
        );
    }

    return filtered;
});

const createProductLink = computed(() => {
    const baseUrl = route("products.create");
    return selectedCategory.value
        ? `${baseUrl}?category_id=${selectedCategory.value}`
        : baseUrl;
});

function formatDate(dateString) {
    const date = new Date(dateString);
    return (
        date.toLocaleDateString() +
        " " +
        date.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })
    );
}

const confirmDelete = (product) => {
    productToDelete.value = product;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showDeleteModal.value = false;
};

const deleteForm = useForm({});

const deleteProduct = () => {
    deleteForm.delete(route("products.destroy", productToDelete.value.slug), {
        onSuccess: () => {
            showDeleteModal.value = false;
        },
    });
};

const getGenreText = (genre) => {
    switch (genre) {
        case "Male":
            return "Masculino";
        case "Female":
            return "Femenino";
        case "Unisex":
            return "Unisex";
        default:
            return genre;
    }
};
</script>

<template>
    <Head title="Products" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Products</h2>
                <Link
                    :href="route('products.create')"
                    class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600"
                >
                    Create Product
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    v-if="message"
                    class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative"
                    role="alert"
                >
                    <span class="block sm:inline">{{ message }}</span>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <div class="p-6">
                        <div
                            v-if="categories.length === 0"
                            class="text-center py-4 text-gray-600 dark:text-gray-400"
                        >
                            No hay Categories disponibles.
                        </div>
                        <div v-else class="overflow-x-auto">
                            <table
                                class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                            >
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            ID
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Categoria
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Nombre
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Slug
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Referencia
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Marca
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Genero
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Color
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Material
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Proteccion UV
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Resistencia al agua
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Tamaño
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Precio
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Imagen
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        >
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
                                >
                                    <tr
                                        v-for="product in products"
                                        :key="product.id"
                                    >
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{ product.id }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{
                                                product.category
                                                    ?.category_name ||
                                                "Sin categoría"
                                            }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{ product.product_name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{ product.slug }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{
                                                product.product_ref ||
                                                "Sin referencia"
                                            }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{
                                                product.brand?.brand_name ||
                                                "Sin marca"
                                            }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{ getGenreText(product.genre) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{
                                                product.color?.color_name ||
                                                "Sin color"
                                            }}
                                        </td>

                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{
                                                product.material
                                                    ?.material_name ||
                                                "Sin material"
                                            }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{
                                                product.uv_protection
                                                    ? "Sí"
                                                    : "No"
                                            }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{
                                                product.water_resistant
                                                    ? product.water_resistant
                                                    : "No Assigned"
                                            }}
                                            mm
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{
                                                product.size
                                                    ? product.size
                                                    : "No Assigned"
                                            }}
                                            mm
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                                        >
                                            {{
                                                product.price
                                                    ? $formatPrice(
                                                          product.price
                                                      )
                                                    : "No price assigned"
                                            }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div
                                                v-if="product.main_image"
                                                class="w-16 h-16 rounded-md overflow-hidden"
                                            >
                                                <img
                                                    :src="
                                                        product.main_image
                                                            ? `/storage/${product.main_image}`
                                                            : '/images/placeholder-product.png'
                                                    "
                                                    :alt="product.product_name"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                                />
                                            </div>
                                            <div
                                                v-else
                                                class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center"
                                            >
                                                <span
                                                    class="text-gray-500 text-xs"
                                                    >Sin imagen</span
                                                >
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                        >
                                            <Link
                                                :href="
                                                    route(
                                                        'products.show',
                                                        product.slug
                                                    )
                                                "
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
                                            >
                                                View
                                            </Link>
                                            <Link
                                                :href="
                                                    route(
                                                        'products.edit',
                                                        product.slug
                                                    )
                                                "
                                                class="text-blue-600 hover:text-blue-900"
                                            >
                                                Edit
                                            </Link>
                                            <button
                                                @click="confirmDelete(product)"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                            >
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

        <!-- Modal de confirmación de eliminación -->
        <Modal :show="showDeleteModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Eliminar producto?
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    ¿Estás seguro de que deseas eliminar "{{
                        productToDelete?.product_name
                    }}"? Esta acción no se puede deshacer.
                </p>
                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeModal"
                        >Cancelar</SecondaryButton
                    >
                    <DangerButton
                        :class="{ 'opacity-25': deleteForm.processing }"
                        :disabled="deleteForm.processing"
                        @click="deleteProduct"
                    >
                        Eliminar
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>

<style scoped>
.hover\:scale-105:hover {
    transform: scale(1.05);
}
</style>
