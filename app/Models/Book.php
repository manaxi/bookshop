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
    protected $appends = ['discounted_price'];
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

    protected $perPage = 25;

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', '1');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getDiscountedPriceAttribute()
    {
        if ($this->sale_price > '0')
            return round($this->price - ($this->sale_price / 100) * $this->price, 2);
        else
            return $this->price;
    }

    public function getIsNewAttribute()
    {
        return now()->subDays(7) <= $this->created_at;
    }

    public function getRatingAttribute()
    {
        return $this->ratings->where('user_id', auth()->id())->first();
    }
    public function getAvgRatingAttribute()
    {
        return $this->ratings->avg('rate');
    }
}
