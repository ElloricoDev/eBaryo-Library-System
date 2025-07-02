<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({
  layout: AdminLayout
})
</script>

<template>
  <div class="container py-4">
    <h1 class="mb-4 fs-3 fw-bold">Admin Dashboard</h1>

    <div class="row g-4">
      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Total Users</h5>
            <p class="card-text fs-4 fw-semibold text-primary">1,245</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Books Uploaded</h5>
            <p class="card-text fs-4 fw-semibold text-success">312</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Pending Requests</h5>
            <p class="card-text fs-4 fw-semibold text-warning">8</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Feedbacks</h5>
            <p class="card-text fs-4 fw-semibold text-danger">27</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
