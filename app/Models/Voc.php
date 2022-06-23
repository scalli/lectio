<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voc extends Model
{
    use HasFactory;

    protected $fillable = [
    'word',
    'memorize',
    'wordinfo1',
    'wordinfo2',
    'wordinfo3',
    'wordinfo4',
    'meaning1',
    'meaning2',
    'meaning3',
    'meaning4',
    'part_of_speech',
    'parentheses',
    'contributor'
    ];
}
