<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

defineOptions({ layout: AdminLayout });

const form = useForm({
    name: "",
    description: "",
});

function submit() {
    form.post(route("admin.categories.store"), {
        onSuccess: () => {
            Swal.fire({
                icon: 'success',
                title: 'Category created!',
                text: 'The new category has been added successfully.',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}
</script>

<template>
    <Head title="Create new category" />
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fs-3 fw-bold mb-0 bi bi-tags">Create New Category</h1>
            <Link
                :href="route('admin.categories.index')"
                class="btn btn-secondary bi bi-arrow-left"
            >
                Back to Categories</Link
            >
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="name" class="form-label"
                                    ><i class="bi bi-card-text"></i> Name</label
                                >
                                <input
                                    v-model="form.name"
                                    id="name"
                                    type="text"
                                    class="form-control"
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="text-danger small"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label"
                                    ><i class="bi bi-card-list"></i>
                                    Description</label
                                >
                                <textarea
                                    v-model="form.description"
                                    id="description"
                                    class="form-control"
                                ></textarea>
                                <div
                                    v-if="form.errors.description"
                                    class="text-danger small"
                                >
                                    {{ form.errors.description }}
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="form.processing"
                            >
                                Create Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
