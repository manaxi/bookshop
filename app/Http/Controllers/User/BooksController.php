<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
        $authors = Author::get()->pluck('name', 'id');
        $genres = Genre::all();
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
            'genres' => 'required',
            'authors' => 'required',
            'sale_price' => 'required',
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
        $book->sale_price = $request->input('sale_price');
        $book->cover_image = $fileNameToStore;
        $book->save();
        $authors = explode(",", $request->authors);
        foreach ($authors as $author) {
            $data = Author::updateOrCreate(['name' => $author]);
            $author_id[] = $data->id;
        }
        $book->genres()->sync($request->genres);
        $book->authors()->sync($author_id);

        return redirect()->route('dashboard.books.index')->with('success', 'Book created.');
    }

    public function show()
    {

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
        $authors = Author::all();
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
        }

        $book = Book::find($id);
        $book->title = $request->input('title');
        $book->slug = Str::slug($request->input('title'));
        $book->description = $request->input('description');
        $book->user_id = auth()->id();
        $book->status = $book->status;
        $book->price = $request->input('price');
        $book->sale_price = $request->input('sale_price');
        if ($request->hasFile('cover_image')) {
            $book->cover_image = $fileNameToStore;
        }
        $book->save();
        $book->genres()->sync((array)$request->input('genres'));
        $book->authors()->sync((array)$request->input('authors'));
        return redirect()->route('dashboard.books.index')->with('success', 'Book updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Book::where('id', $id)->delete();
        return redirect()->route('dashboard.books.index')->with('success', 'Book deleted');
    }

}
