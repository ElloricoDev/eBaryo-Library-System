<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { usePage, Head, Link } from '@inertiajs/vue3';
import EpubReader from '@/Components/EpubReader.vue';
import { ref } from 'vue';
defineOptions({ layout: UserLayout });
const { props } = usePage();
const book = props.book;
const showReader = ref(false);

function handleReadNow() {
  showReader.value = !showReader.value;
}
function saveBook() {
  // Placeholder: implement save logic
  alert('Book saved! (feature coming soon)');
}
function reportBook() {
  // Placeholder: implement report logic
  alert('Book reported! (feature coming soon)');
}
</script>

<template>
  <Head :title="book.title" />
  <div class="container py-4">
    <div class="mb-3">
      <Link :href="route('books.index')" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
      </Link>
    </div>
    <div class="row">
      <div class="col-md-4">
        <img v-if="book.cover_image" :src="book.cover_image" :alt="book.title" class="img-fluid rounded shadow mb-3" />
        <div v-else class="bg-secondary text-white d-flex align-items-center justify-content-center rounded mb-3" style="height: 300px;">
          <span>No Cover Image</span>
        </div>
        <div class="d-flex flex-wrap gap-2 mb-2">
          <Link
            v-if="book.ebook_file"
            :href="route('books.read', { id: book.id, from: 'details' })"
            class="btn btn-primary w-100"
          >
            <i class="bi bi-book"></i> Read
          </Link>
          <button class="btn btn-outline-success w-100" @click="saveBook">
            <i class="bi bi-bookmark"></i> Save
          </button>
          <button class="btn btn-outline-danger w-100" @click="reportBook">
            <i class="bi bi-flag"></i> Report
          </button>
        </div>
      </div>
      <div class="col-md-8">
        <h2>{{ book.title }}</h2>
        <p><strong>Author:</strong> {{ book.author }}</p>
        <p><strong>ISBN:</strong> {{ book.isbn || 'N/A' }}</p>
        <p><strong>Published Year:</strong> {{ book.published_year || 'N/A' }}</p>
        <p><strong>Publisher:</strong> {{ book.publisher || 'N/A' }}</p>
        <p><strong>Language:</strong> {{ book.language || 'N/A' }}</p>
        <p><strong>Category:</strong> {{ book.category?.name || 'N/A' }}</p>
        <p><strong>Status:</strong> <span :class="book.status === 'active' ? 'text-success' : 'text-danger'">{{ book.status }}</span></p>
        <p><strong>Description:</strong></p>
        <div class="mb-3" v-html="book.description || '<em>No description provided.</em>'"></div>
        <p class="text-muted"><small>Added: {{ new Date(book.created_at).toLocaleString() }}</small></p>
        <p class="text-muted"><small>Last Updated: {{ new Date(book.updated_at).toLocaleString() }}</small></p>
        <span v-if="!book.ebook_file" class="text-danger">No eBook file available.</span>
      </div>
    </div>
    <div v-if="showReader && book.ebook_file" class="mt-4">
      <EpubReader :url="book.ebook_file" />
    </div>
  </div>
</template> 