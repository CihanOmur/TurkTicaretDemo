<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function todos()
    {
        return $this->belongsToMany(Todos::class);
    }
    public function categories()
{
    return $this->belongsToMany(Category::class);
}

}
