<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'address',
        'jenis', // jenis appointment, e.g., 'bumil' or 'bayi'
        'consultation_date',
        'message',
    ];
}
