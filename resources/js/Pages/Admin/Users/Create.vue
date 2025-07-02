<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Swal from "sweetalert2";

defineOptions({ layout: AdminLayout })

const form = useForm({
  first_name: '',
  middle_name: '',
  last_name: '',
  contact_number: '',
  address: '',
  role: 'user', // default and hidden
  email: '',
  avatar: null,
  user_name: '',
})

const submit = () => {
    form.post(route('admin.users.store'), {
        forceFormData: true,
        onSuccess: () => {
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "User created successfully!",
                timer: 2000,
                showConfirmButton: false,
            });
        }
    });
};
</script>

<template>
  <Head title="Create User" />

  <div class="container py-4">
    <div class="d-flex align-items-center mb-4">
      <Link :href="route('admin.users.index')" class="btn btn-secondary me-3">Back</Link>
      <h1 class="fs-3 fw-bold mb-0">Create New User</h1>
    </div>

    <form @submit.prevent="submit">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">First Name</label>
          <input v-model="form.first_name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.first_name }" />
          <div class="invalid-feedback" v-if="form.errors.first_name">{{ form.errors.first_name }}</div>
        </div>

        <div class="col-md-4">
          <label class="form-label">Middle Name</label>
          <input v-model="form.middle_name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.middle_name }" />
        </div>

        <div class="col-md-4">
          <label class="form-label">Last Name</label>
          <input v-model="form.last_name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.last_name }" />
          <div class="invalid-feedback" v-if="form.errors.last_name">{{ form.errors.last_name }}</div>
        </div>

        <div class="col-md-4">
          <label class="form-label">User Name</label>
          <input v-model="form.user_name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.user_name }" />
          <div class="invalid-feedback" v-if="form.errors.user_name">{{ form.errors.user_name }}</div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input v-model="form.contact_number" type="text" class="form-control"  />
        </div>

        <div class="col-md-6">
          <label class="form-label">Address</label>
          <input v-model="form.address" type="text" class="form-control" />
        </div>

        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input v-model="form.email" type="email" class="form-control" :class="{ 'is-invalid': form.errors.email }" />
          <div class="invalid-feedback" v-if="form.errors.email">{{ form.errors.email }}</div>
        </div>
      </div>

      <!-- Hidden Role -->
      <input type="hidden" v-model="form.role" />

      <div class="mt-4">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">
          {{ form.processing ? 'Saving...' : 'Create User' }}
        </button>
      </div>
    </form>
  </div>
</template>
