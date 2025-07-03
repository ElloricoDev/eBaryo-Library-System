<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false
})

const submit = () => {
  form.post(route('login'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
    onError: () => {
      form.reset('password');
    }
  });
}
</script>

<template>
  <Head title="Login" />
  <GuestLayout>
    <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
      <div class="card-body">
        <h1 class="mb-4 text-center"><i class="bi bi-box-arrow-in-right"></i> Login</h1>

        

        <form @submit.prevent="submit">
          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label"><i class="bi bi-person"></i> Email</label>
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
            <div class="text-end mt-1">
              <Link :href="route('password.request')" class="d-block text-center mt-3">
                <i class="bi bi-envelope"></i> Forgot password?
              </Link>
            </div>
          </div>

          <!-- Remember Me -->
          <div class="mb-3 form-check">
            <input
              class="form-check-input"
              type="checkbox"
              id="remember"
              v-model="form.remember"
            />
            <label class="form-check-label" for="remember">
              Remember Me
            </label>
          </div>

          <!-- Submit -->
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">
              <span v-if="!form.processing"><i class="bi bi-box-arrow-in-right"></i> Login</span>
              <span v-else>Logging in...</span>
            </button>
          </div>
          <div class=" d-grid">
          <a :href="route('google.redirect')" class="btn btn-outline-danger w-100 mb-2">
            <i class="bi bi-google"></i> Login with Google
          </a>
        </div>
        </form>
        <div class="text-center mt-3">
          <span>Don't have an account?</span>
          <Link :href="route('register')" class="d-block text-center mt-2">
            <i class="bi bi-person-plus"></i> Register
          </Link>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>
