<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { usePage } from '@inertiajs/vue3'
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
  Filler
} from 'chart.js'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
  Filler
)

defineOptions({ layout: AdminLayout })

const { props } = usePage()

const uploadsChartData = {
  labels: Array.isArray(props.ebookUploadsByMonth?.labels) ? props.ebookUploadsByMonth.labels : [],
  datasets: [
    {
      label: 'Ebook Uploads',
      data: props.ebookUploadsByMonth?.data || [],
      borderColor: '#0d6efd',
      backgroundColor: 'rgba(13,110,253,0.1)',
      tension: 0.4,
      fill: true,
    }
  ]
}

const uploadsChartOptions = {
  responsive: true,
  plugins: {
    legend: { display: false },
    title: { display: true, text: 'Ebook Uploads Over Time' }
  },
  scales: {
    y: { beginAtZero: true }
  }
}
</script>

<template>
  <Head title="Dashboard"/>
  <div class="container py-4">
    <h1 class="mb-4 fs-3 fw-bold text-success d-flex align-items-center gap-2"><i class="bi bi-speedometer2"></i> Admin Dashboard</h1>
    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card shadow-sm border-success admin-stat-card">
          <div class="card-body">
            <h5 class="card-title text-success d-flex align-items-center gap-2"><i class="bi bi-people"></i> Total Users</h5>
            <p class="card-text fs-4 fw-semibold text-success-emphasis">{{ props.totalUsers }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-success admin-stat-card">
          <div class="card-body">
            <h5 class="card-title text-success d-flex align-items-center gap-2"><i class="bi bi-book"></i> Ebooks Available</h5>
            <p class="card-text fs-4 fw-semibold text-success-emphasis">{{ props.totalBooks }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-success admin-stat-card">
          <div class="card-body">
            <h5 class="card-title text-success d-flex align-items-center gap-2"><i class="bi bi-calendar-plus"></i> New Ebooks This Month</h5>
            <p class="card-text fs-4 fw-semibold text-info">{{ props.newBooksThisMonth }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-success admin-stat-card">
          <div class="card-body">
            <h5 class="card-title text-success d-flex align-items-center gap-2"><i class="bi bi-folder"></i> Categories</h5>
            <p class="card-text fs-4 fw-semibold text-secondary">{{ props.totalCategories }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card shadow-sm border-success admin-stat-card">
          <div class="card-body">
            <h5 class="card-title text-success d-flex align-items-center gap-2"><i class="bi bi-person-check"></i> Active Readers (30d)</h5>
            <p class="card-text fs-4 fw-semibold text-success-emphasis">{{ props.activeReaders }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-success admin-stat-card">
          <div class="card-body">
            <h5 class="card-title text-success d-flex align-items-center gap-2"><i class="bi bi-chat-dots"></i> Feedbacks</h5>
            <p class="card-text fs-4 fw-semibold text-danger">{{ props.feedbacks }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="card h-100 border-success admin-table-card">
          <div class="card-body">
            <h5 class="card-title mb-3 text-success d-flex align-items-center gap-2"><i class="bi bi-person-plus"></i> Recent User Signups</h5>
            <table class="table table-sm mb-0">
              <thead class="table-success">
                <tr>
                  <th><i class="bi bi-person"></i> Name</th>
                  <th><i class="bi bi-envelope"></i> Email</th>
                  <th><i class="bi bi-calendar"></i> Joined</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in props.recentUsers" :key="user.id">
                  <td>{{ user.user_name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ new Date(user.created_at).toLocaleDateString() }}</td>
                </tr>
                <tr v-if="!props.recentUsers.length">
                  <td colspan="3" class="text-center text-muted">No recent users.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card h-100 border-success admin-table-card">
          <div class="card-body">
            <h5 class="card-title mb-3 text-success d-flex align-items-center gap-2"><i class="bi bi-journal-plus"></i> Recently Added Ebooks</h5>
            <table class="table table-sm mb-0">
              <thead class="table-success">
                <tr>
                  <th><i class="bi bi-book"></i> Title</th>
                  <th><i class="bi bi-person"></i> Author</th>
                  <th><i class="bi bi-calendar"></i> Added</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="book in props.recentBooks" :key="book.id">
                  <td>{{ book.title }}</td>
                  <td>{{ book.author }}</td>
                  <td>{{ new Date(book.created_at).toLocaleDateString() }}</td>
                </tr>
                <tr v-if="!props.recentBooks.length">
                  <td colspan="3" class="text-center text-muted">No recent books.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="card h-100 border-success admin-table-card">
          <div class="card-body">
            <h5 class="card-title mb-3 text-success d-flex align-items-center gap-2"><i class="bi bi-book-half"></i> Most Read Ebooks</h5>
            <table class="table table-sm mb-0">
              <thead class="table-success">
                <tr>
                  <th><i class="bi bi-book"></i> Title</th>
                  <th><i class="bi bi-eye"></i> Reads</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in props.mostReadBooks" :key="item.book_id">
                  <td>{{ item.book?.title || 'Unknown' }}</td>
                  <td>{{ item.read_count }}</td>
                </tr>
                <tr v-if="!props.mostReadBooks.length">
                  <td colspan="2" class="text-center text-muted">No data.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card h-100 border-success admin-table-card">
          <div class="card-body">
            <h5 class="card-title mb-3 text-success d-flex align-items-center gap-2"><i class="bi bi-person-lines-fill"></i> Most Active Users</h5>
            <table class="table table-sm mb-0">
              <thead class="table-success">
                <tr>
                  <th><i class="bi bi-person"></i> Name</th>
                  <th><i class="bi bi-eye"></i> Reads</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in props.mostActiveUsers" :key="item.user_id">
                  <td>{{ item.user?.user_name || 'Unknown' }}</td>
                  <td>{{ item.read_count }}</td>
                </tr>
                <tr v-if="!props.mostActiveUsers.length">
                  <td colspan="2" class="text-center text-muted">No data.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-12">
        <div class="card border-success admin-table-card">
          <div class="card-body">
            <h5 class="card-title mb-3 text-success d-flex align-items-center gap-2"><i class="bi bi-graph-up-arrow"></i> Ebook Uploads Over Time</h5>
            <Line :data="uploadsChartData" :options="uploadsChartOptions" height="80" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.admin-stat-card {
  border-width: 2px;
  border-radius: 1.25rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.admin-stat-card:focus-within, .admin-stat-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
.admin-table-card {
  border-width: 2px;
  border-radius: 1.25rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.admin-table-card:focus-within, .admin-table-card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
  border-color: #157347;
}
</style>
