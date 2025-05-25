<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'criteria_id',
        'sub_criteria_id',
        'score',
        'weighted_score',
        'notes'
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'weighted_score' => 'decimal:4',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function subCriteria()
    {
        return $this->belongsTo(SubCriteria::class);
    }
}
