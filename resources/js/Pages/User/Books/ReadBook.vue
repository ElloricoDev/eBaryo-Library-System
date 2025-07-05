<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { usePage, Head, Link, router } from '@inertiajs/vue3';
import EpubReader from '@/Components/EpubReader.vue';
import PdfReader from '@/Components/PdfReader.vue';
import { computed } from 'vue';

defineOptions({ layout: UserLayout });
const { props, url } = usePage();
const book = props.book;
const lastPercent = props.lastPercent || 0;

// Get the 'from' query parameter
const from = new URLSearchParams(window.location.search).get('from');

const saveProgress = (percent) => {
  router.post( 
    route('books.saveProgress', { id: book.id }),
    { percent },
    { preserveState: true, preserveScroll: true, replace: true }
  );
};

const goBack = () => {
  if (window.history.length > 1) {
    window.history.back();
  } else if (from === 'list') {
    router.visit(route('books.index'));
  } else if (from === 'home') {
    router.visit(route('home'));
  } else {
    router.visit(route('books.view', { id: book.id }));
  }
};

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
  <Head :title="`Read: ${book.title}`" />
  <div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-outline-success" @click="goBack">
        <i class="bi bi-arrow-left"></i> Back
      </button>
      <h4 class="mb-0 text-success fw-bold d-flex align-items-center gap-2"><i class="bi bi-journal-bookmark"></i> {{ book.title }}</h4>
      <span></span>
    </div>
    <div class="bg-white rounded shadow p-2 border border-success reading-area" style="min-height: 80vh;">
      <!-- PDF Reader -->
      <PdfReader 
        v-if="isPdf" 
        :url="book.ebook_file" 
        @update:percent="saveProgress" 
        :startPercent="lastPercent" 
      />
      
      <!-- EPUB Reader -->
      <EpubReader 
        v-else-if="isEpub" 
        :url="book.ebook_file" 
        @update:percent="saveProgress" 
        :startPercent="lastPercent" 
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
.reading-area {
  border-width: 2px;
  border-radius: 1.25rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.reading-area:focus-within, .reading-area:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
