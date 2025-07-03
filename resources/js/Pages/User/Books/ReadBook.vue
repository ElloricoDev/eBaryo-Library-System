<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { usePage, Head, Link, router } from '@inertiajs/vue3';
import EpubReader from '@/Components/EpubReader.vue';

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
</script>

<template>
  <Head :title="`Read: ${book.title}`" />
  <div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-outline-secondary" @click="goBack">
        <i class="bi bi-arrow-left"></i> Back
      </button>
      <h4 class="mb-0">{{ book.title }}</h4>
      <span></span>
    </div>
    <div class="bg-white rounded shadow p-2" style="min-height: 80vh;">
      <EpubReader :url="book.ebook_file" @update:percent="saveProgress" :startPercent="lastPercent" />
    </div>
  </div>
</template>
