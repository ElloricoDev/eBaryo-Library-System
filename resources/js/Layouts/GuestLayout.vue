<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="min-vh-100 d-flex flex-column bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top">
      <div class="container-fluid">
        <Link class="navbar-brand fw-bold" :href="route('welcome')">eBaryo Library</Link>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#guestNavbar"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="guestNavbar">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <Link class="nav-link" :href="route('welcome')">Home</Link>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#features">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#testimonials">Testimonials</a>
            </li>
            <li class="nav-item">
              <Link class="nav-link" :href="route('login')">Login</Link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div style="height: 56px;"></div>

    <!-- Page Content -->
    <main class="flex-grow-1 d-flex align-items-center justify-content-center p-4">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center py-3 border-top mt-auto">
      <small>&copy; {{ new Date().getFullYear() }} eBaryo Library. All rights reserved.</small>
    </footer>
  </div>
</template>

<style scoped>
html, body {
  height: 100%;
}
</style>
