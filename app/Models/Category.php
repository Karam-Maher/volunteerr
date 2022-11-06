<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'image' => 'required|image',
            'status' => ['in:active,archived'],
        ];
    }
}
