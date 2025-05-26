<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    categories: Object,
});
</script>

<template>
    <Head title="Categories Details" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                    Brands Details
                </h2>
                <Link
                    :href="route('categories.index')"
                    class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600"
                >
                    Back to Brands
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
                                        {{ categories.slug }}
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
                                        {{ categories.category_name }}
                                    </p>
                                </div>

                                <div style="width: 150px">
                                    <p
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >
                                        Imagen
                                    </p>
                                    <div
                                    
                                        v-if="categories.main_image"
                                        class="rounded-lg overflow-hidden mb-4 aspect-square"
                                    >
                                        <img
                                            :src="
                                                '/storage/' +
                                                categories.main_image
                                            "
                                            :alt="categories.category_name"
                                            class="w-full h-full object-cover"
                                            loading="lazy"
                                        />
                                    </div>
                                    <div
                                        v-else
                                        class="bg-gray-200 dark:bg-gray-700 rounded-lg aspect-square flex items-center justify-center mb-4"
                                    >
                                        <span
                                            class="text-gray-500 dark:text-gray-400"
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
