<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'route',
        'layout',
        'data',
        'html',
        'js',
        'css',
        'homepage'
    ];

    public function uploads() {
        return $this->hasMany(Upload::class);
    }
}
