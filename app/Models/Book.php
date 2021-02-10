<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    //table name
    protected $table = 'books';
    //primary key
    public $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'sale_price',
        'cover_image',
        'user_id',
        'status',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }
}