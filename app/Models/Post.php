<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'location' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3',
            'image' => 'nullable|image',
            'status' => ['in:active,archived'],
        ];
    }
}
