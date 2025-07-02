<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->latest()->get();
        return inertia('User/Books/Books', [
            'books' => $books
        ]);
    }

    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        return inertia('User/Books/BookDetails', [
            'book' => $book
        ]);
    }

    public function read($id)
    {
        $book = Book::with('category')->findOrFail($id);
        return inertia('User/Books/ReadBook', [
            'book' => $book
        ]);
    }
}
