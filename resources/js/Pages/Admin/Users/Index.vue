<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { usePage, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { ref } from "vue";

defineOptions({ layout: AdminLayout });

const { props } = usePage();

// Use a local reactive copy of users
const usersList = ref([...props.users]);

const confirmDelete = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("admin.users.destroy", id), {
                preserveScroll: true,
                onSuccess: () => {
                    usersList.value = usersList.value.filter(
                        (user) => user.id !== id
                    );

                    Swal.fire({
                        icon: "success",
                        title: "Deleted!",
                        text: "User has been deleted successfully.",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                },
            });
        }
    });
};
</script>

<template>
    <Head title="Users" />
    <div class="container py-4">
        <h1 class="mb-4 fs-3 fw-bold text-success"><i class="bi bi-person"></i> Users</h1>
        <div class="mb-3">
            <Link
                :href="route('admin.users.create')"
                class="btn btn-success shadow-sm rounded-pill px-4 py-2 fw-semibold"
            ><i class="bi bi-plus"></i> Create User</Link>
        </div>

        <div class="card border-success shadow rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-success">
                            <tr>
                                <th class="text-success">#</th>
                                <th class="text-success"><i class="bi bi-person"></i> Name</th>
                                <th class="text-success"><i class="bi bi-envelope"></i> Email</th>
                                <th class="text-success"><i class="bi bi-person-badge"></i> Role</th>
                                <th class="text-success"><i class="bi bi-calendar"></i> Registered At</th>
                                <th class="text-success">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in usersList" :key="user.id">
                                <td class="fw-semibold">{{ index + 1 }}</td>
                                <td>{{ user.user_name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.role }}</td>
                                <td>
                                    {{ new Date(user.created_at).toLocaleDateString() }}
                                </td>
                                <td>
                                    <Link
                                        :href="route('admin.users.show', user.id)"
                                        class="btn btn-sm btn-info rounded-pill me-1"
                                    ><i class="bi bi-eye"></i> View</Link>
                                    <Link
                                        :href="route('admin.users.edit', user.id)"
                                        class="btn btn-sm btn-warning rounded-pill me-1"
                                    ><i class="bi bi-pencil"></i> Edit</Link>
                                    <form
                                        :action="route('admin.users.destroy', user.id)"
                                        method="post"
                                        style="display: inline"
                                        @submit.prevent="confirmDelete(user.id)"
                                    >
                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger rounded-pill"
                                        >
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
.table-success th {
  background-color: #d4edda !important;
}
.btn {
  transition: box-shadow 0.2s;
}
.btn:focus {
  box-shadow: 0 0 0 0.2rem rgba(40,167,69,.15);
}
</style>
