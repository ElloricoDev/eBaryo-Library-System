<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

const { props } = usePage()
const user = props.user
const isGoogleUser = user.google_id !== null

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.put(route('admin.profile.password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset(),
      Swal.fire({
        icon: 'success',
        title: 'Password Updated',
        text: 'Your password has been successfully updated.',
        timer: 2000,
        showConfirmButton: false,
      })
    }
  })
}
</script>

<template>
  <div class="card mb-4">
    <div class="card-header">Update Password</div>
    <div class="card-body">
      <div v-if="isGoogleUser" class="alert alert-info">
        You cannot change your password because you signed in using Google.
      </div>
      <form v-else @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label">Current Password</label>
          <input v-model="form.current_password" type="password" class="form-control" />
          <div v-if="form.errors.current_password" class="text-danger">{{ form.errors.current_password }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">New Password</label>
          <input v-model="form.password" type="password" class="form-control" />
          <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Confirm New Password</label>
          <input v-model="form.password_confirmation" type="password" class="form-control" />
        </div>

        <button type="submit" class="btn btn-danger" :disabled="form.processing">
          {{ form.processing ? 'Updating...' : 'Update Password' }}
        </button>
      </form>
    </div>
  </div>
</template>
