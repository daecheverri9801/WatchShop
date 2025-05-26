<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { ref } from "vue";

const props = defineProps({
    categories: Array,
    selectedCategory: [String, Number],
    brands: Array,
    selectedBrand: [String, Number],
    colors: Array,
    selectedColor: [String, Number],
    materials: Array,
    selectedMaterial: [String, Number],
});

const previewImage = ref(null);

const handleImageUpload = (event) => {
    const file = event.target.files[0];

    if (file) {
        // Validación básica del tipo de archivo
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

const form = useForm({
    fk_category_id: props.selectedCategory || "",
    product_name: "",
    product_ref: "",
    fk_brand_id: props.selectedBrand || "",
    genre: "Unisex",
    fk_color_id: props.selectedColor || "",
    fk_material_id: props.selectedMaterial || "",
    uv_protection: false,
    water_resistance: "",
    size: "",
    price: "",
    main_image: null,
});

const submit = () => {
    console.log("Datos a enviar:", form.data()); // Verifica los datos

    form.post(route("products.store"), {
        forceFormData: true, // Importante para archivos
        preserveScroll: true,
        onSuccess: () => {
            console.log("success");
        },
    });
};
</script>

<template>
    <Head title="Create Product" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Create Product</h2>
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
                        <div>
                            <div class="mb-6">
                                <InputLabel
                                    for="main_image"
                                    value="Product Image"
                                />
                                <input
                                    id="main_image"
                                    type="file"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                    @change="handleImageUpload"
                                    accept="image/jpeg, image/png, image/jpg, image/gif, image/webp"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.main_image"
                                />

                                <!-- Vista previa -->
                                <div v-if="previewImage" class="mt-4">
                                    <p class="text-sm text-gray-500 mb-2">
                                        Vista previa:
                                    </p>
                                    <img
                                        :src="previewImage"
                                        class="w-32 h-32 object-cover rounded-md border"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex justify-end space-x-4">
                            <PrimaryButton :disabled="form.processing">
                                Create Product
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
