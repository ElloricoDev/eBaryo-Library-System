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
  <div class="card">
    <div class="card-header"><i class="bi bi-person-x"></i> Delete Account</div>
    <div class="card-body">
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-key"></i> Password</label>
          <input v-model="form.password" type="password" class="form-control" placeholder="Enter your password to confirm" />
          <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
        </div>
        <button type="submit" class="btn btn-danger" :disabled="form.processing">
          <i class="bi bi-trash"></i> {{ form.processing ? 'Deleting...' : 'Delete Account' }}
        </button>
      </form>
    </div>
  </div>
</template>
