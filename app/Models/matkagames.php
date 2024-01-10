<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matkagames extends Model
{
    protected $fillable=[
        'mid',
        'mname',
        'mopened',
        'mclosed',
        'mstatus',
        'mballs',
        'mlocktime',
        'mstarttime',
        'mamount',
        'menteramount',
        'mwinball',
    ];

    use HasFactory;
}
