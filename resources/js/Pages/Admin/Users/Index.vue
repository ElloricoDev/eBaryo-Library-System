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
        <h1 class="mb-4 fs-3 fw-bold bi bi-person">Users</h1>
        <div class="mb-3">
            <Link
                :href="route('admin.users.create')"
                class="bi bi-plus btn btn-primary"
                >Create User</Link
            >
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in usersList" :key="user.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ user.user_name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td>
                        <td>
                            {{ new Date(user.created_at).toLocaleDateString() }}
                        </td>
                        <td>
                            <Link
                                :href="route('admin.users.show', user.id)"
                                class="btn btn-sm btn-info me-1"
                                >View</Link
                            >
                            <Link
                                :href="route('admin.users.edit', user.id)"
                                class="btn btn-sm btn-warning me-1"
                                >Edit</Link
                            >
                            <form
                                :action="route('admin.users.destroy', user.id)"
                                method="post"
                                style="display: inline"
                                @submit.prevent="confirmDelete(user.id)"
                            >
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-danger"
                                >
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
