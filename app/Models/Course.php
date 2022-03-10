<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function category(){
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function expert(){
        return $this->belongsTo(User::class, 'course_sm_expert');
    }

    public function topics(){
        return $this->hasMany(Topic::class);
    }

}
