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
        <h1 class="mb-4 text-center"><i class="bi bi-person-plus"></i> Register</h1>

        

        <form @submit.prevent="submit">
          <!-- Name -->
          <div class="mb-3">
            <label for="name" class="form-label"><i class="bi bi-person"></i> Full Name</label>
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
            <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email address</label>
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
            <label for="password" class="form-label"><i class="bi bi-lock"></i> Password</label>
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
            <label for="password_confirmation" class="form-label"><i class="bi bi-lock"></i> Confirm Password</label>
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
            <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">
              <i class="bi bi-person-plus"></i> {{ form.processing ? 'Registering...' : 'Register' }}
            </button>
          </div>
          <div class=" d-grid">
          <a :href="route('google.redirect')" class="btn btn-outline-danger w-100 mb-2">
            <i class="bi bi-google"></i>
            Sign in with Google
          </a>
        </div>
        </form>
      </div>
      <div class="text-center mt-3 mb-3">
        <i class="bi bi-box-arrow-in-right"></i>
        <Link :href="route('login')" class="ms-1">Login</Link>
      </div>
    </div>
  </GuestLayout>
</template>
