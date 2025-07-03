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
            <h1 class="fs-3 fw-bold mb-0 bi bi-tags">Category Details</h1>
            <Link :href="route('admin.categories.index')" class="btn btn-secondary bi bi-arrow-left"> Back to Categories</Link>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <strong><i class="bi bi-card-text"></i> Name:</strong>
                            <div>{{ category.name }}</div>
                        </div>
                        <div class="mb-3">
                            <strong><i class="bi bi-card-list"></i> Description:</strong>
                            <div>{{ category.description || 'No description' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
