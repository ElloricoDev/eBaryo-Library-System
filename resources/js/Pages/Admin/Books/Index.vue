<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { usePage, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

defineOptions({
    layout: AdminLayout
})

const { props } = usePage();
const books = props.books || [];

const handleDelete = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This will permanently delete the book.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.books.destroy', id));
        }
    });
};
</script>

<template>
    <Head title="Books" />
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="fs-3 fw-bold mb-0 bi bi-book">Books</h1>
      <Link :href="route('admin.books.create')" class="btn btn-primary bi bi-plus">Add Book</Link>
    </div>
    <div class="card">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th><i class="bi bi-hash"></i> ID</th>
              <th><i class="bi bi-book"></i> Title</th>
              <th><i class="bi bi-person"></i> Author</th>
              <th><i class="bi bi-tags"></i> Category</th>
              <th><i class="bi bi-check-circle"></i> Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="book in books" :key="book.id">
                <td>{{ book.id }}</td>
              <td>{{ book.title }}</td>
              <td>{{ book.author }}</td>
              <td>{{ book.category ? book.category.name : '—' }}</td>
              <td>
                <span :class="book.status === 'active' ? 'text-success' : 'text-danger'">
                  <i v-if="book.status === 'active'" class="bi bi-check-circle"></i>
                  <i v-else class="bi bi-x-circle"></i>
                  {{ book.status.charAt(0).toUpperCase() + book.status.slice(1) }}
                </span>
              </td>
              <td class="text-end">
                <Link :href="route('admin.books.show', book.id)" class="btn btn-sm btn-info me-1"><i class="bi bi-eye"></i> View</Link>
                <Link :href="route('admin.books.edit', book.id)" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i> Edit</Link>
                <button @click="handleDelete(book.id)" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</button>
              </td>
            </tr>
            <tr v-if="books.length === 0">
              <td colspan="5" class="text-center text-muted">No books found.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>