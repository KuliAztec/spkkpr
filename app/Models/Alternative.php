<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'address',
        'final_score',
        'rank'
    ];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function parameters()
    {
        return $this->belongsToMany(Parameter::class, 'alternative_parameters');
    }

    public function getParameterForSubcriteria($subcriteriaId)
    {
        return $this->parameters()->whereHas('subcriteria', function($query) use ($subcriteriaId) {
            $query->where('id', $subcriteriaId);
        })->first();
    }
}
