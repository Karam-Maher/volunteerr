<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function posts(){
        return $this->hasMany(Post::class,'category_id','id');
    }

    public function ScopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }
    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('name', 'LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('status', '=', $value);
        });
    }

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'image' => 'required|image',
            'status' => 'in:active,archived',
        ];
    }
}
