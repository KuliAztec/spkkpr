<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'alternative_id',
        'subcriteria_id',
        'value',
        'normalized_value'
    ];

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }

    public function subcriteria()
    {
        return $this->belongsTo(Subcriteria::class);
    }
}
