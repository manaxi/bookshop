<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Carbon\Carbon;

class PagesController extends Controller
{
    public function index()
    {
        $current_dateTime = Carbon::now()->subdays(7);
        $books = Book::approved()->orderBy('created_at', 'desc')->paginate(25);
        return view('pages.index', compact('books', 'current_dateTime'));
    }

    public function show_book($slug)
    {
        $book = Book::find($slug);
        $current_dateTime = Carbon::now()->subdays(7);
        return view('pages.show_book', compact('book', 'current_dateTime'));
    }
}
