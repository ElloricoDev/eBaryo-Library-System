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
    <div class="container d-flex flex-column align-items-center justify-content-center min-vh-100 py-4">
      <div class="card shadow login-card border-success w-100" style="max-width: 400px;">
        <div class="card-body">
          <h1 class="mb-4 text-center text-success-emphasis">
            <i class="bi bi-box-arrow-in-right me-2 text-success"></i>Login
          </h1>

          <form @submit.prevent="submit">
            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label text-success"><i class="bi bi-person"></i> Email</label>
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
              <label for="password" class="form-label text-success"><i class="bi bi-lock"></i> Password</label>
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
                <Link :href="route('password.request')" class="d-block text-success-emphasis small mt-3">
                  <i class="bi bi-envelope"></i> Forgot password?
                </Link>
              </div>
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
              <input
                class="form-check-input border-success"
                type="checkbox"
                id="remember"
                v-model="form.remember"
              />
              <label class="form-check-label text-success" for="remember">
                Remember Me
              </label>
            </div>

            <!-- Submit -->
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-success w-100 shadow-sm" :disabled="form.processing">
                <span v-if="!form.processing"><i class="bi bi-box-arrow-in-right"></i> Login</span>
                <span v-else>Logging in...</span>
              </button>
            </div>
            <div class="d-grid">
              <a :href="route('google.redirect')" class="btn btn-outline-success w-100 mb-2">
                <i class="bi bi-google"></i> Login with Google
              </a>
            </div>
          </form>
          <div class="text-center mt-3">
            <span>Don't have an account?</span>
            <Link :href="route('register')" class="d-block text-success text-center mt-2">
              <i class="bi bi-person-plus"></i> Register
            </Link>
          </div>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<style scoped>
.login-card {
  border-width: 2px;
  border-radius: 1.25rem;
  margin-top: 48px;
  margin-bottom: 48px;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.login-card:focus-within, .login-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
