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
      <Link :href="route('admin.users.index')" class="btn btn-success me-3 shadow-sm rounded-pill px-4 py-2 fw-semibold"><i class="bi bi-arrow-left"></i> Back</Link>
      <h1 class="fs-3 fw-bold mb-0 text-success"><i class="bi bi-eye"></i> User Details</h1>
    </div>
    <div class="card border-success shadow rounded-4">
      <div class="card-body">
        <table class="table table-borderless mb-0 align-middle">
          <tbody>
            <tr><th class="text-success"><i class="bi bi-person"></i> User Name</th><td class="fw-semibold">{{ props.user.user_name || 'N/A' }}</td></tr>
            <tr><th class="text-success"><i class="bi bi-person"></i> First Name</th><td>{{ props.user.first_name || 'N/A' }}</td></tr>
            <tr><th class="text-success"><i class="bi bi-person"></i> Middle Name</th><td>{{ props.user.middle_name || 'N/A' }}</td></tr>
            <tr><th class="text-success"><i class="bi bi-person"></i> Last Name</th><td>{{ props.user.last_name || 'N/A' }}</td></tr>
            <tr><th class="text-success"><i class="bi bi-telephone"></i> Contact Number</th><td>{{ props.user.contact_number || 'N/A' }}</td></tr>
            <tr><th class="text-success"><i class="bi bi-geo-alt"></i> Address</th><td>{{ props.user.address || 'N/A' }}</td></tr>
            <tr><th class="text-success"><i class="bi bi-envelope"></i> Email</th><td>{{ props.user.email || 'N/A' }}</td></tr>
            <tr><th class="text-success"><i class="bi bi-person-badge"></i> Role</th><td>{{ props.user.role || 'N/A' }}</td></tr>
            <tr><th class="text-success"><i class="bi bi-calendar"></i> Registered At</th><td>{{ props.user.created_at ? new Date(props.user.created_at).toLocaleString() : 'N/A' }}</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  border-radius: 1.25rem;
  box-shadow: 0 2px 16px rgba(0,128,0,0.08);
}
.btn-success {
  transition: background 0.2s, box-shadow 0.2s;
}
.btn-success:hover, .btn-success:focus {
  background: #218838;
  box-shadow: 0 2px 8px rgba(40,167,69,0.15);
}
th {
  min-width: 160px;
  font-weight: 600;
  vertical-align: middle;
}
</style>
