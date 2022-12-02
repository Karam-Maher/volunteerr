<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;



class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    protected $hidden = [
        'slug', 'updated_at', 'deleted_at','image',
    ];

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
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'category_id' => null,
            'status' => 'active',
        ], $filters);
        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });
        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
    }
        // Accessors
        public function getImageUrlAttribute()
        {
            if ($this->image) {
                return asset('uploads/posts' . $this->image);
            }
        }
        protected $appends=[
            'image_url',
        ];
}
