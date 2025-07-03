<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import BookCard from '@/Components/BookCard.vue';
import { ref, onMounted, onUnmounted, computed } from 'vue';
const { props } = usePage();
const books = props.books || [];
const continueReading = props.continueReading || null;
const search = ref('');
const filteredBooks = computed(() => {
  if (!search.value) return books;
  return books.filter(book =>
    (book.title && book.title.toLowerCase().includes(search.value.toLowerCase())) ||
    (book.author && book.author.toLowerCase().includes(search.value.toLowerCase()))
  );
});
const handleSearch = (e) => {
  search.value = e.detail;
};
onMounted(() => {
  window.addEventListener('user-search', handleSearch);
});
onUnmounted(() => {
  window.removeEventListener('user-search', handleSearch);
});
</script>

<template>
   <Head title="Home"/>
   <UserLayout>
    <div v-if="continueReading && continueReading.book" class="alert alert-info d-flex align-items-center justify-content-between mb-4">
      <div>
        <strong>Continue Reading:</strong> {{ continueReading.book.title }}
        <span v-if="continueReading.last_percent">({{ Math.round(continueReading.last_percent * 100) }}% read)</span>
      </div>
      <Link :href="route('books.read', { id: continueReading.book.id })" class="btn btn-primary btn-sm">
        Resume
      </Link>
    </div>
    <div class="row mt-4">
      <template v-if="filteredBooks.length > 0">
        <div v-for="book in filteredBooks" :key="book.id" class="col-md-4 mb-4">
          <BookCard :book="{...book, from: 'home'}" />
        </div>
      </template>
      <template v-else>
        <div class="col-12 text-center text-muted py-5">
          <i class="bi bi-search" style="font-size: 2rem;"></i>
          <div>No results found.</div>
        </div>
      </template>
    </div>
   </UserLayout>
</template>