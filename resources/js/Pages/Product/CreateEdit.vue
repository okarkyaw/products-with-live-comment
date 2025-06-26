<template>

    <Head title="Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ product.id ? 'Edit Product' : 'Create Product' }}
                </h2>
                <!-- <a href="/products/create" class="bg-blue-500 text-white px-4 py-2 rounded">Create New</a> -->
            </div>
        </template>

        <div class="py-12 mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Product Information
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ product.id ? 'Update' : 'Create' }} your Product Information.
                        </p>
                    </header>

                    <form @submit.prevent="createUpdate" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="name" value="Image" />

                            <TextInput id="image" type="file" @change="handleImageUpload" class="mt-1 block w-full"
                                :required="product.id ? false : true" autofocus autocomplete="image" />

                            <!-- Preview if it's a new file -->
                            <div v-if="previewImage" class="mt-2">
                                <img :src="previewImage" style="min-height: 8rem; max-height: 8rem;" class="object-cover border rounded" />
                            </div>

                            <!-- Show uploaded image from server -->
                            <div v-else-if="product.image && typeof product.image === 'string'" class="mt-2">
                                <img :src="`/storage/${product.image}`" class="h-32 object-cover border rounded" />
                            </div>

                            <!-- <InputError class="mt-2" :message="product.errors.image" /> -->
                        </div>
                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="product.name" required
                                autofocus autocomplete="name" />

                            <!-- <InputError class="mt-2" :message="product.errors.name" /> -->
                        </div>
                        <div>
                            <InputLabel for="description" value="Description" />

                            <Textarea id="description" type="text" class="mt-1 block w-full"
                                v-model="product.description" required autofocus autocomplete="description"></Textarea>

                            <!-- <InputError class="mt-2" :message="product.errors.description" /> -->
                        </div>
                        <div>
                            <InputLabel for="name" value="Price" />

                            <TextInput id="price" type="number" class="mt-1 block w-full" v-model="product.price"
                                required autofocus autocomplete="price" />

                            <!-- <InputError class="mt-2" :message="product.errors.price" /> -->
                        </div>


                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="isLoading">{{ product.id ? 'Update' : 'Create' }}</PrimaryButton>

                            <!-- <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                                Saved.
                            </p>
                        </Transition> -->
                        </div>
                    </form>
                </section>

            </div>
        </div>

    </AuthenticatedLayout>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    initialProduct: {
        type: Object,
    },
});
const product = ref({ id: null, image: null, name: '', description: '', price: '' });
const isLoading = ref(false);
const imageFile = ref(null);
const previewImage = ref(null);

const handleImageUpload = (event) => {
    imageFile.value = event.target.files[0];
    if (imageFile.value) {
        product.value.image = imageFile.value;

        const reader = new FileReader();
        reader.onload = e => {
            previewImage.value = e.target.result;
        };
        reader.readAsDataURL(imageFile.value);
    }
}

const createUpdate = () => {
    const formData = new FormData()
    formData.append('name', product.value.name)
    formData.append('description', product.value.description)
    formData.append('price', product.value.price)
    if (imageFile.value) {
        formData.append('image', imageFile.value)
    }
    console.log(formData);

    if (product.value.id) {
        formData.append('_method', 'PUT')
        axios.post(`/products/${product.value.id}`, formData)
            .then(res => {
                window.location.href = `/products/${product.value.id}`
            })
    } else {
        axios.post('/products', formData)
            .then(res => {
                window.location.href = `/products/${res.data.data.id}`
            })
    }
}

onMounted(() => {
    if (props.initialProduct) {
        product.value = props.initialProduct;
    }
})

</script>