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
    <nav class="navbar navbar-expand-lg navbar-success bg-success border-bottom shadow-sm fixed-top">
      <div class="container-fluid">
        <Link class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" :href="route('home')">
          <i class="bi bi-book fs-3"></i> <span>eBaryo</span>
        </Link>

        <button
          class="navbar-toggler border-0"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#userNavbar"
          aria-controls="userNavbar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="userNavbar">
          <!-- Centered Search bar -->
          <form class="d-flex mx-auto" @submit.prevent="submitSearch" style="max-width: 400px;">
            <input v-model="searchQuery" class="form-control me-2 border-success" type="search" placeholder="Search books..." aria-label="Search">
            <button class="btn btn-success text-white" type="submit"><i class="bi bi-search"></i></button>
          </form>

          <!-- Right-side dropdown -->
          <div class="dropdown">
            <button
              class="btn btn-success dropdown-toggle d-flex align-items-center text-white"
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
              <li><Link class="dropdown-item" :href="route('books.index')"><i class="bi bi-journal-bookmark"></i> All Books</Link></li>
              <li><Link class="dropdown-item" :href="route('books.saved')" method="get"><i class="bi bi-bookmark"></i> Saved Books</Link></li>
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
    <div style="height: 64px;"></div>

    <!-- Page content -->
    <main class="flex-grow-1 p-4 container">
      <slot />
    </main>

    <!-- Optional footer -->
    <footer class="bg-success text-white py-3 text-center border-0 mt-auto shadow-sm">
      <small><i class="bi bi-c-circle"></i> {{ new Date().getFullYear() }} eBaryo Library</small>
    </footer>
  </div>
</template>

<style scoped>
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
