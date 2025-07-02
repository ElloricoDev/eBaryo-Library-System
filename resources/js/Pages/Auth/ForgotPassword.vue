<script setup>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const form = useForm({
  email: ''
})

defineOptions({
  layout: GuestLayout
})
</script>

<template>
  <Head title="Forgot Password" />
  <div class="container d-flex justify-content-center align-items-center">
    <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
      <div class="card-body">
        <h1 class="mb-4 text-center"><i class="bi bi-envelope"></i> Forgot Password</h1>
        <form @submit.prevent="form.post(route('password.email'))">
          <div class="mb-3">
            <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email</label>
            <input
              v-model="form.email"
              type="email"
              id="email"
              class="form-control"
              :class="{ 'is-invalid': form.errors.email }"
              required
              autofocus
            />
            <div v-if="form.errors.email" class="invalid-feedback">
              {{ form.errors.email }}
            </div>
          </div>
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary" :disabled="form.processing">
              <i class="bi bi-send"></i> {{ form.processing ? 'Sending...' : 'Send Password Reset Link' }}
            </button>
          </div>
          <div v-if="$page.props.status" class="alert alert-success">
            {{ $page.props.status }}
          </div>
        </form>
        <div class="text-center mt-3">
          <Link :href="route('login')" class="d-block text-center mt-3">
            <i class="bi bi-box-arrow-in-right"></i> Back to Login
          </Link>
        </div>
        <div class="text-center mt-2">
          <Link :href="route('register')" class="d-block text-center mt-2">
            <i class="bi bi-person-plus"></i> Don't have an account? Register
          </Link>
        </div>
      </div>
    </div>
  </div>
</template> 