<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, usePage, Head, Link } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import { ref } from 'vue'

defineOptions({ layout: AdminLayout })

const { props } = usePage()
const user = props.user

const form = useForm({
  user_name: user.user_name || '',
  first_name: user.first_name || '',
  middle_name: user.middle_name || '',
  last_name: user.last_name || '',
  contact_number: user.contact_number || '',
  address: user.address || '',
  email: user.email || '',
  avatar: null,
  student: user.student || 'no',
})

const avatarPreview = ref(user.avatar || null)

const submit = () => {
  form.transform((data) => ({
    ...data,
    _method: 'PUT',
  }))

  form.post(route('admin.profile.update'), {
    forceFormData: true,
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: 'Profile Updated',
        text: 'Your profile has been successfully updated.',
        timer: 2000,
        showConfirmButton: false,
      })
    }
  })
}

function onAvatarChange(e) {
  const file = e.target.files[0]
  form.avatar = file
  if (file) {
    avatarPreview.value = URL.createObjectURL(file)
  } else {
    avatarPreview.value = user.avatar || null
  }
}

</script>

<template>
  <Head title="Edit Profile" />

  <div class="container py-4">
    <div class="d-flex align-items-center mb-4">
      <Link :href="route('admin.profile.index')" class="btn btn-outline-success me-3">
        <i class="bi bi-arrow-left"></i> Back
      </Link>
      <h1 class="fs-3 fw-bold mb-0 text-success d-flex align-items-center gap-2">
        <i class="bi bi-pencil-square"></i> Edit Profile
      </h1>
    </div>

    <form @submit.prevent="submit" enctype="multipart/form-data" class="card border-success shadow admin-profile-edit-card p-4">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-person"></i> User Name</label>
          <input v-model="form.user_name" type="text" class="form-control" />
          <div v-if="form.errors.user_name" class="text-danger">{{ form.errors.user_name }}</div>
        </div>

        <div class="col-md-4">
          <label class="form-label text-success"><i class="bi bi-person"></i> First Name</label>
          <input v-model="form.first_name" type="text" class="form-control" />
          <div v-if="form.errors.first_name" class="text-danger">{{ form.errors.first_name }}</div>
        </div>

        <div class="col-md-4">
          <label class="form-label text-success"><i class="bi bi-person"></i> Middle Name</label>
          <input v-model="form.middle_name" type="text" class="form-control" />
          <div v-if="form.errors.middle_name" class="text-danger">{{ form.errors.middle_name }}</div>
        </div>

        <div class="col-md-4">
          <label class="form-label text-success"><i class="bi bi-person"></i> Last Name</label>
          <input v-model="form.last_name" type="text" class="form-control" />
          <div v-if="form.errors.last_name" class="text-danger">{{ form.errors.last_name }}</div>
        </div>

        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-telephone"></i> Contact Number</label>
          <input v-model="form.contact_number" type="text" class="form-control" />
          <div v-if="form.errors.contact_number" class="text-danger">{{ form.errors.contact_number }}</div>
        </div>

        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-geo-alt"></i> Address</label>
          <input v-model="form.address" type="text" class="form-control" />
          <div v-if="form.errors.address" class="text-danger">{{ form.errors.address }}</div>
        </div>

        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-envelope"></i> Email</label>
          <input v-model="form.email" type="email" class="form-control" />
          <div v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</div>
        </div>

        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-mortarboard"></i> Student</label>
          <select v-model="form.student" class="form-control">
            <option value="yes">Yes</option>
            <option value="no">No</option>
          </select>
          <div v-if="form.errors.student" class="text-danger">{{ form.errors.student }}</div>
        </div>

        <div class="col-md-6">
          <label class="form-label text-success"><i class="bi bi-image"></i> Avatar</label>
          <input
            type="file"
            class="form-control"
            @change="onAvatarChange"
            accept="image/*"
          />
          <div v-if="form.errors.avatar" class="text-danger">{{ form.errors.avatar }}</div>

          <!-- Preview -->
          <div v-if="avatarPreview" class="mt-2">
            <img :src="avatarPreview" alt="Avatar Preview" class="rounded border border-success" style="width: 80px; height: 80px; object-fit: cover;" />
          </div>
        </div>
      </div>

      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-success shadow-sm" :disabled="form.processing">
          <i class="bi bi-save"></i> {{ form.processing ? 'Saving...' : 'Update Profile' }}
        </button>
        <Link :href="route('admin.profile.index')" class="btn btn-outline-success">
          <i class="bi bi-arrow-left"></i> Cancel
        </Link>
      </div>
    </form>
  </div>
</template>

<style scoped>
.admin-profile-edit-card {
  border-width: 2px;
  border-radius: 1.25rem;
  margin-bottom: 32px;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.admin-profile-edit-card:focus-within, .admin-profile-edit-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
