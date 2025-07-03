<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {  router } from '@inertiajs/vue3';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    categories: Array
});

const categories = props.categories || [];

// Delete handler
function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        router.delete(route('admin.categories.destroy', id));
    }
}
</script>

<template>
    <Head title="Categories" />
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fs-3 fw-bold mb-0 bi bi-tags">Categories</h1>
            <Link :href="route('admin.categories.create')" class="btn btn-primary bi bi-plus">Add Category</Link>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-hash"></i> ID</th>
                            <th><i class="bi bi-tag"></i> Name</th>
                            <th><i class="bi bi-card-text"></i> Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories" :key="category.id">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td>{{ category.description }}</td>
                            <td class="text-end">
                                <Link :href="route('admin.categories.edit', category.id)" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i> Edit</Link>
                                <Link :href="route('admin.categories.show', category.id)" class="btn btn-sm btn-success me-1"><i class="bi bi-eye"></i> View</Link>
                                <button @click="deleteCategory(category.id)" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i> Delete</button>
                                <Link :href="route('admin.categories.books', category.id)" class="btn btn-sm btn-info"><i class="bi bi-book"></i> View Books</Link>
                            </td>
                        </tr>
                        <tr v-if="categories.length === 0">
                            <td colspan="4" class="text-center text-muted">No categories found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>