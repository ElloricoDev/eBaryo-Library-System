<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
// import EpubViewer from 'vue-epubjs' // Uncomment if you install vue-epubjs

defineOptions({ layout: AdminLayout })

const { props } = usePage();
const book = props.book;

const fileExt = computed(() => {
  if (!book.ebook_file) return '';
  return book.ebook_file.split('.').pop().toLowerCase();
});
</script>

<template>
  <div class="container py-4">
    <div class="d-flex align-items-center mb-4">
      <Link :href="route('admin.books.index')" class="btn btn-secondary me-3">
        <i class="bi bi-arrow-left"></i> Back
      </Link>
      <h1 class="fs-3 fw-bold mb-0"><i class="bi bi-eye"></i> Book Details</h1>
    </div>
    <div class="card mb-4">
      <div class="row g-0">
        <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
          <img v-if="book.cover_image" :src="book.cover_image" alt="Cover" class="img-fluid rounded border" style="max-height: 200px; object-fit: contain;" />
          <div v-else class="text-muted"><i class="bi bi-image"></i> No Cover</div>
        </div>
        <div class="col-md-9">
          <div class="card-body">
            <h3 class="card-title mb-2"><i class="bi bi-book"></i> {{ book.title || 'N/A' }}</h3>
            <p class="mb-1"><strong><i class="bi bi-person"></i> Author:</strong> {{ book.author || 'N/A' }}</p>
            <p class="mb-1"><strong><i class="bi bi-tags"></i> Category:</strong> {{ book.category ? book.category.name : 'N/A' }}</p>
            <p class="mb-1"><strong><i class="bi bi-building"></i> Publisher:</strong> {{ book.publisher || 'N/A' }}</p>
            <p class="mb-1"><strong><i class="bi bi-translate"></i> Language:</strong> {{ book.language || 'N/A' }}</p>
            <p class="mb-1"><strong><i class="bi bi-upc"></i> ISBN:</strong> {{ book.isbn || 'N/A' }}</p>
            <p class="mb-1"><strong><i class="bi bi-calendar"></i> Published Year:</strong> {{ book.published_year || 'N/A' }}</p>
            <p class="mb-1"><strong><i class="bi bi-info-circle"></i> Status:</strong> <span :class="book.status === 'active' ? 'text-success' : 'text-danger'">{{ book.status ? (book.status.charAt(0).toUpperCase() + book.status.slice(1)) : 'N/A' }}</span></p>
            <p class="mb-2"><strong><i class="bi bi-card-text"></i> Description:</strong> {{ book.description || 'N/A' }}</p>
            <p class="mb-1"><strong><i class="bi bi-file-earmark"></i> Ebook File:</strong>
              <span v-if="book.ebook_file">
                <a :href="book.ebook_file" target="_blank"><i class="bi bi-file-earmark"></i> {{ book.ebook_file }}</a>
              </span>
              <span v-else>N/A</span>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><i class="bi bi-file-earmark"></i> Read Ebook</div>
      <div class="card-body">
        <div v-if="book.ebook_file && fileExt === 'pdf'">
          <iframe :src="book.ebook_file" width="100%" height="700px" style="border:none;"></iframe>
        </div>
        <!--
        <div v-else-if="book.ebook_file && fileExt === 'epub'">
          <EpubViewer :src="book.ebook_file" style="height: 700px;" />
        </div>
        -->
        <div v-else>
          <p>
            <span v-if="book.ebook_file">
              <i class="bi bi-file-earmark"></i> Unsupported file format. <a :href="book.ebook_file" target="_blank" class="btn btn-primary"><i class="bi bi-download"></i> Download</a>
            </span>
            <span v-else>N/A</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>