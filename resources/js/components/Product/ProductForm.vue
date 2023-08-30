<template>
    <div>
        <div v-if="errors" class="bg-red-500 text-dark py-2 px-4 pr-0 rounded font-bold mb-4 shadow-lg">
            <div v-for="(v, k) in errors" :key="k">
                <p v-for="error in v" :key="error" class="text-sm">
                    {{ error }}
                </p>
            </div>
        </div>
        <h2 v-if="isNewProduct">Add Product</h2>
        <h2 v-else>Edit Product</h2>
        <form @submit="submitForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input class="form-control" type="text" id="title" v-model="product.title" />
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content:</label>
                <textarea class="form-control" id="content" v-model="product.content"></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input class="form-control" type="number" id="price" v-model="product.price" />
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Image:</label>
                <input id="file" type="file" class="form-control" v-on:change="onFileChange">
                <img style="max-width: 100px; height: auto" :src="'/upload/'+product.file" alt="image" />
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category:</label>
                <select id="category_id" class="form-control" v-model="product.category_id">
                    <option v-for="category in categories" v-bind:value="category.id">
                        {{ category.title }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input class="form-control" type="number" id="quantity" v-model="product.quantity" />
            </div>
            <button type="submit" v-if="isNewProduct" class="btn btn-primary">Add Product</button>
            <button type="submit" v-else class="btn btn-primary">Update Product</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            categories: [],
            product: {
                title: '',
                content: '',
                price: '',
                file: '',
                quantity: 0,
                category_id: 0
            },
            errors: null
        }
    },
    computed: {
        isNewProduct() {
            return !this.$route.path.includes('edit');
        },
    },
    async created() {
        if (!this.isNewProduct) {
            const response = await axios.get(`/api/products/${this.$route.params.id}`);
            this.product = response.data;
        }
        const response = await axios.get(`/api/categories`);
        this.categories = response.data;
        console.log(response.data);
    },
    methods: {
        async onFileChange(e) {
            console.log(e.target.files[0]);
            this.product.file = e.target.files[0];
        },
        async submitForm(e) {
            e.preventDefault();
            try {
                const config = {
                    headers: {
                        'Content-type': 'multipart/form-data'
                    }
                }

                if (this.isNewProduct) {
                    await axios.post('/api/products', this.product, config)
                        .then( response => {
                            console.log(response);
                        }).catch((error) => {
                            this.errors = error.response.data.errors;
                        }
                    );
                } else {
                    console.log(this.product);
                    await axios.post(`/api/products/${this.$route.params.id}`, this.product,{
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                        params: {
                            _method: "put",
                        },
                    })
                        .then( response => {
                            console.log(response);
                        }).catch((error) => {
                            this.errors = error.response.data.errors;
                        }
                    );
                }
                this.$router.push('/products');
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>
