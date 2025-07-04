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
            <h1 class="fs-3 fw-bold mb-0 text-success"><i class="bi bi-book"></i> Books in {{ category.name }}</h1>
            <Link :href="route('admin.categories.index')" class="btn btn-success shadow-sm rounded-pill px-4 py-2 fw-semibold">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </Link>
        </div>
        <div class="card border-success shadow rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle" v-if="books.length">
                    <thead class="table-success">
                        <tr>
                            <th class="text-success"><i class="bi bi-hash"></i> ID</th>
                            <th class="text-success"><i class="bi bi-book"></i> Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="book in books" :key="book.id">
                            <td class="fw-semibold">{{ book.id }}</td>
                            <td>{{ book.title }}</td>
                        </tr>
                    </tbody>
                </table>
                <p v-else class="text-center text-muted py-4 mb-0"><i class="bi bi-emoji-frown"></i> No books found for this category.</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card {
  border-radius: 1.25rem;
  box-shadow: 0 2px 16px rgba(0,128,0,0.08);
}
.btn-success {
  transition: background 0.2s, box-shadow 0.2s;
}
.btn-success:hover, .btn-success:focus {
  background: #218838;
  box-shadow: 0 2px 8px rgba(40,167,69,0.15);
}
.table-success th {
  background-color: #d4edda !important;
}
</style>