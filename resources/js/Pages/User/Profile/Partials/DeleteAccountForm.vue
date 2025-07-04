<script setup>
import { useForm } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

const form = useForm({
  password: ''
})

const submit = async () => {
  const result = await Swal.fire({
    title: 'Are you sure?',
    text: 'This action is permanent. Your account will be deleted.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel',
  })
  if (result.isConfirmed) {
    form.delete(route('user.profile.destroy'), {
      preserveScroll: true,
      onError: () => {
        // Optionally, you can show a SweetAlert error here if you want
      }
    })
  }
}
</script>

<template>
  <div class="card border-success shadow delete-account-card">
    <div class="card-header bg-success text-white d-flex align-items-center gap-2">
      <i class="bi bi-person-x"></i> Delete Account
    </div>
    <div class="card-body">
      <p>This action is permanent. Please enter your password to confirm.</p>
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label text-success"><i class="bi bi-key"></i> Password</label>
          <input type="password" v-model="form.password" class="form-control" />
          <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
        </div>
        <button type="submit" class="btn btn-danger w-100 shadow-sm" :disabled="form.processing">
          <i class="bi bi-trash"></i> {{ form.processing ? 'Deleting...' : 'Delete Account' }}
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.delete-account-card {
  border-width: 2px;
  border-radius: 1.25rem;
  margin-top: 24px;
  margin-bottom: 24px;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.delete-account-card:focus-within, .delete-account-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
