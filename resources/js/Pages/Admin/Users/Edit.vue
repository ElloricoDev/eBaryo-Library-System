<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Swal from "sweetalert2";

defineOptions({ layout: AdminLayout })

const props = defineProps({
  user: Object
})

const form = useForm({
  user_name: props.user.user_name || '',
  first_name: props.user.first_name || '',
  middle_name: props.user.middle_name || '',
  last_name: props.user.last_name || '',
  contact_number: props.user.contact_number || '',
  address: props.user.address || '',
  role: props.user.role || 'user',
  email: props.user.email || '',
})

const submit = () => {
  form.put(route('admin.users.update', {id: props.user.id}), {
    onSuccess: () => {
      Swal.fire({
        icon: "success",
        title: "Success",
        text: "User updated successfully!",
        timer: 2000,
        showConfirmButton: false,
      });
    }
  });
}
</script>

<template>
  <Head title="Edit User" />
  <div class="container py-4">
    <div class="d-flex align-items-center mb-4">
      <Link :href="route('admin.users.index')" class="btn btn-success me-3 shadow-sm rounded-pill px-4 py-2 fw-semibold"><i class="bi bi-arrow-left"></i> Back</Link>
      <h1 class="fs-3 fw-bold mb-0 text-success"><i class="bi bi-person-lines-fill"></i> Edit User</h1>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-9">
        <div class="card border-success shadow rounded-4">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label fw-semibold text-success"><i class="bi bi-person"></i> First Name</label>
                  <input v-model="form.first_name" type="text" class="form-control border-success rounded-pill shadow-sm" :class="{ 'is-invalid': form.errors.first_name }" />
                  <div class="invalid-feedback" v-if="form.errors.first_name">{{ form.errors.first_name }}</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold text-success"><i class="bi bi-person"></i> Middle Name</label>
                  <input v-model="form.middle_name" type="text" class="form-control border-success rounded-pill shadow-sm" :class="{ 'is-invalid': form.errors.middle_name }" />
                  <div class="invalid-feedback" v-if="form.errors.middle_name">{{ form.errors.middle_name }}</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold text-success"><i class="bi bi-person"></i> Last Name</label>
                  <input v-model="form.last_name" type="text" class="form-control border-success rounded-pill shadow-sm" :class="{ 'is-invalid': form.errors.last_name }" />
                  <div class="invalid-feedback" v-if="form.errors.last_name">{{ form.errors.last_name }}</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold text-success"><i class="bi bi-person"></i> User Name</label>
                  <input v-model="form.user_name" type="text" class="form-control border-success rounded-pill shadow-sm" :class="{ 'is-invalid': form.errors.user_name }" />
                  <div class="invalid-feedback" v-if="form.errors.user_name">{{ form.errors.user_name }}</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-success"><i class="bi bi-telephone"></i> Contact Number</label>
                  <input v-model="form.contact_number" type="text" class="form-control border-success rounded-pill shadow-sm" />
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-success"><i class="bi bi-geo-alt"></i> Address</label>
                  <input v-model="form.address" type="text" class="form-control border-success rounded-pill shadow-sm" />
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-success"><i class="bi bi-envelope"></i> Email</label>
                  <input v-model="form.email" type="email" class="form-control border-success rounded-pill shadow-sm" :class="{ 'is-invalid': form.errors.email }" />
                  <div class="invalid-feedback" v-if="form.errors.email">{{ form.errors.email }}</div>
                </div>
              </div>
              <input type="hidden" v-model="form.role" />
              <div class="mt-4">
                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold shadow-sm" :disabled="form.processing">
                  <i class="bi bi-person-lines-fill"></i> {{ form.processing ? 'Saving...' : 'Update User' }}
                </button>
              </div>
            </form>
          </div>
        </div>
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
.form-control:focus {
  border-color: #28a745;
  box-shadow: 0 0 0 0.2rem rgba(40,167,69,.15);
}
</style>