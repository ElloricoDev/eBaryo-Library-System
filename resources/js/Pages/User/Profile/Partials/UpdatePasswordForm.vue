<script setup>
import { useForm, usePage } from '@inertiajs/vue3'

const { props } = usePage()
const user = props.user
const isGoogleUser = user.google_id !== null

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: ''
})

const submit = () => {
  form.put(route('password.update'))
}
</script>

<template>
  <div>
    <h4>Change Password</h4>
    <div v-if="isGoogleUser" class="alert alert-info">
      You cannot change your password because you signed in using Google.
    </div>
    <form v-else @submit.prevent="submit">
      <div class="mb-3">
        <label class="form-label">Current Password</label>
        <input type="password" v-model="form.current_password" class="form-control" />
      </div>
      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" v-model="form.password" class="form-control" />
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm New Password</label>
        <input type="password" v-model="form.password_confirmation" class="form-control" />
      </div>
      <button type="submit" class="btn btn-warning" :disabled="form.processing">
        {{ form.processing ? 'Updating...' : 'Update Password' }}
      </button>
    </form>
  </div>
</template>
