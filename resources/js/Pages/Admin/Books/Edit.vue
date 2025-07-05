<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, usePage, Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, watch } from 'vue';

defineOptions({ layout: AdminLayout })

const { props } = usePage();
const book = props.book;
const categories = props.categories || [];

const form = useForm({
  title: book.title || '',
  author: book.author || '',
  isbn: book.isbn || '',
  published_year: book.published_year || '',
  description: book.description || '',
  cover_image: null,
  ebook_file: null,
  category_id: book.category_id ? Number(book.category_id) : '',
  publisher: book.publisher || '',
  language: book.language || '',
  status: book.status || 'active',
});



const coverPreview = ref(book.cover_image || null);
const ebookName = ref('');

watch(() => form.cover_image, (file) => {
  if (file) {
    coverPreview.value = URL.createObjectURL(file);
  } else {
    coverPreview.value = book.cover_image || null;
  }
});

const onCoverChange = (e) => {
  const file = e.target.files[0];
  form.cover_image = file;
};

const onEbookChange = (e) => {
  const file = e.target.files[0];
  if (file && file.size > 800 * 1024 * 1024) { // 800MB
    Swal.fire({
      icon: 'error',
      title: 'File too large',
      text: 'The ebook file must be 800MB or less.',
    });
    form.ebook_file = null;
    ebookName.value = '';
    e.target.value = '';
    return;
  }
  form.ebook_file = file;
  ebookName.value = file ? file.name : '';
};

const submit = () => {
  // Only use forceFormData if we have files
  const hasFiles = form.cover_image || form.ebook_file;
  
  form.put(route('admin.books.update', book.id), {
    forceFormData: hasFiles,
    preserveScroll: true,
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: 'Book Updated',
        text: 'The book has been updated successfully.',
        timer: 2000,
        showConfirmButton: false,
      });
      router.visit(route('admin.books.index'));
    },
  });
};
</script>

<template>
  <Head title="Edit Book" />
  <div class="container py-4">
    <div class="d-flex align-items-center mb-4">
      <Link :href="route('admin.books.index')" class="btn btn-outline-success me-3">
        <i class="bi bi-arrow-left"></i> Back
      </Link>
      <h1 class="fs-3 fw-bold mb-0 text-success d-flex align-items-center gap-2"><i class="bi bi-pencil-square"></i> Edit Book</h1>
    </div>
    <form @submit.prevent="submit" enctype="multipart/form-data" class="card border-success shadow admin-book-edit-card p-4">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-book"></i> Title</label>
          <input v-model="form.title" type="text" class="form-control" />
          <div v-if="form.errors.title" class="text-danger">{{ form.errors.title }}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-person"></i> Author</label>
          <input v-model="form.author" type="text" class="form-control" />
          <div v-if="form.errors.author" class="text-danger">{{ form.errors.author }}</div>
        </div>
        <div class="col-md-4">
          <label class="form-label text-success"><i class="bi bi-upc"></i> ISBN</label>
          <input v-model="form.isbn" type="text" class="form-control" />
          <div v-if="form.errors.isbn" class="text-danger">{{ form.errors.isbn }}</div>
        </div>
        <div class="col-md-4">
          <label class="form-label text-success"><i class="bi bi-calendar"></i> Published Year</label>
          <input v-model="form.published_year" type="number" class="form-control" />
          <div v-if="form.errors.published_year" class="text-danger">{{ form.errors.published_year }}</div>
        </div>
        <div class="col-md-4">
          <label class="form-label text-success"><i class="bi bi-building"></i> Publisher</label>
          <input v-model="form.publisher" type="text" class="form-control" />
          <div v-if="form.errors.publisher" class="text-danger">{{ form.errors.publisher }}</div>
        </div>
        <div class="col-md-4">
          <label class="form-label text-success"><i class="bi bi-translate"></i> Language</label>
          <input v-model="form.language" type="text" class="form-control" />
          <div v-if="form.errors.language" class="text-danger">{{ form.errors.language }}</div>
        </div>
        <div class="col-md-4">
          <label class="form-label text-success"><i class="bi bi-tags"></i> Category</label>
          <select v-model="form.category_id" class="form-control">
            <option value="">Select Category</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
          </select>
          <div v-if="form.errors.category_id" class="text-danger">{{ form.errors.category_id }}</div>
        </div>
        <div class="col-md-4">
          <label class="form-label text-success"><i class="bi bi-info-circle"></i> Status</label>
          <select v-model="form.status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
          <div v-if="form.errors.status" class="text-danger">{{ form.errors.status }}</div>
        </div>
        <div class="col-md-12">
          <label class="form-label text-success"><i class="bi bi-card-text"></i> Description</label>
          <textarea v-model="form.description" class="form-control" rows="3"></textarea>
          <div v-if="form.errors.description" class="text-danger">{{ form.errors.description }}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-image"></i> Cover Image</label>
          <input type="file" class="form-control" @change="onCoverChange" accept="image/*" />
          <div v-if="form.errors.cover_image" class="text-danger">{{ form.errors.cover_image }}</div>
          <div v-if="coverPreview" class="mt-2">
            <img :src="coverPreview" alt="Cover Preview" class="rounded border border-success" style="width: 80px; height: 80px; object-fit: cover;" />
          </div>
          <div v-else-if="book.cover_image" class="mt-2">
            <img :src="book.cover_image" alt="Current Cover" class="rounded border border-success" style="width: 80px; height: 80px; object-fit: cover;" />
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-file-earmark"></i> Ebook File</label>
          <input type="file" class="form-control" @change="onEbookChange" accept=".pdf,.epub,.mobi,.txt,.docx,.azw3,.fb2,.djvu,.rtf,.html,.htm" />
          <div v-if="ebookName" class="mt-1 text-muted">Selected: {{ ebookName }}</div>
          <div v-if="form.errors.ebook_file" class="text-danger">{{ form.errors.ebook_file }}</div>
          <div v-if="book.ebook_file && !ebookName" class="mt-2">
            <a :href="book.ebook_file" target="_blank" class="btn btn-outline-primary btn-sm">Current Ebook</a>
          </div>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-success shadow-sm" :disabled="form.processing">
          <i class="bi bi-save"></i> {{ form.processing ? 'Saving...' : 'Update Book' }}
        </button>
        <Link :href="route('admin.books.index')" class="btn btn-outline-success">
          <i class="bi bi-arrow-left"></i> Cancel
        </Link>
      </div>
    </form>
  </div>
</template>

<style scoped>
.admin-book-edit-card {
  border-width: 2px;
  border-radius: 1.25rem;
  margin-bottom: 32px;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.admin-book-edit-card:focus-within, .admin-book-edit-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>