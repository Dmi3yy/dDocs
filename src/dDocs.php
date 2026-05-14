<?php namespace Dmi3yy\dDocs;

use Dmi3yy\dDocs\Support\ManagerText;

class dDocs
{
    public function config(string $key, mixed $default = null): mixed
    {
        return config('dmi3yy.settings.dDocs.' . $key, $default);
    }

    public function moduleUrl(): string
    {
        return 'index.php?a=112&id=' . md5(ManagerText::get('module_title'));
    }
}
