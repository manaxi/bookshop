<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Carbon\Carbon;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::with('authors')
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->approved()
            ->latest()
            ->paginate();
        return view('pages.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('pages.show_book', compact('book'));
    }
}
