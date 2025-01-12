<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //
    public $fillable = ['user_id', 'title', 'description', 'status', 'start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function questions()
    // {
    //     return $this->hasMany(Question::class);
    // }

    // public function responses()
    // {
    //     return $this->hasMany(Response::class);
    // }
}
