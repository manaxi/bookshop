<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    //table name
    protected $table = 'authors';
    //primary key
    public $primaryKey = 'id';
    //disable timestamps
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
