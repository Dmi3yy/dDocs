<?php namespace Dmi3yy\dDocs\Facades;

use Illuminate\Support\Facades\Facade;

class dDocs extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Dmi3yy\dDocs\dDocs::class;
    }
}
