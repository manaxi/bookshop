<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'genres' => 'required',
            'authors' => 'required',
            'sale_price' => 'required',
            'cover_image' => 'mimes:jpeg,jpg,png,gif|nullable|max:1999',
        ];
    }
}
