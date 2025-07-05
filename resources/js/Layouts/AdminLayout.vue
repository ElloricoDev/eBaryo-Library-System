<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import { computed } from 'vue'

const { props, url } = usePage()
const user = props.auth?.user || {}

// Compute the current URL from usePage
const currentUrl = computed(() => url.value || '')

// Check if current path starts with a given string
const isActive = (path) => {
  const currentPath = window.location.pathname.replace(/\/$/, '')
  const normalizedPath = path.replace(/\/$/, '')
  return (
    currentPath === normalizedPath ||
    currentPath.startsWith(normalizedPath + '/')
  )
}
</script>

<template>
  <div>
    <!-- Sidebar -->
    <nav
      class="bg-success sidebar-green border-end p-3 position-fixed"
      style="width: 250px; height: 100vh; top: 0; left: 0; z-index: 1030;"
    >
      <h5 class="mb-4 text-white"><i class="bi bi-shield-lock me-2"></i>Admin Panel</h5>
      <ul class="nav flex-column">
        <li class="nav-item">
          <Link
            class="nav-link text-white sidebar-link-green"
            :class="{ active: isActive('/dashboard') }"
            :href="route('dashboard')"
          >
            <i class="bi bi-speedometer2"></i> Dashboard
          </Link>
        </li>
        <li class="nav-item">
          <Link
            class="nav-link text-white sidebar-link-green"
            :class="{ active: isActive('/admin/users') }"
            :href="route('admin.users.index')"
          >
            <i class="bi bi-people"></i> Users
          </Link>
        </li>
        <li class="nav-item">
          <Link
            class="nav-link text-white sidebar-link-green"
            :class="{ active: isActive('/admin/books') }"
            :href="route('admin.books.index')"
          >
            <i class="bi bi-book"></i> Books
          </Link>
        </li>
        <li class="nav-item">
          <Link
            class="nav-link text-white sidebar-link-green"
            :class="{ active: isActive('/admin/category')}"
            :href="route('admin.categories.index')"
          >
            <i class="bi bi-folder"></i> Category
          </Link>
        </li>
        <li class="nav-item">
          
        </li>
        <li class="nav-item">
          <Link
            class="nav-link text-white sidebar-link-green"
            :class="{ active: isActive('/admin/feedback') }"
            :href="route('admin.feedback.index')"
          >
            <i class="bi bi-chat-dots"></i> Feedback
          </Link>
        </li>
      </ul>
    </nav>

    <!-- Main wrapper -->
    <div class="ms-250">
      <!-- Header -->
      <header
        class="d-flex justify-content-between align-items-center px-4 py-2 border-bottom bg-white shadow-sm position-sticky w-100"
        style="left: 250px; height: 60px; z-index: 1020; top: 0;"
      >
        <!-- Search bar -->
        <div class="input-group w-50">
          <input type="text" class="form-control border-success" placeholder="Search..." />
          <button class="btn btn-success" type="button">
            <i class="bi bi-search"></i>
          </button>
        </div>

        <!-- Profile Dropdown -->
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
            <span>{{ user.user_name || 'Admin' }}</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <li>
              <Link class="dropdown-item" :href="route('admin.profile.index')">
                <i class="bi bi-person"></i> Profile
              </Link>
            </li>
            <li>
              <Link class="dropdown-item" :href="route('admin.settings.index')">
                <i class="bi bi-gear"></i> Settings
              </Link>
            </li>
            <li><hr class="dropdown-divider" /></li>
            <li>
              <Link class="dropdown-item text-danger" :href="route('logout')" method="post">
                <i class="bi bi-box-arrow-right"></i> Logout
              </Link>
            </li>
          </ul>
        </div>
      </header>

      <!-- Main content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>

<style scoped>
.ms-250 {
  margin-left: 250px;
}
.sidebar-green {
  background-color: #198754 !important;
}
.sidebar-link-green {
  transition: background 0.2s, color 0.2s;
  border-radius: 0.375rem;
}
.sidebar-link-green:hover,
.sidebar-link-green:focus,
.sidebar-link-green.active {
  background: #157347;
  color: #fff !important;
}
/* When Vue adds the `active` class */
.sidebar-link-green.active {
  font-weight: bold;
}
</style>
