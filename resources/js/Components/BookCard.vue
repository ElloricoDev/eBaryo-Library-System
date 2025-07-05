<script setup>
import { router, Link } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
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

// Report modal state
const showReportModal = ref(false);
const reportReason = ref('');
const reportDescription = ref('');
const isSubmittingReport = ref(false);

// Computed property for save status that updates when prop changes
const isBookSaved = computed(() => props.isSaved);

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
  if (isBookSaved.value) return;
  
  // Emit save event
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
  if (!isBookSaved.value) return;
  
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
      // Emit unsave event
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

const handleReport = () => {
  showReportModal.value = true;
};

const submitReport = () => {
  if (!reportReason.value.trim()) {
    Swal.fire({
      icon: 'error',
      title: 'Reason Required',
      text: 'Please provide a reason for reporting this book.',
    });
    return;
  }

  isSubmittingReport.value = true;

  router.post(route('books.report', { bookId: props.book.id }), {
    reason: reportReason.value,
    description: reportDescription.value,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      showReportModal.value = false;
      reportReason.value = '';
      reportDescription.value = '';
      Swal.fire({
        icon: 'success',
        title: 'Report Submitted',
        text: 'Thank you for your report. We will review it shortly.',
        timer: 2000,
        showConfirmButton: false,
      });
    },
    onError: (errors) => {
      console.error('Error submitting report:', errors);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Failed to submit report. Please try again.',
      });
    },
    onFinish: () => {
      isSubmittingReport.value = false;
    },
  });
};

const closeReportModal = () => {
  showReportModal.value = false;
  reportReason.value = '';
  reportDescription.value = '';
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
        <Link :href="route('books.view', { id: book.id, from: book.from || 'books' })" class="btn btn-outline-success btn-sm shadow-sm">
          <i class="bi bi-eye"></i> View Details
        </Link>
        <button
          v-if="!isBookSaved"
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
        <button class="btn btn-outline-danger btn-sm shadow-sm" @click="handleReport">
          <i class="bi bi-flag"></i> Report
        </button>
      </div>
    </div>
  </div>

  <!-- Report Modal -->
  <div v-if="showReportModal" class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-success">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">
            <i class="bi bi-flag"></i> Report Book
          </h5>
          <button type="button" class="btn-close btn-close-white" @click="closeReportModal"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted mb-3">Please provide a reason for reporting "<strong>{{ book.title }}</strong>":</p>
          
          <div class="mb-3">
            <label class="form-label text-success">
              <i class="bi bi-exclamation-triangle"></i> Reason <span class="text-danger">*</span>
            </label>
            <select v-model="reportReason" class="form-control" required>
              <option value="">Select a reason</option>
              <option value="Inappropriate content">Inappropriate content</option>
              <option value="Copyright violation">Copyright violation</option>
              <option value="Poor quality">Poor quality</option>
              <option value="Broken file">Broken file</option>
              <option value="Wrong category">Wrong category</option>
              <option value="Spam">Spam</option>
              <option value="Other">Other</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label class="form-label text-success">
              <i class="bi bi-card-text"></i> Additional Details (Optional)
            </label>
            <textarea 
              v-model="reportDescription" 
              class="form-control" 
              rows="3" 
              placeholder="Please provide any additional details about your report..."
              maxlength="1000"
            ></textarea>
            <div class="form-text text-muted">
              {{ reportDescription.length }}/1000 characters
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" @click="closeReportModal">
            <i class="bi bi-x-circle"></i> Cancel
          </button>
          <button 
            type="button" 
            class="btn btn-danger" 
            @click="submitReport"
            :disabled="isSubmittingReport || !reportReason.trim()"
          >
            <i v-if="isSubmittingReport" class="bi bi-hourglass-split"></i>
            <i v-else class="bi bi-flag"></i>
            {{ isSubmittingReport ? 'Submitting...' : 'Submit Report' }}
          </button>
        </div>
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