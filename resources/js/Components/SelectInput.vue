<script setup>
defineProps({
    id: String,
    modelValue: [String, Number],
    required: Boolean,
    disabled: Boolean,
});

defineEmits(['update:modelValue']);
</script>

<template>
    <select
        :id="id"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        :required="required"
        :disabled="disabled"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
    >
        <slot />
    </select>
</template>