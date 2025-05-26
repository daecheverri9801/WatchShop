<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { ref, computed } from "vue";

const props = defineProps({
    product: Object,
    categories: Array,
    brands: Array,
    colors: Array,
    materials: Array,
});

const form = useForm({
    fk_category_id: props.product.fk_category_id,
    product_name: props.product.product_name,
    product_ref: props.product.product_ref,
    fk_brand_id: props.product.fk_brand_id,
    genre: props.product.genre,
    fk_color_id: props.product.fk_color_id,
    fk_material_id: props.product.fk_material_id,
    uv_protection: false,
    water_resistance: props.product.water_resistance,
    size: props.product.size,
    price: props.product.price,
    main_image: null, // No asignar la imagen existente aquí
    _method: "PUT",
});

const previewImage = ref(null);
const showRemoveConfirmation = ref(false);

const currentImageUrl = computed(() => {
    if (!props.product.main_image) return null;
    return props.product.main_image.includes("/storage/")
        ? props.product.main_image
        : `/storage/${props.product.main_image}`;
});

const handleImageUpload = (product) => {
    const file = product.target.files[0];
    if (!file) return;

    // Validar tipo de archivo
    const validTypes = [
        "image/jpeg",
        "image/png",
        "image/jpg",
        "image/gif",
        "image/webp",
    ];
    if (!validTypes.includes(file.type)) {
        form.setError("main_image", "Formato de imagen no válido");
        return;
    }

    // Validar tamaño (2MB máximo)
    if (file.size > 2048 * 1024) {
        form.setError("main_image", "La imagen no debe superar los 2MB");
        return;
    }

    form.clearErrors("main_image");
    form.main_image = file;

    // Generar vista previa
    const reader = new FileReader();
    reader.onload = (e) => (previewImage.value = e.target.result);
    reader.readAsDataURL(file);
};

const submit = () => {
    form.post(route("products.update", props.product.slug), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            previewImage.value = null;
        },
    });
};
</script>

<template>
    <Head title="Edit Product" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Edit Product</h2>
                <Link
                    :href="route('products.index')"
                    class="text-indigo-600 hover:text-indigo-800"
                >
                    Back to Products
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <form
                        @submit.prevent="submit"
                        class="space-y-6"
                        enctype="multipart/form-data"
                    >
                        <!-- Información básica -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel
                                    for="product_name"
                                    value="Product Name"
                                />
                                <TextInput
                                    id="product_name"
                                    v-model="form.product_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.product_name"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="product_ref"
                                    value="Product Ref"
                                />
                                <TextInput
                                    id="product_ref"
                                    v-model="form.product_ref"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.product_ref"
                                />
                            </div>
                        </div>

                        <!-- Categoría y Marca -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel
                                    for="fk_category_id"
                                    value="Category"
                                />
                                <SelectInput
                                    id="fk_category_id"
                                    v-model="form.fk_category_id"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                >
                                    <option value="">Select a Category</option>
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.category_name }}
                                    </option>
                                </SelectInput>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.fk_category_id"
                                />
                            </div>

                            <div>
                                <InputLabel for="fk_brand_id" value="Brand" />
                                <SelectInput
                                    id="fk_brand_id"
                                    v-model="form.fk_brand_id"
                                    class="mt-1 block w-full"
                                    required
                                >
                                    <option value="">Select a Brand</option>
                                    <option
                                        v-for="brand in brands"
                                        :key="brand.id"
                                        :value="brand.id"
                                    >
                                        {{ brand.brand_name }}
                                    </option>
                                </SelectInput>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.fk_brand_id"
                                />
                            </div>
                        </div>

                        <!-- Especificaciones -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <InputLabel for="genre" value="Género" />
                                <SelectInput
                                    id="genre"
                                    v-model="form.genre"
                                    class="mt-1 block w-full"
                                    required
                                >
                                    <option value="Male">Masculino</option>
                                    <option value="Female">Femenino</option>
                                    <option value="Unisex">Unisex</option>
                                </SelectInput>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.genre"
                                />
                            </div>

                            <div>
                                <InputLabel for="fk_color_id" value="Color" />
                                <SelectInput
                                    id="fk_color_id"
                                    v-model="form.fk_color_id"
                                    class="mt-1 block w-full"
                                >
                                    <option value="">Select a Color</option>
                                    <option
                                        v-for="color in colors"
                                        :key="color.id"
                                        :value="color.id"
                                    >
                                        {{ color.color_name }}
                                    </option>
                                </SelectInput>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.fk_color_id"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="fk_material_id"
                                    value="Material"
                                />
                                <SelectInput
                                    id="fk_material_id"
                                    v-model="form.fk_material_id"
                                    class="mt-1 block w-full"
                                >
                                    <option value="">Select a Material</option>
                                    <option
                                        v-for="material in materials"
                                        :key="material.id"
                                        :value="material.id"
                                    >
                                        {{ material.material_name }}
                                    </option>
                                </SelectInput>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.fk_material_id"
                                />
                            </div>
                        </div>

                        <!-- Características técnicas -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <InputLabel for="price" value="Precio ($)" />
                                <TextInput
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.price"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="water_resistance"
                                    value="Resistencia al agua (ATM)"
                                />
                                <TextInput
                                    id="water_resistance"
                                    v-model="form.water_resistance"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.water_resistance"
                                />
                            </div>

                            <div>
                                <InputLabel for="size" value="Tamaño (mm)" />
                                <TextInput
                                    id="size"
                                    v-model="form.size"
                                    type="number"
                                    class="mt-1 block w-full"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.size"
                                />
                            </div>
                        </div>

                        <!-- Checkbox UV Protection -->
                        <div class="flex items-center">
                            <Checkbox
                                id="uv_protection"
                                v-model:checked="form.uv_protection"
                            />
                            <InputLabel
                                for="uv_protection"
                                value="Protección UV"
                                class="ml-2"
                            />
                        </div>
                        <InputError
                            class="mt-2"
                            :message="form.errors.uv_protection"
                        />

                        <!-- Imagen del producto -->
                        <div class="mb-6">
                            <InputLabel value="Current Image" />
                            <div
                                v-if="currentImageUrl"
                                class="mt-2 flex items-center space-x-4"
                            >
                                <img
                                    :src="currentImageUrl"
                                    :alt="`Current ${product.product_name} image`"
                                    class="w-32 h-32 object-cover rounded-md border border-gray-200"
                                />
                                <div
                                    class="text-sm text-gray-500 dark:text-gray-400 break-all"
                                >
                                    <p>Current image path:</p>
                                    <p class="mt-1 text-xs">
                                        {{ product.main_image }}
                                    </p>
                                </div>
                            </div>
                            <div v-else class="mt-2 text-sm text-gray-500">
                                No image currently set
                            </div>
                        </div>

                        <div class="mb-6">
                            <InputLabel
                                for="main_image"
                                value="New Image (optional)"
                            />
                            <input
                                id="main_image"
                                type="file"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-gray-700 dark:file:text-gray-300"
                                @change="handleImageUpload"
                                accept="image/jpeg, image/png, image/jpg, image/gif, image/webp"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.main_image"
                            />
                        </div>

                        <div v-if="previewImage" class="mb-6">
                            <InputLabel value="New Image Preview" />
                            <img
                                :src="previewImage"
                                alt="New image preview"
                                class="mt-2 w-32 h-32 object-cover rounded-md border border-gray-200"
                            />
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton
                                class="ml-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Update Product
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
