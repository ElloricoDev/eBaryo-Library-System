<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\ReadingLog;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        $user = Auth::user();
        $continueReading = null;
        $savedBookIds = $user ? $user->savedBooks()->pluck('book_id')->toArray() : [];
        if ($user) {
            $continueReading = ReadingLog::with('book')
                ->where('user_id', $user->id)
                ->where('last_percent', '>', 0)
                ->orderByDesc('updated_at')
                ->first();
        }
        return inertia('User/Home', [
            'books' => $books,
            'continueReading' => $continueReading,
            'saved_books' => $savedBookIds,
        ]);
    }
}
