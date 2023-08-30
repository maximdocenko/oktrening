<template>
    <div>
        <div v-if="errors" class="bg-red-500 text-dark py-2 px-4 pr-0 rounded font-bold mb-4 shadow-lg">
            <div v-for="(v, k) in errors" :key="k">
                <p v-for="error in v" :key="error" class="text-sm">
                    {{ error }}
                </p>
            </div>
        </div>
        <h2 v-if="isNewCategory">Add Category</h2>
        <h2 v-else>Edit Category</h2>
        <form @submit="submitForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input class="form-control" type="text" id="title" v-model="category.title" />
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Parent Id:</label>
                <select class="form-control" v-model="category.parent_id">
                    <label for="image" class="form-label">Category:</label>
                    <option v-for="category in categories" v-bind:value="category.id">
                        {{ category.title }}
                    </option>
                </select>
            </div>
            <button type="submit" v-if="isNewCategory" class="btn btn-primary">Add Category</button>
            <button type="submit" v-else class="btn btn-primary">Update Category</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            category: {
                title: '',
                parent_id: 0,
            },
            errors: null
        }
    },
    computed: {
        isNewCategory() {
            return !this.$route.path.includes('edit');
        }
    },
    async created() {
        if (!this.isNewCategory) {
            const response = await axios.get(`/api/categories/${this.$route.params.id}`);
            this.category = response.data;
        }
    },
    methods: {
        async onFileChange(e) {
            console.log(e.target.files[0]);
            this.category.file = e.target.files[0];
        },
        async submitForm(e) {
            e.preventDefault();
            try {
                const config = {
                    headers: {
                        'Content-type': 'multipart/form-data'
                    }
                }

                if (this.isNewCategory) {
                    await axios.post('/api/categories', this.category, config)
                        .then( response => {
                            console.log(response);
                        }).catch((error) => {
                            this.errors = error.response.data.errors;
                        }
                    );
                } else {
                    console.log(this.category);
                    await axios.post(`/api/categories/${this.$route.params.id}`, this.category,{
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
                this.$router.push('/categories');
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>
