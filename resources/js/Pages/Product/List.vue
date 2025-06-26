<template>

    <Head title="Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Products
                </h2>
                <a href="/products/create" class="bg-blue-500 text-white px-4 py-2 rounded">Create New</a>
            </div>
        </template>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <Card v-for="product in products" :key="product.id" :product="product" class="p-4 border rounded"></Card>   
            </div>
        </div>
        
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from './Partials/Card.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    products: {
        type: Array,
    },
});
</script>
