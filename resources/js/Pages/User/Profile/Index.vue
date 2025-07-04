<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import DeleteAccountForm from './Partials/DeleteAccountForm.vue'
import VerifyEmail from './Partials/VerifyEmail.vue'
import UserLayout from '@/Layouts/UserLayout.vue'

defineOptions({
    layout: UserLayout
})
const { props } = usePage()
const user = props.user
</script>

<template>
  <Head title="My Profile" />

  <div class="container py-4">
    <h1 class="mb-4 fs-3 fw-bold text-success d-flex align-items-center gap-2">
      <i class="bi bi-person-circle"></i> User Profile
    </h1>

    <div class="card mb-4 border-success shadow profile-card">
      <div class="card-body">
        <div class="text-center mb-3">
          <img
            v-if="user.avatar"
            :src="user.avatar"
            alt="Avatar"
            class="rounded-circle border border-success"
            style="width: 100px; height: 100px; object-fit: cover;"
          />
          <div v-else class="mb-2">
            <img src="https://ui-avatars.com/api/?name=N%2FA&background=ddd&color=555" alt="No Avatar" class="rounded-circle border border-success" style="width: 100px; height: 100px; object-fit: cover;" />
          </div>
        </div>

        <p><strong class="text-success"><i class="bi bi-person"></i> User Name:</strong> {{ user.user_name || 'N/A' }}</p>
        <p><strong class="text-success"><i class="bi bi-person"></i> First Name:</strong> {{ user.first_name || 'N/A' }}</p>
        <p><strong class="text-success"><i class="bi bi-person"></i> Middle Name:</strong> {{ user.middle_name || 'N/A' }}</p>
        <p><strong class="text-success"><i class="bi bi-person"></i> Last Name:</strong> {{ user.last_name || 'N/A' }}</p>
        <p><strong class="text-success"><i class="bi bi-telephone"></i> Contact Number:</strong> {{ user.contact_number || 'N/A' }}</p>
        <p><strong class="text-success"><i class="bi bi-geo-alt"></i> Address:</strong> {{ user.address || 'N/A' }}</p>
        <p><strong class="text-success"><i class="bi bi-envelope"></i> Email:</strong> {{ user.email || 'N/A' }}</p>
        <p>
          <strong class="text-success"><i class="bi bi-patch-check"></i> Email Status:</strong>
          <span v-if="user.email_verified_at" class="text-success">Verified</span>
          <span v-else class="text-danger">Not Verified</span>
        </p>
        <div class="mb-3">
          <label class="form-label fw-bold text-success"><i class="bi bi-mortarboard"></i> Student:</label>
          <span>{{ user.student === 'yes' ? 'Yes' : 'No' }}</span>
        </div>

        <Link :href="route('user.profile.edit')" class="btn btn-success mt-3 w-100 shadow-sm">
          <i class="bi bi-pencil-square"></i> Edit Profile
        </Link>
      </div>
    </div>

    <!-- Include Email Verification, Password Update, and Delete Account Partials -->
    <VerifyEmail />
    <UpdatePasswordForm />
    <DeleteAccountForm />
  </div>
</template>

<style scoped>
.profile-card {
  border-width: 2px;
  border-radius: 1.25rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.profile-card:focus-within, .profile-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
