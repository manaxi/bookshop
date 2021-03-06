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
        return redirect()->route('books.show', $book)->with('success', 'Review added');
    }

    public function edit(Review $review)
    {
        return view('dashboard.reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'review' => 'required|max:255',
        ]);
        $review = Review::find($id);
        $review->review = $request->input('review');
        $review->update();
        return redirect()->route('books.show', $review->book)->with('success', 'Review updated');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('books.show', $review->book)->with('success', 'Review deleted');
    }
}
