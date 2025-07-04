<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

const { props } = usePage()
const user = props.user
const isGoogleUser = user.google_id !== null

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: ''
})

const submit = () => {
  form.put(route('password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: 'Password Updated',
        text: 'Your password has been successfully updated.',
        timer: 2000,
        showConfirmButton: false,
      })
      form.reset()
    }
  })
}
</script>

<template>
  <div class="card mb-4 border-success shadow update-password-card">
    <div class="card-header bg-success text-white d-flex align-items-center gap-2">
      <i class="bi bi-shield-lock"></i> Update Password
    </div>
    <div class="card-body">
      <div v-if="isGoogleUser" class="alert alert-info">
        You cannot change your password because you signed in using Google.
      </div>
      <form v-else @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label text-success"><i class="bi bi-key"></i> Current Password</label>
          <input v-model="form.current_password" type="password" class="form-control" />
          <div v-if="form.errors.current_password" class="text-danger">{{ form.errors.current_password }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-success"><i class="bi bi-key"></i> New Password</label>
          <input v-model="form.password" type="password" class="form-control" />
          <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-success"><i class="bi bi-key"></i> Confirm New Password</label>
          <input v-model="form.password_confirmation" type="password" class="form-control" />
        </div>

        <button type="submit" class="btn btn-success w-100 shadow-sm" :disabled="form.processing">
          <i class="bi bi-arrow-repeat"></i> {{ form.processing ? 'Updating...' : 'Update Password' }}
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.update-password-card {
  border-width: 2px;
  border-radius: 1.25rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.update-password-card:focus-within, .update-password-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
