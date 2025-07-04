<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {  router } from '@inertiajs/vue3';
import Swal from 'sweetalert2'

defineOptions({ layout: AdminLayout });

const props = defineProps({
    categories: Array
});

const categories = props.categories || [];

// Delete handler
function deleteCategory(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.categories.destroy', id), {
                onSuccess: () => {
                    Swal.fire(
                        'Deleted!',
                        'Category has been deleted.',
                        'success'
                    );
                }
            });
        }
    });
}
</script>

<template>
    <Head title="Categories" />
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fs-3 fw-bold mb-0 text-success"><i class="bi bi-tags"></i> Categories</h1>
            <Link :href="route('admin.categories.create')" class="btn btn-success shadow-sm rounded-pill px-4 py-2 fw-semibold">
                <i class="bi bi-plus"></i> Add Category
            </Link>
        </div>
        <div class="card border-success shadow rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-success">
                        <tr>
                            <th class="text-success"><i class="bi bi-hash"></i> ID</th>
                            <th class="text-success"><i class="bi bi-tag"></i> Name</th>
                            <th class="text-success"><i class="bi bi-card-text"></i> Description</th>
                            <th class="text-end text-success">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories" :key="category.id">
                            <td class="fw-semibold">{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td>{{ category.description }}</td>
                            <td class="text-end">
                                <Link :href="route('admin.categories.edit', category.id)" class="btn btn-sm btn-warning rounded-pill me-1"><i class="bi bi-pencil"></i> Edit</Link>
                                <Link :href="route('admin.categories.show', category.id)" class="btn btn-sm btn-success rounded-pill me-1"><i class="bi bi-eye"></i> View</Link>
                                <button @click="deleteCategory(category.id)" class="btn btn-sm btn-danger rounded-pill me-1"><i class="bi bi-trash"></i> Delete</button>
                                <Link :href="route('admin.categories.books', category.id)" class="btn btn-sm btn-info rounded-pill"><i class="bi bi-book"></i> View Books</Link>
                            </td>
                        </tr>
                        <tr v-if="categories.length === 0">
                            <td colspan="4" class="text-center text-muted py-4"><i class="bi bi-emoji-frown"></i> No categories found.</td>
                        </tr>
                    </tbody>
                </table>
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
.btn {
  transition: box-shadow 0.2s;
}
.btn:focus {
  box-shadow: 0 0 0 0.2rem rgba(40,167,69,.15);
}
</style>