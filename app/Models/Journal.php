<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'date', 'content', 'rating'];

    protected $casts = [
        'title' => PurifyHtmlOnGet::class,
        'content' => PurifyHtmlOnGet::class,
    ];
}
