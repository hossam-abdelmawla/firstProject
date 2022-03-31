<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanContent extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'name', 'count'];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
