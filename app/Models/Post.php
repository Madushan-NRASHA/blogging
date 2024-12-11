<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';

    protected $fillable = [ 'u_id', 'mainctg_id', 'subctg_id', 'content','title','images','video', 'status'];



    protected $attributes = [
        'status' => null, // or 'pending' if you prefer
    ];

    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'mainctg_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'subctg_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'u_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }



}
