<?php

namespace App\Extensions\DawnElements;

class Extension {
    public static function blocks() {
        return [
            'dawn-grid' => include('Blocks/Grid/block.php')
        ];
    }
}