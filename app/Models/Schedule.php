<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    protected $fillable = [
    'date', 'start_time', 'end_time', 'auditorium', 'group'
];
}
