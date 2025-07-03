<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { onMounted } from 'vue';
defineOptions({layout: UserLayout});
const props = defineProps({ feedbacks: Array, hasNewResponses: Boolean });

onMounted(() => {
  if (props.hasNewResponses) {
    Swal.fire({
      icon: 'info',
      title: 'New Response!',
      text: 'An admin has responded to your feedback.',
      timer: 2500,
      showConfirmButton: false
    });
  }
});
</script>

<template>
  <Head title="My Feedback" />
  <div class="container py-4">
    <h1 class="fs-3 fw-bold mb-4 bi bi-chat-dots">My Feedback</h1>
    <div class="card">
      <div class="card-body">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th>Message</th>
              <th>Status</th>
              <th>Admin Response</th>
              <th>Responded At</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="fb in props.feedbacks" :key="fb.id">
              <td>{{ fb.message }}</td>
              <td>
                <span :class="fb.status === 'pending' ? 'text-warning' : 'text-success'">
                  {{ fb.status.charAt(0).toUpperCase() + fb.status.slice(1) }}
                </span>
              </td>
              <td>
                <span v-if="fb.response">{{ fb.response }}</span>
                <span v-else class="text-muted">No response yet</span>
              </td>
              <td>{{ fb.responded_at ? new Date(fb.responded_at).toLocaleString() : '-' }}</td>
            </tr>
            <tr v-if="!props.feedbacks.length">
              <td colspan="4" class="text-center text-muted">No feedback found.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template> 