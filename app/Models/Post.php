<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')
            ->withDefault(
                [
                    'name' => 'اسم الفئة'
                ]
            );
    }

    public static function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'location' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3',
            'image' => 'required|image',
            'category_id' => 'required|image',
            'status' => ['in:active,archived'],
        ];
    }
}
