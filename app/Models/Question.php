<?php

namespace App\Models;

use App\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    //
    protected $fillable = ['survey_id', 'question', 'type'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    protected $casts = [
        'type' => QuestionType::class,
    ];
}