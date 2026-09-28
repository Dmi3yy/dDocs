<?php

declare(strict_types=1);

use Dmi3yy\dDocs\dDocsServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

/**
 * Integration check against an installed Evolution CMS runtime.
 * Run: php tests/validation-provider.php /path/to/core/vendor/autoload.php
 */
$autoload = $argv[1] ?? '';
if (!is_file($autoload)) {
    fwrite(STDERR, "Pass the installed CMS vendor/autoload.php path.\n");
    exit(2);
}
require $autoload;
require dirname(__DIR__) . '/src/dDocsServiceProvider.php';

$checks = 0;
$check = static function (bool $condition, string $message) use (&$checks): void {
    $checks++;
    if (!$condition) {
        throw new RuntimeException($message);
    }
};

foreach ([false, true] as $resolvedFirst) {
    $app = new Container();
    $created = 0;
    $app->singleton('validator', static function () use (&$created): Factory {
        $created++;
        return new Factory(new Translator(new ArrayLoader(), 'en'));
    });
    Facade::clearResolvedInstances();
    Facade::setFacadeApplication($app);
    if ($resolvedFirst) {
        $app->make('validator');
    }

    $provider = new dDocsServiceProvider($app);
    (new ReflectionMethod($provider, 'registerValidationRules'))->invoke($provider);
    $check($created === ($resolvedFirst ? 1 : 0), 'Provider eagerly resolved validator');
    $factory = $app->make('validator');
    $check($created === 1, 'Unexpected factory count');

    $cases = [
        ['', true],
        [sys_get_temp_dir(), true],
        [sys_get_temp_dir() . ",\n " . __DIR__, true],
        [__FILE__, false],
        [sys_get_temp_dir() . '/ddocs-absent-' . bin2hex(random_bytes(6)), false],
    ];
    foreach ($cases as [$value, $expected]) {
        $validator = $factory->make(['paths' => $value], ['paths' => 'ddocs_path_list']);
        $check($validator->passes() === $expected, 'Validation result mismatch');
        if (!$expected) {
            $check(
                $validator->errors()->first('paths') === 'dDocs path lists may only contain existing directories.',
                'Validation message changed'
            );
        }
    }
}

Facade::clearResolvedInstances();
Facade::setFacadeApplication(null);
echo "$checks checks passed\n";
