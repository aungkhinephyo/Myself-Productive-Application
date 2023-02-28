<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'project_id',
        'title',
        'start_date',
        'deadline',
        'priority',
        'status'
    ];
}
