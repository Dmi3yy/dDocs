<?php namespace Dmi3yy\dDocs;

use EvolutionCMS\ServiceProvider;
use Dmi3yy\dDocs\Support\ManagerText;
use Illuminate\Support\Facades\Validator;
use Livewire\Livewire;

class dDocsServiceProvider extends ServiceProvider
{
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

    protected function registerValidationRules(): void
    {
        if (!class_exists(Validator::class)) {
            return;
        }

        Validator::extend('ddocs_path_list', function (string $attribute, mixed $value): bool {
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
    }
}
