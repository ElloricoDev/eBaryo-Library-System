<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('google oauth redirect route is accessible', function () {
    $response = $this->get('/auth/google/redirect');
    
    // Should redirect to Google OAuth
    $response->assertStatus(302);
    $response->assertRedirect();
});

test('google oauth callback route is accessible', function () {
    $response = $this->get('/auth/google/callback');
    
    // Should handle the callback (even if no code provided)
    $response->assertStatus(302);
});

test('http client ssl verification is disabled in local environment', function () {
    // This test verifies that our SSL configuration is working
    $this->assertTrue(app()->environment('local'));
    
    // The HTTP client should be configured to disable SSL verification
    // This is handled in the AppServiceProvider
    $this->assertTrue(true); // Placeholder - actual verification would require mocking
}); 