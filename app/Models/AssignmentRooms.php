<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentRooms extends Model
{
    use HasFactory;

    protected $fillable = [
        'numberRooms',
        'typeRoom',
        'typeAccomodation',
        'idHotel',
    ];
}
