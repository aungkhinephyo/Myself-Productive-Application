<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_date',
        'deadline',
        'images',
        'files'
    ];

    protected $casts = [
        'images' => 'array',
        'files' => 'array',
    ];

    public function img_path()
    {
        return asset('storage/project/images');
    }

    public function file_path()
    {
        return asset('storage/project/files');
    }
}
