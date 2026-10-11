<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'quiz_id',
    'question',
    'options',
    'correct_answer_index',
    'explanation',
    'sort_order',
])]
class QuizQuestion extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'options' => 'array',
            'correct_answer_index' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
