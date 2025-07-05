<?php

use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can save a book', function () {
    $user = User::factory()->create();
    $book = Book::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('books.save', $book->id));

    $response->assertRedirect();
    $this->assertTrue($user->savedBooks()->where('book_id', $book->id)->exists());
});

test('user cannot save the same book twice', function () {
    $user = User::factory()->create();
    $book = Book::factory()->create();

    // Save the book first time
    $this->actingAs($user)
        ->post(route('books.save', $book->id));

    // Try to save the same book again
    $this->actingAs($user)
        ->post(route('books.save', $book->id));

    // Should only have one record
    $this->assertEquals(1, $user->savedBooks()->where('book_id', $book->id)->count());
});

test('user can unsave a book', function () {
    $user = User::factory()->create();
    $book = Book::factory()->create();

    // Save the book first
    $user->savedBooks()->attach($book->id);

    $response = $this->actingAs($user)
        ->post(route('books.unsave', $book->id));

    $response->assertRedirect();
    $this->assertFalse($user->savedBooks()->where('book_id', $book->id)->exists());
});

test('user can view saved books', function () {
    $user = User::factory()->create();
    $book = Book::factory()->create();

    // Save the book
    $user->savedBooks()->attach($book->id);

    $response = $this->actingAs($user)
        ->get(route('books.saved'));

    $response->assertInertia(fn ($page) => 
        $page->component('User/Books/Saved')
            ->has('books', 1)
            ->where('books.0.id', $book->id)
    );
}); 