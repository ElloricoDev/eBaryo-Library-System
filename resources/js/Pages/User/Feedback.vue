<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import Swal from 'sweetalert2';

defineOptions({layout: UserLayout});

const form = useForm({
  message: ''
});

function submit() {
  form.post(route('feedback.store'), {
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: 'Thank you!',
        text: 'Your feedback has been submitted.',
        timer: 2000,
        showConfirmButton: false
      });
      form.reset();
    }
  });
}
</script>

<template>
  <Head title="Submit Feedback" />
  <div class="container py-4">
    <h1 class="fs-3 fw-bold mb-4 text-success d-flex align-items-center gap-2">
      <i class="bi bi-chat-dots"></i> Submit Feedback
    </h1>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card border-success shadow feedback-card">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="mb-3">
                <label for="message" class="form-label text-success">Your Feedback</label>
                <textarea v-model="form.message" id="message" class="form-control" rows="5"></textarea>
                <div v-if="form.errors.message" class="text-danger small">{{ form.errors.message }}</div>
              </div>
              <button type="submit" class="btn btn-success w-100 shadow-sm" :disabled="form.processing">Submit</button>
            </form>
            <div v-if="$page.props.flash?.success" class="alert alert-success mt-3">
              {{ $page.props.flash.success }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.feedback-card {
  border-width: 2px;
  border-radius: 1.25rem;
  margin-top: 24px;
  margin-bottom: 24px;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.feedback-card:focus-within, .feedback-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style> 