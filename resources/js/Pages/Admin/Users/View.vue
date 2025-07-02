<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  user: Object
})
</script>

<template>
  <Head title="User Details" />
  <div class="container py-4">
    <div class="d-flex align-items-center mb-4">
      <Link :href="route('admin.users.index')" class="btn btn-secondary me-3">Back</Link>
      <h1 class="fs-3 fw-bold mb-0">User Details</h1>
    </div>
    <div class="card">
      <div class="card-body">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr><th>User Name</th><td>{{ props.user.user_name || 'N/A' }}</td></tr>
            <tr><th>First Name</th><td>{{ props.user.first_name || 'N/A' }}</td></tr>
            <tr><th>Middle Name</th><td>{{ props.user.middle_name || 'N/A' }}</td></tr>
            <tr><th>Last Name</th><td>{{ props.user.last_name || 'N/A' }}</td></tr>
            <tr><th>Contact Number</th><td>{{ props.user.contact_number || 'N/A' }}</td></tr>
            <tr><th>Address</th><td>{{ props.user.address || 'N/A' }}</td></tr>
            <tr><th>Email</th><td>{{ props.user.email || 'N/A' }}</td></tr>
            <tr><th>Role</th><td>{{ props.user.role || 'N/A' }}</td></tr>
            <tr><th>Registered At</th><td>{{ props.user.created_at ? new Date(props.user.created_at).toLocaleString() : 'N/A' }}</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
