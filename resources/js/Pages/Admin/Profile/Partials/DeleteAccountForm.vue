<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

const { props } = usePage()
const user = props.user

const form = useForm({
  password: '',
})

const submit = () => {
  form.delete(route('admin.profile.destroy'), {
    preserveScroll: true,
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: 'Account Deleted',
        text: 'Your account has been successfully deleted.',
        timer: 2000,
        showConfirmButton: false,
      })
    }
  })
}
</script>

<template>
  <div class="card border-success shadow admin-delete-account-card">
    <div class="card-header bg-success text-white d-flex align-items-center gap-2">
      <i class="bi bi-person-x"></i> Delete Account
    </div>
    <div class="card-body">
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label text-success"><i class="bi bi-key"></i> Password</label>
          <input v-model="form.password" type="password" class="form-control" placeholder="Enter your password to confirm" />
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
.admin-delete-account-card {
  border-width: 2px;
  border-radius: 1.25rem;
  margin-top: 24px;
  margin-bottom: 24px;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.admin-delete-account-card:focus-within, .admin-delete-account-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
