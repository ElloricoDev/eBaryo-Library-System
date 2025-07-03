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
    <h1 class="mb-4 fs-3 fw-bold">Admin Dashboard</h1>
    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Total Users</h5>
            <p class="card-text fs-4 fw-semibold text-primary">{{ props.totalUsers }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Ebooks Available</h5>
            <p class="card-text fs-4 fw-semibold text-success">{{ props.totalBooks }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">New Ebooks This Month</h5>
            <p class="card-text fs-4 fw-semibold text-info">{{ props.newBooksThisMonth }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Categories</h5>
            <p class="card-text fs-4 fw-semibold text-secondary">{{ props.totalCategories }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Active Readers (30d)</h5>
            <p class="card-text fs-4 fw-semibold text-primary">{{ props.activeReaders }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Feedbacks</h5>
            <p class="card-text fs-4 fw-semibold text-danger">{{ props.feedbacks }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-3">Recent User Signups</h5>
            <table class="table table-sm mb-0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Joined</th>
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
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-3">Recently Added Ebooks</h5>
            <table class="table table-sm mb-0">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Added</th>
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
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-3">Most Read Ebooks</h5>
            <table class="table table-sm mb-0">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Reads</th>
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
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-3">Most Active Users</h5>
            <table class="table table-sm mb-0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Reads</th>
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
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-3">Ebook Uploads Over Time</h5>
            <Line :data="uploadsChartData" :options="uploadsChartOptions" height="80" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
