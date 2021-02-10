<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('created_at', 'desc')->paginate(10);
        return view('books.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::get()->pluck('name', 'id');
        $genres = Genre::get()->pluck('name', 'id');
        return view('dashboard.books.create', compact('authors', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'cover_image' => 'mimes:jpeg,jpg,png,gif|nullable|max:1999',
        ]);

        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $book = new Book();
        $book->title = $request->input('title');
        $book->slug = Str::slug($request->input('title'));
        $book->description = $request->input('description');
        $book->user_id = auth()->id();
        $book->status = '0';
        $book->price = $request->input('price');
        $book->sale_price = $request->input('price');
        $book->cover_image = $fileNameToStore;
        $book->save();
        $book->genres()->sync($request->genres);
        $book->authors()->sync($request->authors);

        return redirect()->route('dashboard.index')->with('success', 'Book created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        if (auth()->user()->id !== $book->user_id) {
            return redirect()->route('dashboard.index')->with('error', 'Unauthorized Page');
        }
        $book_authors = Book::find($id)->authors;
        $book_genres = Book::find($id)->genres;
        $authors = Author::all();
        $genres = Genre::all();
        return view('dashboard.books.edit', compact('book', 'book_authors', 'book_genres', 'authors', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'cover_image' => 'mimes:jpeg,jpg,png,gif|nullable|max:1999',
        ]);
        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

            $book = Book::find($id);
            $book->title = $request->input('title');
            $book->slug = Str::slug($request->input('title'));
            $book->description = $request->input('description');
            $book->user_id = auth()->id();
            $book->status = '0';
            $book->price = $request->input('price');
            $book->sale_price = $request->input('price');
            if ($request->hasFile('cover_image')) {
                $book->cover_image = $fileNameToStore;
            }
            $book->save();
            if (isset($request->genres)) {
                $book->genres()->sync($request->genres);
            }
            if (isset($request->authors)) {
                $book->authors()->sync($request->authors);
            }
            return redirect()->route('dashboard.index')->with('success', 'Book updated');
        }
        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        function destroy($id)
        {
            $book = Book::find($id);
            // Check for correct user
            if (auth()->user()->id !== $book->user_id) {
                return redirect()->route('dashboard.index')->with('error', 'Unauthorized Page');
            }
            if ($book->cover_image != 'noimage.jpg') {
                // Delete Image
                Storage::delete('public/cover_images/' . $book->cover_image);
            }
            $book->delete();
            return redirect()->route('dashboard.index')->with('success', 'Book removed');

        }

    }
}
