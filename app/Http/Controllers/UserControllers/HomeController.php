<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        return inertia('User/Home', [
            'books' => $books
        ]);
    }
}
