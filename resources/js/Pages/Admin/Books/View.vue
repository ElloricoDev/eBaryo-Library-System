<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import PdfReader from '@/Components/PdfReader.vue';
import EpubReader from '@/Components/EpubReader.vue';

defineOptions({ layout: AdminLayout })

const { props } = usePage();
const book = props.book;

const fileExt = computed(() => {
  if (!book.ebook_file) return '';
  return book.ebook_file.split('.').pop().toLowerCase();
});

// Check if it's a PDF file
const isPdf = computed(() => fileExt.value === 'pdf');

// Check if it's an EPUB file
const isEpub = computed(() => fileExt.value === 'epub');
</script>

<template>
  <div class="container py-4">
    <div class="d-flex align-items-center mb-4">
      <Link :href="route('admin.books.index')" class="btn btn-success me-3 shadow-sm rounded-pill px-4 py-2 fw-semibold">
        <i class="bi bi-arrow-left"></i> Back
      </Link>
      <h1 class="fs-3 fw-bold mb-0 text-success"><i class="bi bi-eye"></i> Book Details</h1>
    </div>
    <div class="card mb-4 border-success shadow rounded-4">
      <div class="row g-0">
        <div class="col-md-3 d-flex align-items-center justify-content-center p-3 bg-light rounded-start-4">
          <img v-if="book.cover_image" :src="book.cover_image" alt="Cover" class="img-fluid rounded border border-success shadow-sm" style="max-height: 200px; object-fit: contain; background: #fff;" />
          <div v-else class="text-muted text-center"><i class="bi bi-image fs-1"></i><br>No Cover</div>
        </div>
        <div class="col-md-9">
          <div class="card-body">
            <h3 class="card-title mb-2 text-success"><i class="bi bi-book"></i> {{ book.title || 'N/A' }}</h3>
            <div class="row mb-1">
              <div class="col-6"><strong><i class="bi bi-person"></i> Author:</strong> {{ book.author || 'N/A' }}</div>
              <div class="col-6"><strong><i class="bi bi-tags"></i> Category:</strong> {{ book.category ? book.category.name : 'N/A' }}</div>
            </div>
            <div class="row mb-1">
              <div class="col-6"><strong><i class="bi bi-building"></i> Publisher:</strong> {{ book.publisher || 'N/A' }}</div>
              <div class="col-6"><strong><i class="bi bi-translate"></i> Language:</strong> {{ book.language || 'N/A' }}</div>
            </div>
            <div class="row mb-1">
              <div class="col-6"><strong><i class="bi bi-upc"></i> ISBN:</strong> {{ book.isbn || 'N/A' }}</div>
              <div class="col-6"><strong><i class="bi bi-calendar"></i> Published Year:</strong> {{ book.published_year || 'N/A' }}</div>
            </div>
            <div class="row mb-1">
              <div class="col-6"><strong><i class="bi bi-info-circle"></i> Status:</strong> <span :class="book.status === 'active' ? 'text-success fw-bold' : 'text-danger fw-bold'">{{ book.status ? (book.status.charAt(0).toUpperCase() + book.status.slice(1)) : 'N/A' }}</span></div>
            </div>
            <div class="mb-2"><strong><i class="bi bi-card-text"></i> Description:</strong> <span class="text-secondary">{{ book.description || 'N/A' }}</span></div>
            <div class="mb-1"><strong><i class="bi bi-file-earmark"></i> Ebook File:</strong>
              <span v-if="book.ebook_file">
                <a :href="book.ebook_file" target="_blank" class="link-success fw-semibold"><i class="bi bi-file-earmark"></i> {{ book.ebook_file }}</a>
              </span>
              <span v-else class="text-muted">N/A</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card border-success shadow rounded-4">
      <div class="card-header bg-success text-white rounded-top-4"><i class="bi bi-file-earmark"></i> Read Ebook</div>
      <div class="card-body bg-light rounded-bottom-4">
        <!-- PDF Reader -->
        <PdfReader 
          v-if="isPdf && book.ebook_file" 
          :url="book.ebook_file" 
        />
        
        <!-- EPUB Reader -->
        <EpubReader 
          v-else-if="isEpub && book.ebook_file" 
          :url="book.ebook_file" 
        />
        
        <!-- Unsupported file type -->
        <div v-else-if="book.ebook_file">
          <div class="text-center py-5">
            <i class="bi bi-file-earmark-x text-muted" style="font-size: 3rem;"></i>
            <h5 class="text-muted mt-3">Unsupported File Format</h5>
            <p class="text-muted">This file format is not supported for reading in the browser.</p>
            <a :href="book.ebook_file" target="_blank" class="btn btn-outline-success">
              <i class="bi bi-download"></i> Download File
            </a>
          </div>
        </div>
        
        <!-- No file -->
        <div v-else class="text-center py-5">
          <i class="bi bi-file-earmark-x text-muted" style="font-size: 3rem;"></i>
          <h5 class="text-muted mt-3">No Ebook File</h5>
          <p class="text-muted">No ebook file has been uploaded for this book.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  border-radius: 1.25rem;
  box-shadow: 0 2px 16px rgba(0,128,0,0.08);
}
.card-header {
  font-weight: 600;
  font-size: 1.1rem;
  letter-spacing: 0.5px;
}
.btn-success {
  transition: background 0.2s, box-shadow 0.2s;
}
.btn-success:hover, .btn-success:focus {
  background: #218838;
  box-shadow: 0 2px 8px rgba(40,167,69,0.15);
}
.link-success {
  text-decoration: underline;
}
</style>