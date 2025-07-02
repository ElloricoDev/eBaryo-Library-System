<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {
        $books = Book::with('category')->get();

        return inertia('Admin/Books/Index', [
            'books' => $books
        ]);
    }

    public function create() {
        $categories = Category::all();
        return inertia('Admin/Books/Create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn',
            'published_year' => 'nullable|integer',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ebook_file' => 'required|file|max:819200',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable|string',
            'language' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = '/storage/' . $coverPath;
        }
        if ($request->hasFile('ebook_file')) {
            $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);
            $filename = $sanitizedTitle . '_' . time() . '.' . $request->file('ebook_file')->getClientOriginalExtension();
            $ebookPath = $request->file('ebook_file')->storeAs('ebooks', $filename, 'public');
            $validated['ebook_file'] = '/storage/' . $ebookPath;
        }

        Book::create($validated);
        return redirect()->route('admin.books.index')->with('message', 'Book created successfully.');
    }

    public function show($id) {
        $book = Book::with('category')->findOrFail($id);
        return inertia('Admin/Books/View', [
            'book' => $book
        ]);
    }

    public function edit($id) {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return inertia('Admin/Books/Edit', [
            'book' => $book,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id) {
        $book = Book::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'published_year' => 'nullable|integer',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ebook_file' => 'nullable|file|max:819200',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable|string',
            'language' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete previous cover image if exists
            if ($book->cover_image && file_exists(public_path(str_replace('/storage/', 'storage/', $book->cover_image)))) {
                @unlink(public_path(str_replace('/storage/', 'storage/', $book->cover_image)));
            }
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = '/storage/' . $coverPath;
        }
        if ($request->hasFile('ebook_file')) {
            // Delete previous ebook file if exists
            if ($book->ebook_file && file_exists(public_path(str_replace('/storage/', 'storage/', $book->ebook_file)))) {
                @unlink(public_path(str_replace('/storage/', 'storage/', $book->ebook_file)));
            }
            $sanitizedTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);
            $filename = $sanitizedTitle . '_' . time() . '.' . $request->file('ebook_file')->getClientOriginalExtension();
            $ebookPath = $request->file('ebook_file')->storeAs('ebooks', $filename, 'public');
            $validated['ebook_file'] = '/storage/' . $ebookPath;
        }

        $book->update($validated);
        return redirect()->route('admin.books.index')->with('message', 'Book updated successfully.');
    }

    public function destroy($id) {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('admin.books.index')->with('message', 'Book deleted successfully.');
    }
}
