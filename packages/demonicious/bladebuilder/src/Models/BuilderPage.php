<?php

namespace Demonicious\BladeBuilder\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'layout',
        'data'
    ];
}
