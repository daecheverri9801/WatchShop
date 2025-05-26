<script setup>
import { useForm } from '@inertiajs/vue3';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    colors: Object,
});

const form = useForm({
    color_name: props.colors.color_name,
    color_hex: props.colors.color_hex,
});

const submit = () => {
    form.put(route('colors.update', props.colors.id));
};
</script>

<template>

    <Head title="Edit Color" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Color</h2>
                <Link :href="route('colors.index')"
                    class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600">
                Back to Colors
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <InputLabel for="color_name" value="Color Name" class="dark:text-gray-300" />
                                <TextInput id="color_name" type="text" class="mt-1 block w-full" v-model="form.color_name" required
                                    autofocus />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div class="mb-4">
                                <InputLabel for="color_hex" value="Color Hex" class="dark:text-gray-300" />
                                <TextInput id="color_hex" type="text" class="mt-1 block w-full" v-model="form.color_hex" required
                                    autofocus />
                                <InputError class="mt-2" :message="form.errors.hex" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Update Color
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>