<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted, watch } from 'vue'
const { props } = usePage()
const user = props.auth?.user || {}
const searchQuery = ref('')
const submitSearch = () => {
  // Always emit, even if empty, to allow reset
  window.dispatchEvent(new CustomEvent('user-search', { detail: searchQuery.value }))
}

// Watch for input clearing
watch(searchQuery, (val) => {
  if (val === '') {
    window.dispatchEvent(new CustomEvent('user-search', { detail: '' }))
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

          <!-- Search bar -->
          <form class="d-flex me-3" @submit.prevent="submitSearch">
            <input v-model="searchQuery" class="form-control me-2" type="search" placeholder="Search books..." aria-label="Search">
            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
          </form>

          <!-- Right-side dropdown -->
          <div class="dropdown">
            <button
              class="btn btn-light dropdown-toggle d-flex align-items-center"
              type="button"
              id="profileDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                v-if="user.avatar"
                :src="user.avatar"
                alt="Avatar"
                class="rounded-circle me-2"
                style="width: 32px; height: 32px; object-fit: cover;"
              />
              <img
                v-else
                src="https://ui-avatars.com/api/?name=N%2FA&background=ddd&color=555"
                alt="No Avatar"
                class="rounded-circle me-2"
                style="width: 32px; height: 32px; object-fit: cover;"
              />
              <span>{{ user.user_name || 'User' }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><Link class="dropdown-item" :href="route('user.profile.index')"><i class="bi bi-person-lines-fill"></i> Profile</Link></li>
              <li><hr class="dropdown-divider" /></li>
              <li><Link class="dropdown-item" :href="route('feedback.create')"><i class="bi bi-chat-dots"></i> Feedback</Link></li>
              <li><Link class="dropdown-item" :href="route('feedback.my')"><i class="bi bi-list-check"></i> My Feedback</Link></li>
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
