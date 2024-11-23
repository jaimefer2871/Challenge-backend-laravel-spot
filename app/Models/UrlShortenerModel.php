<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UrlShortenerModel extends Model
{

    protected $table = 'urlshorteners';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'original',
        'shortened'
    ];
}
