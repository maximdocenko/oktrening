import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Import components
import App from './components/App.vue';
import ProductList from './components/Product/ProductList.vue';
import ProductForm from './components/Product/ProductForm.vue';
import Product from './components/Product/Product.vue';

import CategoryList from './components/Category/CategorytList.vue';
import CategoryForm from './components/Category/CategoryForm.vue';
import Category from './components/Category/Category.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/products', component: ProductList },
        { path: '/products/create', component: ProductForm },
        { path: '/products/:id', component: Product },
        { path: '/products/:id/edit', component: ProductForm },

        { path: '/categories', component: CategoryList },
        { path: '/categories/create', component: CategoryForm },
        { path: '/categories/:id', component: Category },
        { path: '/categories/:id/edit', component: CategoryForm },
    ]
});

const app = createApp(App);
app.use(router);
app.mount('#app');
