<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

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
        return BookResource::collection($books);
    }
}
