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
    <div class="card shadow forgot-card border-success mx-auto" style="max-width: 400px; width: 100%;">
      <div class="card-body">
        <h1 class="mb-4 text-center text-success-emphasis">
          <i class="bi bi-envelope me-2 text-success"></i>Forgot Password
        </h1>
        <form @submit.prevent="form.post(route('password.email'))">
          <div class="mb-3">
            <label for="email" class="form-label text-success"><i class="bi bi-envelope"></i> Email</label>
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
            <button type="submit" class="btn btn-success shadow-sm" :disabled="form.processing">
              <i class="bi bi-send"></i> {{ form.processing ? 'Sending...' : 'Send Password Reset Link' }}
            </button>
          </div>
          <div v-if="$page.props.status" class="alert alert-success">
            {{ $page.props.status }}
          </div>
        </form>
        <div class="text-center mt-3">
          <Link :href="route('login')" class="d-block text-success text-center mt-3">
            <i class="bi bi-box-arrow-in-right"></i> Back to Login
          </Link>
        </div>
        <div class="text-center mt-2">
          <Link :href="route('register')" class="d-block text-success text-center mt-2">
            <i class="bi bi-person-plus"></i> Don't have an account? Register
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.forgot-card {
  border-width: 2px;
  border-radius: 1.25rem;
  margin-top: 48px;
  margin-bottom: 48px;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.forgot-card:focus-within, .forgot-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style> 