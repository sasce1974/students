<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['grade'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
