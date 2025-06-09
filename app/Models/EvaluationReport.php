<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'calculation_date',
        'total_alternatives',
        'total_criteria',
        'total_subcriteria'
    ];

    protected $casts = [
        'calculation_date' => 'datetime'
    ];

    public function alternatives()
    {
        return $this->hasMany(ReportAlternative::class);
    }
}
