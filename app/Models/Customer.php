<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nik',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_pernikahan',
        'pekerjaan',
        'penghasilan_pribadi',
        'penghasilan_pasangan',
        'status',
        'created_by'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'penghasilan_pribadi' => 'decimal:2',
        'penghasilan_pasangan' => 'decimal:2',
    ];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
