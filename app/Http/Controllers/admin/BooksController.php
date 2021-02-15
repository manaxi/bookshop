<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;
use Auth;
use App\Models\Book;
use Illuminate\Support\Str;

class BooksController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {

            $data = Book::select('*');
            return datatables()->of($data)
                ->addColumn('cover_image', function ($row) {
                    $url = asset('storage/cover_images/' . $row->cover_image);
                    return '<img src="' . $url . '" border="0" width="80" height="150" class="img-rounded" align="center" />';
                })
                ->addColumn('authors', function ($row) {
                    $authors = [];
                    foreach ($row->authors as $author)
                        $authors[] = $author->name;
                    return $authors;
                })
                ->addColumn('genres', function ($row) {
                    $genres = [];
                    foreach ($row->genres as $genre) {
                        $genres[] = $genre->name;
                    }
                    return $genres;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "0")
                        return "Waiting for approval";
                    else
                        return "Approved";
                })
                ->addColumn('action', 'admin.books.action')
                ->rawColumns(['action', 'authors', 'genres', 'cover_image'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.books.index');
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
        return view('admin.books.create', compact('authors', 'genres'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
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
        $book->status = '1';
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

        return redirect()->route('admin.books.index')->with('success', 'Book created.');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $book = Book::find($id);
        $authors = Author::get()->pluck('name', 'id');
        $genres = Genre::get()->pluck('name', 'id');
        return view('admin.books.edit', compact('book', 'authors', 'genres'));
    }

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
        $book->user_id = $book->user_id;
        $book->status = (int)$request->has('status');
        $book->price = $request->input('price');
        $book->sale_price = $request->input('sale_price');
        if ($request->hasFile('cover_image')) {
            $book->cover_image = $fileNameToStore;
        }
        $book->save();
        $book->genres()->sync((array)$request->input('genres'));
        $book->authors()->sync((array)$request->input('authors'));
        return redirect()->route('admin.books.index')->with('success', 'Book updated');
    }

    public function destroy($id)
    {
        $delete = Book::where('id', $id)->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted');
    }
}
