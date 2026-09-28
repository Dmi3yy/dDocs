<?php namespace Dmi3yy\dDocs;

use EvolutionCMS\ServiceProvider;
use Dmi3yy\dDocs\Support\ManagerText;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Livewire\Livewire;

/**
 * Boots the dDocs manager module and its documentation runtime.
 *
 * The provider keeps Evolution's standard module registration for routing and
 * permissions, while manager-only hooks adapt how the module is presented.
 */
class dDocsServiceProvider extends ServiceProvider
{
    /**
     * Register manager assets, translations, Livewire components, and menu placement.
     *
     * The manager frame builds its utility menu outside the regular module menu.
     * Once that frame is ready, the hook replaces Help with the existing dDocs
     * module item, retaining Evolution's generated URL, CSRF token, icon, and target.
     */
    public function boot(): void
    {
        include(__DIR__ . '/Http/routes.php');

        $this->mergeConfigFrom(dirname(__DIR__) . '/config/dDocsSettings.php', 'dmi3yy.settings.dDocs');
        $this->loadViewsFrom(dirname(__DIR__) . '/views', 'dDocs');
        $this->loadTranslationsFrom(dirname(__DIR__) . '/lang', 'dDocs');
        $this->registerValidationRules();

        if (defined('IN_MANAGER_MODE') && IN_MANAGER_MODE) {
            $this->mergeConfigFrom(dirname(__DIR__) . '/config/settings/form.php', 'evo-ui.forms.ddocs.settings');

            Livewire::component('ddocs.module-panel', \Dmi3yy\dDocs\Livewire\ModulePanel::class);

            $this->publishes([
                dirname(__DIR__) . '/config/dDocsAlias.php' => config_path('app/aliases/dDocs.php', true),
                dirname(__DIR__) . '/config/dDocsSettings.php' => config_path('dmi3yy/settings/dDocs.php', true),
            ], 'ddocs');

            $labels = ManagerText::all();
            $moduleTitle = $labels['module_title'] ?? $labels['docs'];
            $moduleItemId = 'module' . md5($moduleTitle);

            Event::listen('evolution.OnManagerTopPrerender', static function () use ($moduleItemId): string {
                $encodedModuleItemId = json_encode($moduleItemId, JSON_THROW_ON_ERROR);

                return <<<HTML
<script>
document.addEventListener('DOMContentLoaded', function () {
    const moduleItem = document.getElementById({$encodedModuleItemId});
    const systemMenu = document.querySelector('#system > .dropdown-menu');

    if (!moduleItem || !systemMenu) {
        return;
    }

    const helpItem = systemMenu.querySelector('a[href="index.php?a=9"]')?.closest('li');
    const versionItem = systemMenu.querySelector('.dropdown-item')?.closest('li');

    if (helpItem) {
        helpItem.replaceWith(moduleItem);
    } else if (versionItem) {
        versionItem.before(moduleItem);
    } else {
        systemMenu.append(moduleItem);
    }
});
</script>
HTML;
            });
        }

        $this->app->singleton(dDocs::class);
        $this->app->alias(dDocs::class, 'dDocs');
    }

    public function register(): void
    {
        if (defined('IN_MANAGER_MODE') && IN_MANAGER_MODE) {
            $labels = ManagerText::all();
            $moduleFile = dirname(__DIR__) . '/module/dDocsModule.php';
            $icon = $labels['module_icon'] ?? $labels['docs_icon'];
            $title = $labels['module_title'] ?? $labels['docs'];

            if (is_file($moduleFile)) {
                foreach ($this->moduleAliases($title) as $alias) {
                    $this->app->registerModule($alias, $moduleFile, $icon, [
                        'hidden' => true,
                    ]);
                }

                $this->app->registerModule($title, $moduleFile, $icon);
            }
        }
    }

    /**
     * @return list<string>
     */
    protected function moduleAliases(string $currentTitle): array
    {
        return array_values(array_diff(array_filter(array_unique([
            'Docs',
            'Documentation',
            'Документація',
            'Документация',
        ]), fn (string $alias): bool => trim($alias) !== ''), [$currentTitle]));
    }

    /**
     * Attach path validation on first validator use, or to the existing factory.
     * Requests without validation do not need to construct its dependencies.
     */
    protected function registerValidationRules(): void
    {
        if (!class_exists(Validator::class)) {
            return;
        }

        $this->callAfterResolving('validator', static function ($validator): void {
            $validator->extend('ddocs_path_list', function (string $attribute, mixed $value): bool {
                foreach (preg_split('/[\r\n,]+/', (string) $value) ?: [] as $path) {
                    $path = trim($path);
                    if ($path === '') {
                        continue;
                    }

                    $real = realpath($path);
                    if ($real === false || !is_dir($real)) {
                        return false;
                    }
                }

                return true;
            }, 'dDocs path lists may only contain existing directories.');
        });
    }
}
