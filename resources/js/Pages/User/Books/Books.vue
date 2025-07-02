<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { usePage, Link } from '@inertiajs/vue3';

defineOptions({layout: UserLayout});
const { props } = usePage();
const books = props.books || [];
</script>

<template>
    <Head title="All Books" />
  <div>
    <h1>All Books</h1>
    <div class="row mt-4">
      <div v-for="book in books" :key="book.id" class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ book.title }}</h5>
            <p class="card-text mb-2"><strong>Author:</strong> {{ book.author || 'Unknown' }}</p>
            <div class="mt-auto d-flex flex-wrap gap-2">
              <Link
                v-if="book.ebook_file"
                :href="route('books.read', { id: book.id, from: 'list' })"
                class="btn btn-primary btn-sm"
              >
                <i class="bi bi-book"></i> Read
              </Link>
              <Link :href="route('books.view', { id: book.id })" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-eye"></i> View Details
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
