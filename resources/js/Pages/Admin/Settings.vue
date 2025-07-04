<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });
</script>

<template>
  <Head title="Admin Settings" />
  <div class="container py-4">
    <h1 class="fs-3 fw-bold mb-4 text-success d-flex align-items-center gap-2"><i class="bi bi-gear"></i> Admin Settings</h1>
    <div class="card border-success shadow admin-settings-card">
      <div class="card-body">
        <p class="text-muted mb-0">Settings management coming soon...</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.admin-settings-card {
  border-width: 2px;
  border-radius: 1.25rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.admin-settings-card:focus-within, .admin-settings-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style> 