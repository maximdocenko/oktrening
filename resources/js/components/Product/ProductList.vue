<template>
    <div>
        <div class="form-group">

        </div>
        <div class="form-group">

        </div>
    </div>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">
                    Title
                    <input placeholder="Title" class="form-control" type="text" v-model="filter.title" @keyup="sortProduct">
                </th>
                <th scope="col">
                    Content
                    <input placeholder="Content" class="form-control" type="text" v-model="filter.content" @keyup="sortProduct">
                </th>
                <th scope="col">
                    Price
                </th>
                <th scope="col">
                    Category Id
                </th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td><img style="max-width: 100px; height: auto" :src="'/upload/'+product.file" alt="image" /></td>
                <td>{{ product.title }}</td>
                <td>{{ product.content }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.category_id }}</td>
                <td>
                    <div class="row gap-3">
                        <router-link :to="`/products/${product.id}`" class="p-2 col border btn btn-primary">View</router-link>
                        <router-link :to="`/products/${product.id}/edit`" class="p-2 col border btn btn-success">Edit</router-link>
                        <button @click="deleteProduct(product.id)" type="button" class="p-2 col border btn btn-danger">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            products: [],
            filter: {
                title: '',
                content: ''
            }
        }
    },
    async created() {
        try {
            const response = await axios.get('/api/products');
            this.products = response.data;
            console.log(this.products)
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        async sortProduct() {
            try {
                await axios.post(`/api/products/filter`, this.filter)
                    .then( response => {
                        this.products = response.data;
                    }).catch((error) => {
                        this.errors = error.response.data.errors;
                    });
            } catch (error) {
                console.error(error);
            }
        },
        async deleteProduct(id) {
            try {
                await axios.delete(`/api/products/${id}`);
                this.products = this.products.filter(product => product.id !== id);
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>
