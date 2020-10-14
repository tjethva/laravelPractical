<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'connection_id'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
}
