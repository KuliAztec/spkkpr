<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AhpMatrix extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteria_id',
        'sub_criteria_id',
        'comparison_type',
        'matrix_data',
        'weights',
        'consistency_ratio',
        'is_valid',
        'created_by'
    ];

    protected $casts = [
        'matrix_data' => 'array',
        'weights' => 'array',
        'consistency_ratio' => 'decimal:4',
        'is_valid' => 'boolean',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function subCriteria()
    {
        return $this->belongsTo(SubCriteria::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
