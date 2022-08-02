<?php

namespace Demonicious\BladeBuilder\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderPageTranslation extends Model
{
    use HasFactory;

    protected $table = 'bladebuilder_page_translations';

    protected $fillable = [
        'page_id',
        'locale',
        'title',
        'route'
    ];
}
