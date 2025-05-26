<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    products: Array,
    categories: Array,
    brands: Array,
    canLogin: Boolean,    
    laravelVersion: String,
    phpVersion: String,
});

const selectedCategory = ref("");
const selectedBrand = ref("");
const selectedGenre = ref("");

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
    <Head title="Inicio" />

    <div class="bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen">
            <!-- Barra de navegación superior -->
            <nav class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <Link
                                :href="route('welcome')"
                                class="flex items-center"
                            >
                                <span
                                    class="ml-2 text-xl font-bold text-gray-800 dark:text-white"
                                    >WatchSop</span
                                >
                            </Link>
                        </div>

                        <div class="flex items-center space-x-4">
                            <Link
                                v-if="canLogin && !$page.props.auth.user"
                                :href="route('login')"
                                class="px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white"
                            >
                                Iniciar sesión
                            </Link>

                            

                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('products.index')"
                                class="px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white"
                            >
                                Panel
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Filtros de productos -->
            <div class="bg-white dark:bg-gray-800 py-4 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                >Categoría</label
                            >
                            <select
                                v-model="selectedCategory"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="">Todas las categorías</option>
                                <option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ category.category_name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                >Marca</label
                            >
                            <select
                                v-model="selectedBrand"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="">Todas las marcas</option>
                                <option
                                    v-for="brand in brands"
                                    :key="brand.id"
                                    :value="brand.id"
                                >
                                    {{ brand.brand_name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                >Género</label
                            >
                            <select
                                v-model="selectedGenre"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="">Todos</option>
                                <option value="Male">Masculino</option>
                                <option value="Female">Femenino</option>
                                <option value="Unisex">Unisex</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido principal - Listado de productos -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div
                    v-if="filteredProducts.length === 0"
                    class="text-center py-12"
                >
                    <p class="text-gray-500 text-lg dark:text-gray-400">
                        No se encontraron productos con los filtros
                        seleccionados.
                    </p>
                    <button
                        @click="
                            [
                                (selectedCategory = ''),
                                (selectedBrand = ''),
                                (selectedGenre = ''),
                            ]
                        "
                        class="mt-4 text-indigo-600 hover:text-indigo-800 font-medium dark:text-indigo-400 dark:hover:text-indigo-300"
                    >
                        Limpiar filtros
                    </button>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
                >
                    <div
                        v-for="product in filteredProducts"
                        :key="product.id"
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
                    >
                        <!-- Imagen del producto -->
                        <div class="relative h-48 overflow-hidden">
                            <img
                                :src="
                                    product.main_image
                                        ? `/storage/${product.main_image}`
                                        : '/images/placeholder-product.png'
                                "
                                :alt="product.product_name"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                            />
                            <div
                                class="absolute top-2 left-2 bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded dark:bg-indigo-900 dark:text-indigo-200"
                            >
                                {{
                                    product.category?.category_name ||
                                    "Sin categoría"
                                }}
                            </div>
                        </div>

                        <!-- Detalles del producto -->
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3
                                        class="font-bold text-gray-900 dark:text-white text-lg"
                                    >
                                        {{ product.product_name }}
                                    </h3>
                                    <p
                                        class="text-gray-500 dark:text-gray-400 text-sm"
                                    >
                                        {{
                                            product.product_ref ||
                                            "Sin referencia"
                                        }}
                                    </p>
                                    <p
                                        class="text-gray-500 dark:text-gray-400 text-sm"
                                    >
                                        {{
                                            product.brand?.brand_name ||
                                            "Sin marca"
                                        }}
                                    </p>
                                </div>
                                <span
                                    class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs px-2 py-1 rounded-full"
                                >
                                    {{ getGenreText(product.genre) }}
                                </span>
                            </div>

                            <div class="mt-4 flex justify-between items-center">
                                <span
                                    class="font-bold text-gray-900 dark:text-white text-xl"
                                >
                                    {{ $formatPrice(product.price) }}
                                </span>

                                <Link
                                    :href="route('products.show', product.slug)"
                                    class="px-3 py-1 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm"
                                >
                                    Ver detalles
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer
                class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-8"
            >
            </footer>
        </div>
    </div>
</template>

<style scoped>
.hover\:scale-105:hover {
    transform: scale(1.05);
}
</style>
