<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function subCriterias()
    {
        return $this->hasMany(SubCriteria::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
