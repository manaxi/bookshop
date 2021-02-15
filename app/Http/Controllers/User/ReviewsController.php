<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;
use Auth;

class ReviewsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'review' => 'required|max:255',
        ]);
        $book = Book::findOrFail($request->book_id);
        Review::create([
            'review' => $request->review,
            'user_id' => Auth::id(),
            'book_id' => $book->id,
        ]);
        return redirect()->route('books.show', $book->slug)->with('success', 'Review added');
    }

    public function edit($id)
    {
        $review = Review::find($id);
        return response()->json(['data' => $review]);
    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'review' => 'required|max:255',
        ]);
        $review = Review::find($request->id);
        $review->review = $request->input('review');
        $review->update();
        return redirect()->route('books.show', $review->book->slug)->with('success', 'Review updated');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('books.show', $review->book->slug)->with('success', 'Review deleted');
    }
}
