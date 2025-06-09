<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcriteria_id',
        'parameter_name',
        'description',
        'nilai',
        'urutan'
    ];

    public function subcriteria()
    {
        return $this->belongsTo(Subcriteria::class);
    }

    public function alternatives()
    {
        return $this->belongsToMany(Alternative::class, 'alternative_parameters');
    }
}
