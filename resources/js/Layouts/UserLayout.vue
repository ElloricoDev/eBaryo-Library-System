<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({
  user: {
    type: Object,
    default: null
  }
})
</script>

<template>
  <div class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top">
      <div class="container-fluid">
        <Link class="navbar-brand fw-bold" :href="route('home')">
          <i class="bi bi-book"></i> eBaryo
        </Link>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#userNavbar"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="userNavbar">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <Link class="nav-link" href="/books"><i class="bi bi-journal-bookmark"></i> Books</Link>
            </li>
            <li class="nav-item">
              <Link class="nav-link" href="/saved"><i class="bi bi-bookmark-heart"></i> Saved</Link>
            </li>
          </ul>

          <!-- Right-side dropdown -->
          <div class="dropdown">
            <button
              class="btn btn-light dropdown-toggle"
              data-bs-toggle="dropdown"
              type="button"
              id="profileDropdown"
            >
              <i class="bi bi-person-circle me-1"></i> {{ props.user?.user_name || 'Profile' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><Link class="dropdown-item" :href="route('user.profile.index')"><i class="bi bi-person-lines-fill"></i> Profile</Link></li>
              <li><hr class="dropdown-divider" /></li>
              <li><Link class="dropdown-item text-danger" :href="route('logout')" method="post"><i class="bi bi-box-arrow-right"></i> Logout</Link></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <div style="height: 56px;"></div>

    <!-- Page content -->
    <main class="flex-grow-1 p-4 container">
      <slot />
    </main>

    <!-- Optional footer -->
    <footer class="bg-light py-3 text-center border-top">
      <small><i class="bi bi-c-circle"></i> {{ new Date().getFullYear() }} eBaryo Library</small>
    </footer>
  </div>
</template>
