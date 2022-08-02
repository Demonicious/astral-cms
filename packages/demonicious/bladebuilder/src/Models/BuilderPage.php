<?php

namespace Demonicious\BladeBuilder\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderPage extends Model
{
    use HasFactory;

    protected $table = 'bladebuilder_pages';

    protected $fillable = [
        'name',
        'layout',
        'data'
    ];

    public function translation() {
        return $this->hasOne(BuilderPageTranslation::class, 'page_id', 'id');
    }
}
