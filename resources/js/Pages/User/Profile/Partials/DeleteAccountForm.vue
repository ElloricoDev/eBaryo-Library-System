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
  <div class="card">
    <div class="card-header"><i class="bi bi-person-x"></i> Delete Account</div>
    <div class="card-body">
      <p>This action is permanent. Please enter your password to confirm.</p>
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-key"></i> Password</label>
          <input type="password" v-model="form.password" class="form-control" />
          <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
        </div>
        <button type="submit" class="btn btn-danger" :disabled="form.processing">
          <i class="bi bi-trash"></i> {{ form.processing ? 'Deleting...' : 'Delete Account' }}
        </button>
      </form>
    </div>
  </div>
</template>
