<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnantMother extends Model
{
    use HasFactory;

    protected $fillable = [
        'bpjs_number',
        'nik',
        'phone_number',
        'address',
        'kelurahan',
        'pre_pregnancy_weight',
        'current_weight',
        'height',
        'age',
        'hemoglobin',
        'lila',
        'blood_pressure',
        'gestational_age',
        'bmi',
        'note',
    ];
}
