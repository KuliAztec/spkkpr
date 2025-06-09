<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcriteria extends Model
{
    use HasFactory;

    protected $table = 'subcriteria';

    protected $fillable = [
        'criteria_id',
        'code',
        'name',
        'description',
        'weight'
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function parameters()
    {
        return $this->hasMany(Parameter::class);
    }
}
