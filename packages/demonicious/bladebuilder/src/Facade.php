<?php

namespace Demonicious\BladeBuilder;

/**
 * @see \HansSchouten\LaravelPageBuilder\LaravelPageBuilder
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return BladeBuilder::class;
    }
}
