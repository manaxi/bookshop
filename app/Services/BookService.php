<?php

namespace App\Services;

use App\Http\Requests\UserBookRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use App\Models\Book;

class BookService
{
    public function handleBookData(UserBookRequest $request)
    {
        $validatedRequest = $request->validated();
        $validatedRequest['cover_image'] = $this->handleCoverUpload($request);
        $validatedRequest['user_id'] = auth()->id();
        $validatedRequest['slug'] = Str::slug($request->title);
        $validatedRequest['status'] = 0;
        return $validatedRequest;
    }

    public function storeOrUpdate(UserBookRequest $request, Book $book = null)
    {
        if (!$book)
            $book = Book::create($this->handleBookData($request));
        else
            $book->update($this->handleBookData($request));
        $this->syncGenresAuthors($request, $book);
        return $book;
    }

    public function syncGenresAuthors(UserBookRequest $request, Book $book)
    {
        $authors = explode(",", $request->authors);
        $author_id = [];
        foreach ($authors as $author) {
            $author_id[] = Author::updateOrCreate(['name' => $author])->id;
        }
        $book->genres()->sync($request->genres);
        $book->authors()->sync($author_id);

        return $book;
    }

    public function handleCoverUpload(UserBookRequest $request)
    {
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
        return $fileNameToStore;
    }
}
