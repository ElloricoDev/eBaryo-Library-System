<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Welcome" />
  <GuestLayout>
    <div class="container py-5">
      <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3 text-success-emphasis">
          <span class="bg-success bg-opacity-10 px-3 py-2 rounded-3 d-inline-block shadow-sm">
            <i class="bi bi-book me-2 text-success"></i>Welcome to eBaryo Library
          </span>
        </h1>
        <p class="lead mb-4 mx-auto text-secondary" style="max-width: 600px;">
          Discover, read, and access books for your community — anytime, anywhere.
        </p>
        <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mb-4">
          <Link :href="route('login')" class="btn btn-success px-4 shadow-sm w-100 w-md-auto"><i class="bi bi-box-arrow-in-right"></i> Login</Link>
          <Link :href="route('register')" class="btn btn-outline-success px-4 shadow-sm w-100 w-md-auto"><i class="bi bi-person-plus"></i> Register</Link>
        </div>
      </div>

      <!-- About Section -->
      <section id="about" class="mt-5">
        <div class="mx-auto" style="max-width: 700px;">
          <h2 class="h3 fw-semibold mb-3 text-center text-success"><i class="bi bi-info-circle"></i> About eBaryo Library</h2>
          <p class="mb-0 text-center text-secondary">
            eBaryo Library is a digital platform designed to bring books and educational resources to your community. Our mission is to make reading accessible, enjoyable, and convenient for everyone.
          </p>
        </div>
      </section>

      <!-- Features Section -->
      <section id="features" class="mt-5">
        <h2 class="h3 fw-semibold mb-3 text-center text-success"><i class="bi bi-stars"></i> Features</h2>
        <div class="row g-4 justify-content-center">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow feature-card border-0">
              <div class="card-body">
                <h5 class="card-title text-success"><i class="bi bi-people"></i> Community Access</h5>
                <p class="card-text text-secondary">Connect with your local library and access a wide range of books curated for your community.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow feature-card border-0">
              <div class="card-body">
                <h5 class="card-title text-success"><i class="bi bi-tablet"></i> Digital Library</h5>
                <p class="card-text text-secondary">Browse and read books online, anytime and anywhere, from any device.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow feature-card border-0">
              <div class="card-body">
                <h5 class="card-title text-success"><i class="bi bi-person-badge"></i> User Profiles</h5>
                <p class="card-text text-secondary">Create your own profile, track your reading progress, and manage your favorite books.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Testimonials Section -->
      <section id="testimonials" class="mt-5">
        <h2 class="h3 fw-semibold mb-3 text-center text-success"><i class="bi bi-chat-quote"></i> What Our Users Say</h2>
        <div class="row g-4 justify-content-center">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 bg-success bg-opacity-10 text-center shadow testimonial-card">
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                  <p class="text-success-emphasis"><i class="bi bi-emoji-smile"></i> "eBaryo Library made it so easy for me to find books for my kids!"</p>
                  <footer class="blockquote-footer mt-2 text-success">Maria, Parent</footer>
                </blockquote>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 bg-success bg-opacity-10 text-center shadow testimonial-card">
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                  <p class="text-success-emphasis"><i class="bi bi-emoji-smile"></i> "I love being able to read anywhere, anytime. Highly recommended!"</p>
                  <footer class="blockquote-footer mt-2 text-success">John, Student</footer>
                </blockquote>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 bg-success bg-opacity-10 text-center shadow testimonial-card">
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                  <p class="text-success-emphasis"><i class="bi bi-emoji-smile"></i> "A wonderful resource for our whole community."</p>
                  <footer class="blockquote-footer mt-2 text-success">Liza, Teacher</footer>
                </blockquote>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- More Section -->
      <section class="mt-5 mb-4 text-center">
        <div class="mx-auto" style="max-width: 600px;">
          <h2 class="h4 fw-semibold mb-2 text-success">...and more to come!</h2>
          <p class="text-secondary">Stay tuned for new features and updates as we continue to improve your library experience.</p>
        </div>
        <div class="bg-red-500 text-white p-8">This is a Tailwind test</div>
      </section>
    </div>
  </GuestLayout>
</template>

<style scoped>
.feature-card {
  border-top: 4px solid #198754;
  border-radius: 1rem;
  transition: transform 0.15s, box-shadow 0.15s;
}
.feature-card:hover {
  transform: translateY(-4px) scale(1.02);
  box-shadow: 0 0.5rem 1.5rem rgba(25, 135, 84, 0.15);
}
.testimonial-card {
  border-radius: 1rem;
  border-left: 4px solid #198754;
}
</style>
