<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Rating;
use Auth;

class RatingsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'star' => 'required',
        ]);
        $rating = Rating::create([
            'rate' => $request->star,
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
        ]);
        return response()->json(['rating' => $rating->rate]);
       // return redirect()->route('show_book', $book->id)->with('success', 'Rating added');
    }
}
