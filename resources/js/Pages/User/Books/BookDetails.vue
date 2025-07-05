<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { usePage, Head, Link, router } from '@inertiajs/vue3';
import EpubReader from '@/Components/EpubReader.vue';
import PdfReader from '@/Components/PdfReader.vue';
import { ref, computed } from 'vue';

defineOptions({ layout: UserLayout });
const { props } = usePage();
const book = props.book;
const savedBookIds = ref(props.saved_books || []);
const isSaved = computed(() => savedBookIds.value.includes(book.id));
const showReader = ref(false);

// Get the 'from' parameter from the URL
const from = new URLSearchParams(window.location.search).get('from') || 'books';

// Function to get the back route based on where user came from
const getBackRoute = () => {
  switch (from) {
    case 'home':
      return route('home');
    case 'saved':
      return route('books.saved');
    case 'books':
      return route('books.index');
    case 'details':
      return route('books.index');
    default:
      return route('books.index');
  }
};

function handleReadNow() {
  showReader.value = !showReader.value;
}
function saveBook() {
  if (isSaved.value) return;
  router.post(route('books.save', { id: book.id }), {}, {
    preserveScroll: true,
    onSuccess: () => {
      // Update local state
      if (!savedBookIds.value.includes(book.id)) {
        savedBookIds.value.push(book.id);
      }
      // Show success notification
      alert(`"${book.title}" has been saved to your library!`);
    },
    onError: (errors) => {
      console.error('Error saving book:', errors);
      alert('Failed to save book. Please try again.');
    }
  });
}
function unsaveBook() {
  if (!isSaved.value) return;
  router.post(route('books.unsave', { id: book.id }), {}, {
    preserveScroll: true,
    onSuccess: () => {
      // Update local state
      const index = savedBookIds.value.indexOf(book.id);
      if (index > -1) {
        savedBookIds.value.splice(index, 1);
      }
      // Show success notification
      alert(`"${book.title}" has been removed from your saved books.`);
    },
    onError: (errors) => {
      console.error('Error unsaving book:', errors);
      alert('Failed to unsave book. Please try again.');
    }
  });
}
function reportBook() {
  // Placeholder: implement report logic
  alert('Book reported! (feature coming soon)');
}

// Detect file type based on file extension
const fileType = computed(() => {
  if (!book.ebook_file) return null;
  const extension = book.ebook_file.split('.').pop()?.toLowerCase();
  return extension;
});

// Check if it's a PDF file
const isPdf = computed(() => fileType.value === 'pdf');

// Check if it's an EPUB file
const isEpub = computed(() => fileType.value === 'epub');
</script>

<template>
  <Head :title="book.title" />
  <div class="container py-4">
    <div class="mb-3">
      <Link :href="getBackRoute()" class="btn btn-outline-success">
        <i class="bi bi-arrow-left"></i> Back
      </Link>
    </div>
    <div class="row">
      <div class="col-md-4">
        <img :src="book.cover_image || '/images/default.svg'" :alt="book.title" class="img-fluid rounded shadow mb-3 border border-success book-cover-img" />
        <div class="d-flex flex-wrap gap-2 mb-2">
          <button
            v-if="book.ebook_file"
            @click="handleReadNow"
            class="btn btn-success w-100 shadow-sm"
          >
            <i class="bi bi-book"></i> {{ showReader ? 'Hide Reader' : 'Read Now' }}
          </button>
          <Link
            v-if="book.ebook_file"
            :href="route('books.read', { id: book.id, from: 'details' })"
            class="btn btn-outline-success w-100 shadow-sm"
          >
            <i class="bi bi-arrow-up-right"></i> Open in Full Screen
          </Link>
          <button v-if="!isSaved" class="btn btn-outline-success w-100 shadow-sm" @click="saveBook">
            <i class="bi bi-bookmark"></i> Save
          </button>
          <button v-else class="btn btn-outline-warning w-100 shadow-sm" @click="unsaveBook">
            <i class="bi bi-bookmark-x"></i> Unsave
          </button>
          <button class="btn btn-outline-danger w-100 shadow-sm" @click="reportBook">
            <i class="bi bi-flag"></i> Report
          </button>
        </div>
      </div>
      <div class="col-md-8">
        <h2 class="text-success fw-bold d-flex align-items-center gap-2 mb-3"><i class="bi bi-journal-bookmark"></i> {{ book.title }}</h2>
        <p><strong class="text-success">Author:</strong> {{ book.author }}</p>
        <p><strong class="text-success">ISBN:</strong> {{ book.isbn || 'N/A' }}</p>
        <p><strong class="text-success">Published Year:</strong> {{ book.published_year || 'N/A' }}</p>
        <p><strong class="text-success">Publisher:</strong> {{ book.publisher || 'N/A' }}</p>
        <p><strong class="text-success">Language:</strong> {{ book.language || 'N/A' }}</p>
        <p><strong class="text-success">Category:</strong> {{ book.category?.name || 'N/A' }}</p>
        <p><strong class="text-success">Status:</strong> <span :class="book.status === 'active' ? 'text-success fw-semibold' : 'text-danger fw-semibold'">{{ book.status }}</span></p>
        <p><strong class="text-success">Description:</strong></p>
        <div class="mb-3" v-html="book.description || '<em>No description provided.</em>'"></div>
        <p class="text-muted"><small>Added: {{ new Date(book.created_at).toLocaleString() }}</small></p>
        <p class="text-muted"><small>Last Updated: {{ new Date(book.updated_at).toLocaleString() }}</small></p>
        <span v-if="!book.ebook_file" class="text-danger">No eBook file available.</span>
      </div>
    </div>
    <div v-if="showReader && book.ebook_file" class="mt-4">
      <!-- PDF Reader -->
      <PdfReader 
        v-if="isPdf" 
        :url="book.ebook_file" 
      />
      
      <!-- EPUB Reader -->
      <EpubReader 
        v-else-if="isEpub" 
        :url="book.ebook_file" 
      />
      
      <!-- Unsupported file type -->
      <div v-else class="text-center py-5">
        <i class="bi bi-file-earmark-x text-muted" style="font-size: 3rem;"></i>
        <h5 class="text-muted mt-3">Unsupported File Format</h5>
        <p class="text-muted">This file format is not supported for reading in the browser.</p>
        <a :href="book.ebook_file" target="_blank" class="btn btn-outline-success">
          <i class="bi bi-download"></i> Download File
        </a>
      </div>
    </div>
  </div>
</template>

<style scoped>
.book-cover-img {
  border-width: 2px;
  border-radius: 1rem;
  background: #e9fbe9;
}
</style> 