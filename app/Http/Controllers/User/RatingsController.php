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
        $this->validate($request, [
            'rate' => 'required',
        ]);
        $rating = Rating::updateOrCreate(
            ['user_id' => $request->user_id,
                'book_id' => $request->book_id],
            ['rate' => $request->rate,]
        );
        return response()->json(['rating' => $rating->rate]);
    }
    public function show($id)
    {
        $ratings = Rating::findOrFail($id);
        return response()->json(['ratings' => $ratings]);
    }
}
