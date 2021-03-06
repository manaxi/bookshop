<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Report;
use Auth;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'body' => 'required|max:255',
        ]);
        $book = Book::findOrFail($request->book_id);
        Report::create([
            'body' => $request->body,
            'status' => 0,
            'user_id' => Auth::id(),
            'book_id' => $book->id,
        ]);
        return redirect()->route('books.show', $book)->with('success', 'Report added');
    }
}
