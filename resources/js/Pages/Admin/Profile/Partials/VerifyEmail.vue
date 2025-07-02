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
  <div class="card mb-4">
    <div class="card-header">Verify Email</div>
    <div class="card-body">
      <div v-if="isVerified" class="alert alert-success mb-3">
        Your email is already verified.
      </div>
      <form @submit.prevent="submit">
        <div v-if="!isGoogleUser && !isVerified" class="mb-3">
          <label class="form-label">Password</label>
          <input v-model="form.password" type="password" class="form-control" :disabled="isVerified" />
          <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="submitting || form.processing || isVerified">
          {{ submitting || form.processing ? 'Sending...' : 'Send Verification Email' }}
        </button>
      </form>
    </div>
  </div>
</template> 