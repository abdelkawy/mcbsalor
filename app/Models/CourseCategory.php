<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function courses(){

        return $this->hasMany(Course::class);
    }

    public function parent(){
        return $this->belongsTo(CourseCategory::class, 'parent_category');
    }

    public function child(){
        return $this->hasMany(CourseCategory::class, 'parent_category');
    }
}
