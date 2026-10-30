<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //same for models we can create basemodel where we can write the useful methods and use them here like any scope or anything 
    protected $fillable = ['title', 'description', 'due_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
