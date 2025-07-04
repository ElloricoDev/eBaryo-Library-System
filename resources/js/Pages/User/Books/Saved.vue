<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import BookCard from '@/Components/BookCard.vue';
import { usePage } from '@inertiajs/vue3';

defineOptions({ layout: UserLayout });
const { props } = usePage();
const books = props.books || [];

const unsaveBook = (bookId) => {
  // Implement the unsaveBook function
};
</script>

<template>
  <div>
    <h1 class="text-success fw-bold mb-4"><i class="bi bi-bookmark"></i> Saved Books</h1>
    <div class="row mt-4">
      <template v-if="books.length > 0">
        <div v-for="book in books" :key="book.id" class="col-md-4 mb-4">
          <BookCard :book="book" :isSaved="true" @unsave="unsaveBook" />
        </div>
      </template>
      <template v-else>
        <div class="col-12 text-center text-muted py-5">
          <i class="bi bi-bookmark text-success" style="font-size: 2rem;"></i>
          <div>No saved books yet.</div>
        </div>
      </template>
    </div>
  </div>
</template> 