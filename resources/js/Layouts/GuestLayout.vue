<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="min-vh-100 d-flex flex-column bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-success bg-success border-bottom shadow-sm fixed-top">
      <div class="container-fluid">
        <Link class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" :href="route('welcome')">
          <i class="bi bi-book fs-3"></i> <span>eBaryo Library</span>
        </Link>
        <button
          class="navbar-toggler border-0"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#guestNavbar"
          aria-controls="guestNavbar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="guestNavbar">
          <ul class="navbar-nav ms-auto gap-lg-2">
            <li class="nav-item">
              <Link class="nav-link text-white nav-link-green" :href="route('welcome')"><i class="bi bi-house"></i> Home</Link>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white nav-link-green" href="#about"><i class="bi bi-info-circle"></i> About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white nav-link-green" href="#features"><i class="bi bi-stars"></i> Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white nav-link-green" href="#testimonials"><i class="bi bi-chat-quote"></i> Testimonials</a>
            </li>
            <li class="nav-item">
              <Link class="nav-link text-white nav-link-green" :href="route('login')"><i class="bi bi-box-arrow-in-right"></i> Login</Link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div style="height: 64px;"></div>

    <!-- Page Content -->
    <main class="flex-grow-1">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-success text-white text-center py-3 border-0 mt-auto shadow-sm">
      <small><i class="bi bi-c-circle"></i> {{ new Date().getFullYear() }} eBaryo Library. All rights reserved.</small>
    </footer>
  </div>
</template>

<style scoped>
html, body {
  height: 100%;
}
.navbar-success {
  background-color: #198754 !important;
}
.nav-link-green {
  transition: background 0.2s, color 0.2s;
  border-radius: 0.375rem;
}
.nav-link-green:hover, .nav-link-green:focus, .nav-link-green.router-link-exact-active {
  background: #157347;
  color: #fff !important;
}
.navbar-brand span {
  letter-spacing: 1px;
  font-size: 1.25rem;
}
footer {
  letter-spacing: 0.5px;
}
</style>
