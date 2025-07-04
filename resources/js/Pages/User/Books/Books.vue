<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { usePage, router } from '@inertiajs/vue3';
import BookCard from '@/Components/BookCard.vue';
import { ref, onMounted, onUnmounted, computed } from 'vue';

defineOptions({layout: UserLayout});
const { props } = usePage();
const books = props.books || [];
const savedBookIds = computed(() => props.saved_books ?? []);
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

const saveBook = (book) => {
  router.post(route('books.save', { id: book.id }), {}, {
    preserveScroll: true,
    onSuccess: () => {
      router.reload({ only: ['saved_books'] });
    }
  });
};
const unsaveBook = (book) => {
  router.post(route('books.unsave', { id: book.id }), {}, {
    preserveScroll: true,
    onSuccess: () => {
      router.reload({ only: ['saved_books'] });
    }
  });
};
</script>

<template>
    <Head title="All Books" />
  <div>
    <h1 class="text-success fw-bold d-flex align-items-center gap-2 mb-4"><i class="bi bi-journals"></i> All Books</h1>
    <div class="row mt-4">
      <template v-if="filteredBooks.length > 0">
        <div v-for="book in filteredBooks" :key="book.id" class="col-md-4 mb-4">
          <BookCard :book="{...book, from: 'book'}"
                    :isSaved="savedBookIds.value.includes(book.id)"
                    @save="saveBook"
                    @unsave="unsaveBook" />
        </div>
      </template>
      <template v-else>
        <div class="col-12 text-center text-muted py-5">
          <i class="bi bi-search text-success" style="font-size: 2rem;"></i>
          <div>No results found.</div>
        </div>
      </template>
    </div>
  </div>
</template>
