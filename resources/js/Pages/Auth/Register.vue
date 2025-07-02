<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const submit = () => {
  form.post(route('register'))
}
</script>

<template>
  <Head title="Register" />
  <GuestLayout>
    <div class="card shadow-sm" style="max-width: 500px; width: 100%;">
      <div class="card-body">
        <h3 class="mb-4 text-center">Create an Account</h3>

        

        <form @submit.prevent="submit">
          <!-- Name -->
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input
              v-model="form.name"
              type="text"
              id="name"
              class="form-control"
              :class="{ 'is-invalid': form.errors.name }"
              required
              autofocus
            />
            <div v-if="form.errors.name" class="invalid-feedback">
              {{ form.errors.name }}
            </div>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input
              v-model="form.email"
              type="email"
              id="email"
              class="form-control"
              :class="{ 'is-invalid': form.errors.email }"
              required
            />
            <div v-if="form.errors.email" class="invalid-feedback">
              {{ form.errors.email }}
            </div>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              v-model="form.password"
              type="password"
              id="password"
              class="form-control"
              :class="{ 'is-invalid': form.errors.password }"
              required
            />
            <div v-if="form.errors.password" class="invalid-feedback">
              {{ form.errors.password }}
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              id="password_confirmation"
              class="form-control"
              required
            />
          </div>

          <!-- Submit Button -->
          <div class="mb-3 d-grid">
            <button type="submit" class="btn btn-primary" :disabled="form.processing">
              {{ form.processing ? 'Registering...' : 'Register' }}
            </button>
          </div>
          <div class=" d-grid">
          <a :href="route('google.redirect')" class="btn btn-outline-danger w-100 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48" style="vertical-align:middle; margin-right:8px;"><g><path fill="#4285F4" d="M24 9.5c3.54 0 6.7 1.22 9.19 3.22l6.85-6.85C35.82 2.36 30.28 0 24 0 14.82 0 6.73 5.8 2.69 14.09l7.98 6.2C12.36 13.09 17.74 9.5 24 9.5z"/><path fill="#34A853" d="M46.1 24.55c0-1.64-.15-3.22-.42-4.74H24v9.01h12.42c-.54 2.9-2.18 5.36-4.65 7.01l7.19 5.6C43.98 37.36 46.1 31.36 46.1 24.55z"/><path fill="#FBBC05" d="M10.67 28.29c-1.13-3.36-1.13-6.93 0-10.29l-7.98-6.2C.64 16.36 0 20.09 0 24s.64 7.64 2.69 12.2l7.98-6.2z"/><path fill="#EA4335" d="M24 48c6.28 0 11.56-2.09 15.41-5.7l-7.19-5.6c-2.01 1.35-4.59 2.15-8.22 2.15-6.26 0-11.64-3.59-13.33-8.79l-7.98 6.2C6.73 42.2 14.82 48 24 48z"/><path fill="none" d="M0 0h48v48H0z"/></g></svg>
            Sign in with Google
          </a>
        </div>
        </form>
      </div>
      <div class="text-center mt-3 mb-3">
        <span>Already have an account?</span>
        <Link :href="route('login')" class="ms-1">Login</Link>
      </div>
    </div>
  </GuestLayout>
</template>
