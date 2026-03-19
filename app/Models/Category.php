<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'icon',
        'description',
    ];

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function getApiResponseAttribute()
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'icon' => asset($this->icon),
            'childs' => $this->childs->pluck('api_response_with_childs'),
            'description' => $this->description,
        ];
    }

    public function getApiResponseWithChildsAttribute()
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
