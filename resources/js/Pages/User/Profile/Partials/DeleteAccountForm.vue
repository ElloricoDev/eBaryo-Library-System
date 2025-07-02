<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  password: ''
})

const submit = () => {
  if (confirm('Are you sure you want to delete your account?')) {
    form.delete(route('profile.destroy'))
  }
}
</script>

<template>
  <div>
    <h4 class="text-danger">Delete Account</h4>
    <p>This action is permanent. Please enter your password to confirm.</p>
    <form @submit.prevent="submit">
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" v-model="form.password" class="form-control" />
      </div>
      <button type="submit" class="btn btn-danger" :disabled="form.processing">
        {{ form.processing ? 'Deleting...' : 'Delete Account' }}
      </button>
    </form>
  </div>
</template>
