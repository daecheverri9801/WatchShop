<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";

const props = defineProps({
    product: Object,
});
</script>

<template>
    <Head title="Product Details" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                    Product Details
                </h2>
                <Link
                    :href="route('products.index')"
                    class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600"
                >
                    Back to Products
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <div class="p-6">
                        <div class="mb-6">
                            <h3
                                class="text-lg font-medium text-gray-900 dark:text-white"
                            >
                                Brand Information
                            </h3>

                            <div
                                class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4"
                            >
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Slug
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{ product.slug }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Category
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{
                                            product.fk_category_id.category_name
                                        }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Name
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{ product.product_name }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Genre
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{ product.genre }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Color
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{
                                            product.fk_color_id
                                                ? product.fk_color_id.color_name
                                                : "No color assigned"
                                        }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Material
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{
                                            product.fk_material_id
                                                ? product.fk_material_id
                                                      .material_name
                                                : "No material assigned"
                                        }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        UV Protection
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{
                                            product.uv_protection ? "Yes" : "No"
                                        }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Water Resistance
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{ product.water_resistance }} mm
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Size
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{
                                            product.size
                                                ? product.size
                                                : "No size assigned"
                                        }}
                                        mm
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Price
                                    </p>
                                    <p
                                        class="mt-1 text-sm text-gray-900 dark:text-white"
                                    >
                                        {{
                                            product.price
                                                ? $formatPrice(product.price)
                                                : "No price assigned"
                                        }}
                                        COP
                                    </p>
                                </div>

                                <div>
                                    <div
                                        v-if="product.main_image"
                                        class="rounded-lg overflow-hidden mb-4"
                                    >
                                        <img
                                            :src="
                                                '/storage/' + product.main_image
                                            "
                                            :alt="product.category_name"
                                            class="w-full h-auto max-h-96 object-cover"
                                        />
                                    </div>
                                    <div
                                        v-else
                                        class="bg-gray-200 rounded-lg h-64 flex items-center justify-center mb-4"
                                    >
                                        <span class="text-gray-500"
                                            >Sin imagen</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
