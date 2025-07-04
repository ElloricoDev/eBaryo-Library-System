<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
  user_name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const submit = () => {
  form.post(route('register'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
    onError: (errors) => {
      Object.keys(errors).forEach((field) => {
        form[field] = '';
      });
    }
  });
}
</script>

<template>
  <Head title="Register" />
  <GuestLayout>
    <div class="card shadow register-card border-success mx-auto" style="max-width: 400px; width: 100%;">
      <div class="card-body">
        <h1 class="mb-4 text-center text-success-emphasis">
          <i class="bi bi-person-plus me-2 text-success"></i>Register
        </h1>

        <form @submit.prevent="submit">
          <!-- Name -->
          <div class="mb-3">
            <label for="name" class="form-label text-success"><i class="bi bi-person"></i> Full Name</label>
            <input
              v-model="form.user_name"
              type="text"
              id="name"
              class="form-control"
              :class="{ 'is-invalid': form.errors.user_name }"
              autofocus
            />
            <div v-if="form.errors.user_name" class="invalid-feedback">
              {{ form.errors.user_name }}
            </div>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label text-success"><i class="bi bi-envelope"></i> Email address</label>
            <input
              v-model="form.email"
              type="email"
              id="email"
              class="form-control"
              :class="{ 'is-invalid': form.errors.email }"
            />
            <div v-if="form.errors.email" class="invalid-feedback">
              {{ form.errors.email }}
            </div>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label for="password" class="form-label text-success"><i class="bi bi-lock"></i> Password</label>
            <input
              v-model="form.password"
              type="password"
              id="password"
              class="form-control"
              :class="{ 'is-invalid': form.errors.password }"
            />
            <div v-if="form.errors.password" class="invalid-feedback">
              {{ form.errors.password }}
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-4">
            <label for="password_confirmation" class="form-label text-success"><i class="bi bi-lock"></i> Confirm Password</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              id="password_confirmation"
              class="form-control"
            />
          </div>

          <!-- Submit Button -->
          <div class="mb-3 d-grid">
            <button type="submit" class="btn btn-success w-100 shadow-sm" :disabled="form.processing">
              <i class="bi bi-person-plus"></i> {{ form.processing ? 'Registering...' : 'Register' }}
            </button>
          </div>
          <div class="d-grid">
            <a :href="route('google.redirect')" class="btn btn-outline-success w-100 mb-2">
              <i class="bi bi-google"></i>
              Sign in with Google
            </a>
          </div>
        </form>
      </div>
      <div class="text-center mt-3 mb-3">
        <i class="bi bi-box-arrow-in-right text-success"></i>
        <Link :href="route('login')" class="ms-1 text-success">Login</Link>
      </div>
    </div>
  </GuestLayout>
</template>

<style scoped>
.register-card {
  border-width: 2px;
  border-radius: 1.25rem;
  margin-bottom: 48px;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.register-card:focus-within, .register-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
