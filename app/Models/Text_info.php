<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text_info extends Model
{
    use HasFactory;

    protected $fillable = [
    'text_title',
    'method',
    'chapter',
    'grade',
    'extra_info',
    'contributor'
    ];
}
