<script setup>
import { ref, computed } from 'vue';
import { useForm, Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    categories: Object,
});

const previewImage = ref(null);
const showRemoveConfirmation = ref(false);

const form = useForm({
    category_name: props.categories.category_name,
    main_image: null, // No asignar la imagen existente aquí
    _method: 'PUT' // Necesario para las actualizaciones con formularios HTML
});

const currentImageUrl = computed(() => {
    if (!props.categories.main_image) return null;
    return props.categories.main_image.includes('/storage/')
        ? props.categories.main_image
        : `/storage/${props.categories.main_image}`;
});

const handleImageUpload = (category) => {
    const file = category.target.files[0];
    if (!file) return;

    // Validar tipo de archivo
    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        form.setError('main_image', 'Formato de imagen no válido');
        return;
    }

    // Validar tamaño (2MB máximo)
    if (file.size > 2048 * 1024) {
        form.setError('main_image', 'La imagen no debe superar los 2MB');
        return;
    }

    form.clearErrors('main_image');
    form.main_image = file;

    // Generar vista previa
    const reader = new FileReader();
    reader.onload = (e) => previewImage.value = e.target.result;
    reader.readAsDataURL(file);
};

const submit = () => {
    form.post(route('categories.update', props.categories.slug), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            previewImage.value = null;
        }
    });
};
</script>

<template>

    <Head title="Edit Category" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Category</h2>
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
                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <InputLabel for="category_name" value="Category Name" />
                                <TextInput id="category_name" type="text" class="mt-1 block w-full"
                                    v-model="form.category_name" required autofocus />
                                <InputError class="mt-2" :message="form.errors.category_name" />
                            </div>

                            <div class="mb-6">
                                <InputLabel value="Current Image" />
                                <div v-if="currentImageUrl" class="mt-2 flex items-center space-x-4">
                                    <img :src="currentImageUrl" :alt="`Current ${categories.category_name} image`"
                                        class="w-32 h-32 object-cover rounded-md border border-gray-200" />
                                    <div class="text-sm text-gray-500 dark:text-gray-400 break-all">
                                        <p>Current image path:</p>
                                        <p class="mt-1 text-xs">{{ categories.main_image }}</p>
                                    </div>
                                </div>
                                <div v-else class="mt-2 text-sm text-gray-500">
                                    No image currently set
                                </div>
                            </div>

                            <div class="mb-6">
                                <InputLabel for="main_image" value="New Image (optional)" />
                                <input id="main_image" type="file" class="mt-1 block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-gray-100 file:text-gray-700
                                        hover:file:bg-gray-200
                                        dark:file:bg-gray-700 dark:file:text-gray-300" @change="handleImageUpload"
                                    accept="image/jpeg, image/png, image/jpg, image/gif, image/webp" />
                                <InputError class="mt-2" :message="form.errors.main_image" />
                            </div>

                            <div v-if="previewImage" class="mb-6">
                                <InputLabel value="New Image Preview" />
                                <img :src="previewImage" alt="New image preview"
                                    class="mt-2 w-32 h-32 object-cover rounded-md border border-gray-200" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Update Category
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>