<template>

    <Head title="Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Product Detail
                </h2>
                <a :href="`/products/${product.id}/edit`" class="bg-blue-500 text-white px-4 py-2 rounded">Update
                    Product</a>
            </div>
        </template>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="px-5 py-5 md:px-10 py-10 w-full shadow-md rounded-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="w-full mb-6">
                        <img :src="`/storage/${product.image}`" alt="product image"
                            class="product-image w-full rounded-2xl md-profile" />
                    </div>
                    <div class="w-full">
                        <div class="flex justify-between items-center">
                            <div class="product-name font-bold">{{ product.name }}</div>
                            <div class="product-name font-normal">${{ product.price }}</div>
                        </div>
                        <div class="font-normal text-[#101828] my-3">Description :</div>
                        <div class="font-normal text-pretty text-[#6a7384]">{{ product.description }}</div>

                    </div>
                </div>
                <div class="review-section mt-10">
                    <div class="text-[#101828] font-medium text-lg">Comments</div>
                    <div class="border-t-2 border-[#ebe6e7] mt-6">
                        <div
                            class="border border-[#ebe6e7] flex gap-1 items-center pr-2 rounded-4xl w-full relative">
                            <textarea v-model="new_message" type="text" rows="1"
                                class="bg-transparent outline-none border-none focus:outline-none focus:border-none px-2 py-3 flex-1 text-[#101828] placeholder:text-[#101828] resize-none clean-scrollbar"
                                placeholder="Write Comment" @keydown.enter.prevent="handleKey"></textarea>
                            <div @click="send_message()"
                                class="w-10 cursor-pointer">
                                <Icon icon="mingcute:send-line" class="text-2xl text-[#101828] absolute-center" />
                            </div>
                        </div>
                        <div v-if="reviews.length > 0" class="flex flex-col-reverse">
                            <!-- comment card -->
                            <div v-for="(review, index) in reviews" :key="index" class="py-9 w-full flex flex-col-reverse border-b border-[#ebe6e7] md:flex-row gap-2">
                                <div class="w-full md:w-2/6 flex md:block">
                                    <div class="text-[#101828] text-sm font-medium">{{ review.user.name }}</div>
                                    <div
                                        class="text-[#6a7384] text-sm border-l border-[#ebe6e7] pl-4 ml-4 md:border-none md:pl-0 md:ml-0">
                                        {{ review.created_at }}</div>
                                </div>
                                <div class="w-full md:w-3/4">
                                    <div class="text-[#6a7384] text-sm"> {{ review.text }}</div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-[#6a7384] text-sm w-full h-32 flex justify-center items-center"> There is no comments yet.</div>
                    </div>
                </div>
                <!-- <Card v-for="product in products" :key="product.id" :product="product" class="p-4 border rounded"></Card>    -->
            </div>
        </div>

    </AuthenticatedLayout>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from './Partials/Card.vue';
import { Head } from '@inertiajs/vue3';
import { Icon } from "@iconify/vue";

const props = defineProps({
    product: {
        type: Object,
    },
    comments: {
        type: Array
    }
});
const reviews = ref([]);
const new_message = ref('');
const handleKey = (event) => {
  if (event.shiftKey) {
    new_message.value += '\n';
  } else {
    send_message();
  }
};

const send_message = async () => {
    try {
        if(new_message.value.trim() == '') return;
        const data = {
            product_id: props.product.id,
            text: new_message.value.trim()
        };
        await axios.post(`/api/save-comment`, data)
        .then(res => {
            new_message.value = '';
            reviews.value.push(res.data.data);
        });
    } catch (e) {
        console.log(e);
    }
}

onMounted(() => {
    if(props.comments.length > 0) {
        reviews.value = props.comments;
    }

    // Listen for new comments via Pusher
    window.Echo.channel(`product.${props.product.id}`)
      .listen('CommentPosted', (e) => {
        console.log(e);
        // Check if the comment already exists by ID
        const exists = reviews.value.some(comment => comment.id === e.comment.id);
        if (!exists) {
            reviews.value.push(e.comment);
        }
    });
})
</script>
<style scoped>
/* .product-image {
    min-height: 10rem;
    max-height: 10rem;
} */
.product-name {
    font-size: 1.5rem
        /* 24px */
    ;
    line-height: 2rem
        /* 32px */
    ;
}

@media (min-width: 768px) {

    /* .product-image {
        min-height: 20rem;
        max-height: 20rem;
    } */
    .product-name {
        font-size: 2rem;
        line-height: 2.25rem
            /* 36px */
        ;
    }
}
</style>