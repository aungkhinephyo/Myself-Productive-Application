<?php

namespace App\Models;

use App\Models\LibraryType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Library extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'link',
        'library_type_id'
    ];

    public function library_type()
    {
        return $this->belongsTo(LibraryType::class, 'library_type_id', 'id');
    }
}
