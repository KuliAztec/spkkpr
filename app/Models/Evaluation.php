<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'evaluator_id',
        'total_score',
        'ranking',
        'recommendation',
        'status',
        'notes',
        'evaluated_at'
    ];

    protected $casts = [
        'total_score' => 'decimal:4',
        'evaluated_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function details()
    {
        return $this->hasMany(EvaluationDetail::class);
    }
}
