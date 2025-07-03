<script setup>
import {  router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  book: {
    type: Object,
    required: true
  }
});

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
</script>

<template>
  <div class="card h-100" style="max-width: 220px; min-width: 180px;">
    <img :src="avatarUrl" class="card-img-top" alt="Book Avatar" style="object-fit:cover; height:140px;">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">{{ book.title }}</h5>
      <p class="card-text mb-2"><strong>Author:</strong> {{ book.author || 'Unknown' }}</p>
      <div class="mt-auto d-flex flex-wrap gap-2">
        <button class="btn btn-primary btn-sm" @click="goToRead">
          <i class="bi bi-book"></i> Read
        </button>
        <Link :href="route('books.view', { id: book.id })" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-eye"></i> View Details
        </Link>
        <button class="btn btn-outline-success btn-sm" @click="$emit('save', book)">
          <i class="bi bi-bookmark"></i> Saved
        </button>
        <button class="btn btn-outline-danger btn-sm" @click="$emit('report', book)">
          <i class="bi bi-flag"></i> Report
        </button>
      </div>
    </div>
  </div>
</template> 