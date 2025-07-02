<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { usePage, Head, Link } from '@inertiajs/vue3';
import EpubReader from '@/Components/EpubReader.vue';

defineOptions({ layout: UserLayout });
const { props, url } = usePage();
const book = props.book;

// Get the 'from' query parameter
const from = new URLSearchParams(window.location.search).get('from');
</script>

<template>
  <Head :title="`Read: ${book.title}`" />
  <div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <Link
        v-if="from === 'list'"
        :href="route('books.index')"
        class="btn btn-outline-secondary"
      >
        <i class="bi bi-arrow-left"></i> Back to Books
      </Link>
      <Link
        v-else
        :href="route('books.view', { id: book.id })"
        class="btn btn-outline-secondary"
      >
        <i class="bi bi-arrow-left"></i> Back to Details
      </Link>
      <h4 class="mb-0">{{ book.title }}</h4>
      <span></span>
    </div>
    <div class="bg-white rounded shadow p-2" style="min-height: 80vh;">
      <EpubReader :url="book.ebook_file" />
    </div>
  </div>
</template>
