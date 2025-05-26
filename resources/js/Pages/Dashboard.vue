<template>
  <div class="min-h-screen bg-cover bg-center" :style="backgroundStyle">
    <!-- Banner -->
    <div class="w-full bg-black bg-opacity-60 py-10">
      <h1 class="text-4xl font-bold text-white text-center drop-shadow-lg">
        Bienvenido al Panel de Administración
      </h1>
      <p class="text-center text-gray-300 mt-2 text-lg">
        Gestiona tus productos, categorías y más desde aquí
      </p>
    </div>

    <!-- Menú vertical -->
    <div class="max-w-4xl mx-auto py-12 space-y-6 px-4">
      <MenuCard
        title="Productos"
        route="/products"
        image="https://img.icons8.com/color/512/shopping-cart-loaded.png"
      />

      <MenuCard
        title="Categorías"
        route="/categories"
        image="https://img.icons8.com/color/512/folder-invoices.png"
      />

      <MenuCard
        title="Marcas"
        route="/brands"
        image="https://img.icons8.com/color/512/approval.png"
      />

      <MenuCard
        title="Colores"
        route="/colors"
        image="https://img.icons8.com/color/512/paint-palette.png"
      />

      <MenuCard
        title="Materiales"
        route="/materials"
        image="https://img.icons8.com/color/512/plastic.png"
      />
    </div>
  </div>
</template>

<script setup>
import MenuCard from '@/Components/MenuCard.vue'

const backgroundStyle = `
  background-image: url('https://images.unsplash.com/photo-1588776814546-46e8c56d48b5?auto=format&fit=crop&w=1400&q=80');
`
</script>
