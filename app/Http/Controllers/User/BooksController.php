<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserBookRequest;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Datables;
use Auth;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BooksController extends Controller
{
    public function index()
    {
        $books = auth()->user()->books()->with('authors')
            ->latest()
            ->paginate();
        return view('dashboard.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('dashboard.books.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserBookRequest $request, BookService $bookService)
    {
        $bookService->storeOrUpdate($request);
         return redirect()->route('dashboard.books.index')->with('success', 'Book created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $this->authorize('editAndUpdate', $book);
        $authors = implode(",", $book->authors()->pluck('name')->toArray());
        $genres = Genre::all();
        return view('dashboard.books.edit', compact('book', 'authors', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserBookRequest $request, Book $book, BookService $bookService)
    {
        $this->authorize('editAndUpdate', $book);
        $bookService->storeOrUpdate($request, $book);
        return redirect()->route('dashboard.books.index')->with('success', 'Book updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('dashboard.books.index')->with('success', 'Book deleted');
    }

}
