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
            <h1 class="fs-3 fw-bold mb-0 text-success"><i class="bi bi-tags"></i> Create New Category</h1>
            <Link
                :href="route('admin.categories.index')"
                class="btn btn-success shadow-sm rounded-pill px-4 py-2 fw-semibold"
            >
                <i class="bi bi-arrow-left"></i> Back to Categories</Link>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-success shadow rounded-4">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold text-success"
                                    ><i class="bi bi-card-text"></i> Name</label
                                >
                                <input
                                    v-model="form.name"
                                    id="name"
                                    type="text"
                                    class="form-control border-success rounded-pill shadow-sm"
                                    :class="{'is-invalid': form.errors.name}"
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="invalid-feedback d-block"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold text-success"
                                    ><i class="bi bi-card-list"></i>
                                    Description</label
                                >
                                <textarea
                                    v-model="form.description"
                                    id="description"
                                    class="form-control border-success rounded-4 shadow-sm"
                                    :class="{'is-invalid': form.errors.description}"
                                    rows="3"
                                ></textarea>
                                <div
                                    v-if="form.errors.description"
                                    class="invalid-feedback d-block"
                                >
                                    {{ form.errors.description }}
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-success w-100 rounded-pill fw-bold shadow-sm"
                                :disabled="form.processing"
                            >
                                <i class="bi bi-plus-circle"></i> Create Category
                            </button>
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
