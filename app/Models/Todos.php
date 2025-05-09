<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'todo_category', 'todo_id', 'category_id');
    }
}
