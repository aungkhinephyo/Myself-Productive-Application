<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content'];

    protected $casts = [
        'title' => PurifyHtmlOnGet::class,
        'content' => PurifyHtmlOnGet::class,
    ];
}
