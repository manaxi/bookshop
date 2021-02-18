<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    public function editAndUpdate(User $user, Book $book)
    {
        return ($book->user_id === $user->id || $user->hasRole('Admin'));
    }
}
