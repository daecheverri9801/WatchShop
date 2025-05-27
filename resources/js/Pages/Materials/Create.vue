<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    material_name: '',
    state: ''
});

const submit = () => {
    form.post(route('materials.store'));
};
</script>

<template>

    <Head title="Create Materials" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Material</h2>
                <Link :href="route('materials.index')"
                    class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600">
                Back to Materials
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <InputLabel for="material_name" value="Material Name" class="dark:text-gray-300" />
                                <TextInput id="material_name" type="text" class="mt-1 block w-full" v-model="form.material_name" required
                                    autofocus />
                                <InputError class="mt-2" :message="form.errors.material_name" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="state" value="State" class="dark:text-gray-300" />
                                <select id="state" class="mt-1 block w-full" v-model="form.state">
                                    <option :value="true">Active</option>
                                    <option :value="false">Inactive</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.state" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Create Material
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>