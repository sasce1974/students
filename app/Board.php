<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['name'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public $timestamps = false;
}
