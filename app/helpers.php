<?php

use Illuminate\Support\Facades\Storage;

function storage_url($object) {
    return Storage::url($object);
}