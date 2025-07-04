<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Swal from "sweetalert2";

defineOptions({ layout: AdminLayout });

const props = defineProps({ feedbacks: Array });

const responseInputs = ref({});
const responseErrors = ref({});

function saveResponse(id) {
    const response = responseInputs.value[id]?.trim();

    if (!response) {
        responseErrors.value[id] = "Response is required.";
        return;
    }

    responseErrors.value[id] = ""; // clear error

    router.put(
        route("admin.feedback.update", id),
        { response },
        {
            onSuccess: () => {
                Swal.fire({
                    icon: "success",
                    title: "Response saved!",
                    timer: 1500,
                    showConfirmButton: false,
                });
                responseInputs.value[id] = "";
            },
        }
    );
}

function markResponded(id) {
    router.put(route("admin.feedback.respond", id));
}
</script>

<template>
    <Head title="Feedback Management" />
    <div class="container py-4">
        <h1 class="fs-3 fw-bold mb-4 text-success d-flex align-items-center gap-2"><i class="bi bi-chat-dots"></i> Feedback Management</h1>
        <div class="card border-success shadow admin-feedback-card">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th><i class="bi bi-person"></i> User</th>
                            <th><i class="bi bi-chat-left-text"></i> Message</th>
                            <th><i class="bi bi-info-circle"></i> Status</th>
                            <th><i class="bi bi-clock-history"></i> Responded At</th>
                            <th><i class="bi bi-reply"></i> Admin Response</th>
                            <th><i class="bi bi-gear"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="fb in props.feedbacks" :key="fb.id">
                            <td>{{ fb.user?.user_name || "Unknown" }}</td>
                            <td>{{ fb.message }}</td>
                            <td>
                                <span
                                    :class="
                                        fb.status === 'pending'
                                            ? 'text-warning fw-semibold'
                                            : 'text-success fw-semibold'
                                    "
                                >
                                    <i :class="fb.status === 'pending' ? 'bi bi-hourglass-split me-1' : 'bi bi-check-circle me-1'"></i>
                                    {{
                                        fb.status.charAt(0).toUpperCase() +
                                        fb.status.slice(1)
                                    }}
                                </span>
                            </td>
                            <td>
                                {{
                                    fb.responded_at
                                        ? new Date(
                                              fb.responded_at
                                          ).toLocaleString()
                                        : "-"
                                }}
                            </td>
                            <td>
                                <div v-if="fb.status === 'pending'">
                                    <textarea
                                        v-model="responseInputs[fb.id]"
                                        class="form-control mb-2"
                                        rows="2"
                                        placeholder="Write a response..."
                                    ></textarea>

                                    <div
                                        v-if="responseErrors[fb.id]"
                                        class="text-danger small mb-2"
                                    >
                                        {{ responseErrors[fb.id] }}
                                    </div>

                                    <button
                                        @click="saveResponse(fb.id)"
                                        class="btn btn-sm btn-success shadow-sm"
                                        :disabled="
                                            !responseInputs[fb.id]?.trim()
                                        "
                                    >
                                        <i class="bi bi-save"></i> Save Response
                                    </button>
                                </div>
                                <div v-else>
                                    <span v-if="fb.response">
                                        <i class="bi bi-reply"></i> {{ fb.response }}
                                    </span>
                                    <span v-else class="text-muted">
                                        No response
                                    </span>
                                </div>
                            </td>
                            <td>
                                <button
                                    v-if="fb.status === 'pending'"
                                    @click="markResponded(fb.id)"
                                    class="btn btn-sm btn-outline-success shadow-sm"
                                >
                                    <i class="bi bi-check-circle"></i> Mark Responded
                                </button>
                                <span v-else class="text-muted">—</span>
                            </td>
                        </tr>
                        <tr v-if="!props.feedbacks.length">
                            <td colspan="6" class="text-center text-muted">
                                No feedbacks found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>
.admin-feedback-card {
  border-width: 2px;
  border-radius: 1.25rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.admin-feedback-card:focus-within, .admin-feedback-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
