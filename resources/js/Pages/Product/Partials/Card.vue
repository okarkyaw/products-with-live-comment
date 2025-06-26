<template>
    <div v-if="product" @click="gotoTutorDetails" class="px-5 py-3 w-full shadow-md cursor-pointer hover:bg-primary-light-blue-25 relative">
        <div class="w-full mb-6">
            <img :src="`/storage/${product.image}`" alt="product image" class="rounded-2xl md-profile" />
        </div>
        <div class="space-y-2">
            <div class="flex items-center gap-2 justify-between">
                <div class="text-xl font-medium truncate">{{ product.name }}</div>
                <div class="items-center">
                    <span>${{ Number(product.price).toFixed(1) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
	product : {
		type : Object,
        required: true
	},
});

const gotoTutorDetails = () => {
    window.location.href = `/products/${props.product.id}`
}
</script>