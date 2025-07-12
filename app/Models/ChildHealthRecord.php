<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildHealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'bpjs_number',
        'nik',
        'phone_number',
        'address',
        'kelurahan',
        'gender',
        'weight',
        'height',
        'age_months',
        'note',
    ];
}
