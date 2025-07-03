<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    category: Object,
    books: Array
});

const books = props.books || [];
const category = props.category;

</script>

<template>
    <Head :title="`Books in ${category.name}`" />
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fs-3 fw-bold mb-0 bi bi-book">Books in {{ category.name }}</h1>
            <Link :href="route('admin.categories.index')" class="btn btn-secondary bi bi-arrow-left"> Back to Categories</Link>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0" v-if="books.length">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-hash"></i> ID</th>
                            <th><i class="bi bi-book"></i> Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="book in books" :key="book.id">
                            <td>{{ book.id }}</td>
                            <td>{{ book.title }}</td>
                        </tr>
                    </tbody>
                </table>
                <p v-else class="text-center text-muted py-4 mb-0">No books found for this category.</p>
            </div>
        </div>
    </div>
</template>