<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    category: Object
});
const category = props.category;
</script>

<template>
    <Head :title="`View Category: ${category.name}`" />
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fs-3 fw-bold mb-0 text-success"><i class="bi bi-tags"></i> Category Details</h1>
            <Link :href="route('admin.categories.index')" class="btn btn-success shadow-sm rounded-pill px-4 py-2 fw-semibold">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </Link>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-success shadow rounded-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <strong class="text-success"><i class="bi bi-card-text"></i> Name:</strong>
                            <div class="fs-5 fw-semibold">{{ category.name }}</div>
                        </div>
                        <div class="mb-3">
                            <strong class="text-success"><i class="bi bi-card-list"></i> Description:</strong>
                            <div class="text-secondary">{{ category.description || 'No description' }}</div>
                        </div>
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
</style>
