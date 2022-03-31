<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'no._of_days', 'no._of_meals', 'no._of_weeks'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
