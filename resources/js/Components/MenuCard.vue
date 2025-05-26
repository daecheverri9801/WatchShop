<template>
  <Link :href="route" class="block">
    <div class="bg-white/90 shadow-lg rounded-xl p-6 flex items-center hover:bg-white transition-all duration-300">
      <img :src="image" alt="icon" class="h-20 w-20 object-contain mr-6" />
      <h2 class="text-2xl font-semibold text-gray-800">{{ title }}</h2>
    </div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  title: String,
  route: String,
  image: String,
})
</script>
