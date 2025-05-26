<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

const form = useForm({
    category_name: '',
    main_image: null,
});

const previewImage = ref(null)

const handleImageUpload = (event) => {
    const file = event.target.files[0];

    if (file) {
        // Validación básica del tipo de archivo
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            form.setError('main_image', 'Formato de imagen no válido');
            return;
        }

        // Asignar al formulario
        form.main_image = file;

        // Generar vista previa
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    if (!form.category_name.trim()) {
        form.setError('category_name', 'El nombre de categoría es requerido');
        return;
    }
    form.post(route('categories.store'), {
        forceFormData: true, // Importante para archivos
        preserveScroll: true,
        onSuccess: () => {
            console.log('success');
        }
    })
}
</script>

<template>

    <Head title="Create Categories" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Category</h2>
                <Link :href="route('categories.index')"
                    class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600">
                Back to Categories
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <div class="mb-4">
                                <InputLabel for="category_name" value="Category Name" class="dark:text-gray-300" />
                                <TextInput id="category_name" type="text" class="mt-1 block w-full"
                                    v-model="form.category_name" required autofocus />
                                <InputError class="mt-2" :message="form.errors.category_name" />
                            </div>

                            <div>
                                <div class="mb-6">
                                    <InputLabel for="main_image" value="Category Image" />
                                    <input id="main_image" type="file" class="mt-1 block w-full text-sm text-gray-500
             file:mr-4 file:py-2 file:px-4
             file:rounded-md file:border-0
             file:text-sm file:font-semibold
             file:bg-gray-100 file:text-gray-700
             hover:file:bg-gray-200" @change="handleImageUpload"
                                        accept="image/jpeg, image/png, image/jpg, image/gif, image/webp" />
                                    <InputError class="mt-2" :message="form.errors.main_image" />

                                    <!-- Vista previa -->
                                    <div v-if="previewImage" class="mt-4">
                                        <p class="text-sm text-gray-500 mb-2">Vista previa:</p>
                                        <img :src="previewImage" class="w-32 h-32 object-cover rounded-md border">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Create Category
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>