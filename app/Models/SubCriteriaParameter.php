<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCriteriaParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_criteria_id',
        'parameter_name',
        'description',
        'nilai',
        'urutan',
        'is_active'
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function subCriteria()
    {
        return $this->belongsTo(SubCriteria::class);
    }
}
