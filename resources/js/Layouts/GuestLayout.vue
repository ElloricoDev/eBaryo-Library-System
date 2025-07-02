<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="min-vh-100 d-flex flex-column bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top">
      <div class="container-fluid">
        <Link class="navbar-brand fw-bold" :href="route('welcome')">
          <i class="bi bi-book"></i> eBaryo Library
        </Link>
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
              <Link class="nav-link" :href="route('welcome')"><i class="bi bi-house"></i> Home</Link>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about"><i class="bi bi-info-circle"></i> About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#features"><i class="bi bi-stars"></i> Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#testimonials"><i class="bi bi-chat-quote"></i> Testimonials</a>
            </li>
            <li class="nav-item">
              <Link class="nav-link" :href="route('login')"><i class="bi bi-box-arrow-in-right"></i> Login</Link>
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
      <small><i class="bi bi-c-circle"></i> {{ new Date().getFullYear() }} eBaryo Library. All rights reserved.</small>
    </footer>
  </div>
</template>

<style scoped>
html, body {
  height: 100%;
}
</style>
