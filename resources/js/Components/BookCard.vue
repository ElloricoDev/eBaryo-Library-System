<script setup>
import {  router } from '@inertiajs/vue3';
import { computed } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
  book: {
    type: Object,
    required: true
  },
  isSaved: {
    type: Boolean,
    required: true
  }
});

const emit = defineEmits(['save', 'unsave', 'report']);

// Compute the avatar URL, fallback to default if not present
const avatarUrl = computed(() => {
  return props.book.cover_image || '/images/default.svg';
});

const goToRead = () => {
  let from = props.book.from || null;
  let params = { id: props.book.id };
  if (from) {
    params.from = from;
  }
  router.visit(route('books.read', params), { preserveScroll: true });
};

const handleSave = () => {
  // Emit save event and show toast
  emit('save', props.book);
  Swal.fire({
    icon: 'success',
    title: 'Book saved!',
    text: `"${props.book.title}" has been added to your saved books.`,
    timer: 1500,
    showConfirmButton: false
  });
};

const handleUnsave = () => {
  // Show confirmation before unsaving
  Swal.fire({
    title: 'Unsave this book?',
    text: `Are you sure you want to remove "${props.book.title}" from your saved books?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Unsave',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      emit('unsave', props.book);
      Swal.fire({
        icon: 'success',
        title: 'Book unsaved!',
        text: `"${props.book.title}" has been removed from your saved books.`,
        timer: 1500,
        showConfirmButton: false
      });
    }
  });
};
</script>

<template>
  <div class="card h-100 border-success shadow book-card" style="max-width: 220px; min-width: 180px;">
    <img :src="avatarUrl" class="card-img-top book-card-img" alt="Book Avatar">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title text-success fw-bold">{{ book.title }}</h5>
      <p class="card-text mb-2"><strong class="text-success">Author:</strong> {{ book.author || 'Unknown' }}</p>
      <div class="mt-auto d-flex flex-wrap gap-2">
        <button class="btn btn-success btn-sm shadow-sm" @click="goToRead">
          <i class="bi bi-book"></i> Read
        </button>
        <Link :href="route('books.view', { id: book.id })" class="btn btn-outline-success btn-sm shadow-sm">
          <i class="bi bi-eye"></i> View Details
        </Link>
        <button
          v-if="!isSaved"
          class="btn btn-outline-success btn-sm shadow-sm"
          @click="handleSave"
        >
          <i class="bi bi-bookmark"></i> Save
        </button>
        <button
          v-else
          class="btn btn-outline-warning btn-sm shadow-sm"
          @click="handleUnsave"
        >
          <i class="bi bi-bookmark-x"></i> Unsave
        </button>
        <button class="btn btn-outline-danger btn-sm shadow-sm" @click="$emit('report', book)">
          <i class="bi bi-flag"></i> Report
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.book-card {
  border-width: 2px;
  border-radius: 1rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.book-card:focus-within, .book-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
.book-card-img {
  object-fit: cover;
  height: 140px;
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
}
</style> 