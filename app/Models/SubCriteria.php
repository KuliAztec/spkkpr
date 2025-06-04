<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteria_id',
        'kode',
        'nama',
        'deskripsi',
        'bobot',
        'is_active'
    ];

    protected $casts = [
        'bobot' => 'decimal:4',
        'is_active' => 'boolean',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function evaluationDetails()
    {
        return $this->hasMany(EvaluationDetail::class);
    }

    public function parameters()
    {
        return $this->hasMany(SubCriteriaParameter::class)->orderBy('urutan');
    }
}
