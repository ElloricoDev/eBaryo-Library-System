<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\ReadingLog;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
        $user = Auth::user();
        $lastPercent = null;
        if ($user) {
            $log = ReadingLog::where('user_id', $user->id)->where('book_id', $id)->first();
            if ($log) {
                $lastPercent = $log->last_percent;
            }
        }
        return inertia('User/Books/ReadBook', [
            'book' => $book,
            'lastPercent' => $lastPercent
        ]);
    }

    public function saveProgress(Request $request, $id)
    {
        $user = Auth::user();
        $percent = $request->input('percent');
        if (!$user) {
            abort(401);
        }
        $log = ReadingLog::firstOrNew([
            'user_id' => $user->id,
            'book_id' => $id,
        ]);
        $log->read_at = now();
        if (is_null($log->last_percent) || $percent > $log->last_percent) {
            $log->last_percent = $percent;
        }
        $log->save();
        return back();
    }
}
