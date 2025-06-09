<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAlternative extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_report_id',
        'alternative_id',
        'name',
        'code',
        'email',
        'phone',
        'address',
        'final_score',
        'rank',
        'evaluations_data'
    ];

    protected $casts = [
        'evaluations_data' => 'array'
    ];

    public function report()
    {
        return $this->belongsTo(EvaluationReport::class, 'evaluation_report_id');
    }

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
}
