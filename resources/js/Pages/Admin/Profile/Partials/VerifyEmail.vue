<script setup>
import { ref, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

const { props } = usePage()
const user = props.user
const isGoogleUser = user.google_id !== null
const isVerified = computed(() => !!user.email_verified_at)

const form = useForm({
  password: '',
})

const submitting = ref(false)

const submit = () => {
  submitting.value = true
  form.post(route('admin.profile.sendVerificationEmail'), {
    preserveScroll: true,
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: 'Verification Email Sent',
        text: 'A verification email has been sent to your email address.',
        timer: 2000,
        showConfirmButton: false,
      })
      form.reset()
    },
    onError: () => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: form.errors.password || form.errors.message || 'Failed to send verification email.',
      })
    },
    onFinish: () => {
      submitting.value = false
    }
  })
}
</script>

<template>
  <div class="card mb-4 border-success shadow admin-verify-email-card">
    <div class="card-header bg-success text-white d-flex align-items-center gap-2">
      <i class="bi bi-envelope-check"></i> Verify Email
    </div>
    <div class="card-body">
      <div v-if="isVerified" class="alert alert-success mb-3">
        Your email is already verified.
      </div>
      <form @submit.prevent="submit">
        <div v-if="!isGoogleUser && !isVerified" class="mb-3">
          <label class="form-label text-success"><i class="bi bi-key"></i> Password</label>
          <input v-model="form.password" type="password" class="form-control" :disabled="isVerified" />
          <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
        </div>
        <button type="submit" class="btn btn-success w-100 shadow-sm" :disabled="submitting || form.processing || isVerified">
          <i class="bi bi-send"></i> {{ submitting || form.processing ? 'Sending...' : 'Send Verification Email' }}
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.admin-verify-email-card {
  border-width: 2px;
  border-radius: 1.25rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.admin-verify-email-card:focus-within, .admin-verify-email-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style> 