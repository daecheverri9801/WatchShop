<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :class="[
        'px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors',
        { 'opacity-50 cursor-not-allowed': disabled }
    ]" :disabled="disabled">
        <slot />
    </button>
</template>
