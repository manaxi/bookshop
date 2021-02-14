<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->word;
        $slug = Str::slug($title);
        return [
            'title' => $title,
            'slug' => $slug,
            'price' => $this->faker->randomFloat(2,0,90),
            'sale_price' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->paragraph,
            'cover_image' => $this->faker->image('storage/app/public/cover_images', 400 ,300,null , false),
            'user_id' => User::all()->random()->id,
            'status' => '1'
        ];
    }
}
