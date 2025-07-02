<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Welcome" />
  <GuestLayout>
    <div class="container py-5">
      <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Welcome to eBaryo Library</h1>
        <p class="lead mb-4 mx-auto" style="max-width: 600px;">
          Discover, read, and access books for your community — anytime, anywhere.
        </p>
        <div class="d-flex justify-content-center gap-3 mb-4">
          <Link :href="route('login')" class="btn btn-primary px-4"><i class="bi bi-box-arrow-in-right"></i> Login</Link>
          <Link :href="route('register')" class="btn btn-outline-primary px-4"><i class="bi bi-person-plus"></i> Register</Link>
        </div>
      </div>

      <!-- About Section -->
      <section id="about" class="mt-5">
        <div class="mx-auto" style="max-width: 700px;">
          <h2 class="h3 fw-semibold mb-3 text-center"><i class="bi bi-info-circle"></i> About eBaryo Library</h2>
          <p class="mb-0 text-center">
            eBaryo Library is a digital platform designed to bring books and educational resources to your community. Our mission is to make reading accessible, enjoyable, and convenient for everyone.
          </p>
        </div>
      </section>

      <!-- Features Section -->
      <section id="features" class="mt-5">
        <h2 class="h3 fw-semibold mb-3 text-center"><i class="bi bi-stars"></i> Features</h2>
        <div class="row g-4 justify-content-center">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm text-center">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Community Access</h5>
                <p class="card-text">Connect with your local library and access a wide range of books curated for your community.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm text-center">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-tablet"></i> Digital Library</h5>
                <p class="card-text">Browse and read books online, anytime and anywhere, from any device.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm text-center">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-person-badge"></i> User Profiles</h5>
                <p class="card-text">Create your own profile, track your reading progress, and manage your favorite books.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Testimonials Section -->
      <section id="testimonials" class="mt-5">
        <h2 class="h3 fw-semibold mb-3 text-center"><i class="bi bi-chat-quote"></i> What Our Users Say</h2>
        <div class="row g-4 justify-content-center">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 bg-light text-center">
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                  <p><i class="bi bi-emoji-smile"></i> "eBaryo Library made it so easy for me to find books for my kids!"</p>
                  <footer class="blockquote-footer mt-2">Maria, Parent</footer>
                </blockquote>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 bg-light text-center">
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                  <p><i class="bi bi-emoji-smile"></i> "I love being able to read anywhere, anytime. Highly recommended!"</p>
                  <footer class="blockquote-footer mt-2">John, Student</footer>
                </blockquote>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 bg-light text-center">
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                  <p><i class="bi bi-emoji-smile"></i> "A wonderful resource for our whole community."</p>
                  <footer class="blockquote-footer mt-2">Liza, Teacher</footer>
                </blockquote>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- More Section -->
      <section class="mt-5 mb-4 text-center">
        <div class="mx-auto" style="max-width: 600px;">
          <h2 class="h4 fw-semibold mb-2">...and more to come!</h2>
          <p>Stay tuned for new features and updates as we continue to improve your library experience.</p>
        </div>
      </section>
    </div>
  </GuestLayout>
</template>
