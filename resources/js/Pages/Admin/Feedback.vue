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
        <h1 class="fs-3 fw-bold mb-4 bi bi-chat-dots">Feedback Management</h1>
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Responded At</th>
                            <th>Admin Response</th>
                            <th>Actions</th>
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
                                            ? 'text-warning'
                                            : 'text-success'
                                    "
                                >
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
                                        class="btn btn-sm btn-primary"
                                        :disabled="
                                            !responseInputs[fb.id]?.trim()
                                        "
                                    >
                                        Save Response
                                    </button>
                                </div>
                                <div v-else>
                                    <span v-if="fb.response">
                                        {{ fb.response }}
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
                                    class="btn btn-sm btn-success"
                                >
                                    Mark Responded
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
