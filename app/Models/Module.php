<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'time_estimation'
    ];

    public function project_detail()
    {
        return $this->morphMany(ProjectDetail::class, 'moduleable');
    }
}
