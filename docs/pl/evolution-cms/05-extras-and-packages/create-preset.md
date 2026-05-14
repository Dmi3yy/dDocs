# Utwórz Preset

[Extras I Pakiety](README.md) / Utwórz Preset

Presets to ready-site scaffolds dla projektów Evolution CMS. Package dodaje
component do project; preset tworzy startowy kształt całego project.

Używaj preset, gdy chcesz powtarzalnie tworzyć site baseline: views, theme
assets, controllers, starter config, required Extras i optional seeders.

## Preset Czy Package

| Potrzeba | Użyj |
| --- | --- |
| Reusable manager module, editor, integration, parser element albo service. | Package |
| Reusable frontend/backend capability dla wielu projektów. | Package |
| Nowy project ze znanym layout, theme, views, config i required Extras. | Preset |
| Blog starter, landing-page starter, shop starter albo agency baseline. | Preset |

Preset może zawierać mały custom package dla site-specific controllers, routes,
seeders albo service provider wiring. To nadal project-layer scaffold.

## Instalacja Preset

Presets są stosowane przez standalone installer podczas tworzenia project.

```console
evo install my-site \
  --branch=3.5.x \
  --preset=evolution-cms-presets/default-daisyui
```

Non-interactive install:

```console
evo install my-site \
  --cli \
  --branch=3.5.x \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-username=admin \
  --admin-email=admin@example.com \
  --admin-password=change-me \
  --admin-directory=manager \
  --language=uk \
  --preset=evolution-cms-presets/default-daisyui
```

Do rozwoju preset można wskazać local preset reference:

```console
evo install preset-check \
  --branch=3.5.x \
  --preset=path/to/preset
```

## Preset Layout

Modern preset zawiera tylko project layer kopiowany przez installer.

```text
preset-name/
  README.md
  LICENSE
  .gitignore
  robots.txt
  core/
    custom/
      composer.json
      config/
        cms/settings/ControllerNamespace.php
        presets/preset-name.php
      packages/
        preset-name/
          src/
            PresetNameServiceProvider.php
            composer.json
            Controllers/
            Http/
            Seeders/
  views/
    home.blade.php
    layouts/base.blade.php
    partials/
  themes/
    preset-name/
      css/
      js/
```

Nie commituj Evolution core, manager files, runtime cache, local databases,
local secrets ani IDE workspace files do preset.

## Project Composer

`core/custom/composer.json` opisuje project-layer autoloading i required Composer
Extras.

```json
{
  "name": "evolution-cms-presets/example-project-layer",
  "type": "project",
  "require": {
    "evolution-cms/etinymce": "*"
  },
  "autoload": {
    "psr-4": {
      "EvolutionCMS\\ExamplePreset\\": "packages/example-preset/src/"
    }
  }
}
```

Required Extras dodawaj tylko, gdy starter site bez nich nie działa. Optional
Extras powinny pozostać optional w installer.

## Custom Package Layer

Mały custom package w `core/custom/packages` służy do site-layer PHP:

- service provider registration;
- frontend routes;
- controllers;
- starter seeders;
- tiny support classes.

Generic manager modules, reusable APIs, tables i integration logic należą do
oddzielnych packages.

## Service Provider

Preset service provider powinien pozostać mały.

Zalecane responsibilities:

- include local route file only if it exists;
- load package/site views when preset uses a view namespace;
- register seeders or commands only when installer/project flow needs them;
- avoid side effects during every request.

```php
final class BlogPresetServiceProvider extends ServiceProvider
{
    protected $namespace = 'blog-preset';

    public function boot(): void
    {
        $routes = __DIR__ . '/Http/routes.php';
        if (is_file($routes)) {
            include $routes;
        }

        $this->loadViewsFrom(dirname(__DIR__) . '/views', 'blog-preset');
    }
}
```

## Views And Controllers

Views definiują startowy frontend:

- `views/layouts/base.blade.php`;
- `views/home.blade.php`;
- `views/partials/*`;
- site-type specific views, na przykład `blog.blade.php` albo
  `contact.blade.php`.

Controllers powinny zostać blisko starter use case. Default preset zwykle
potrzebuje tylko `HomeController`. Blog preset może dodać blog, post i contact
controllers, bo są częścią site baseline.

## Theme Assets

Theme assets trzymaj w `themes/<preset-name>/`. Preset powinien działać od razu
po install; Node build nie powinien być wymagany do pierwszego renderu strony.

DaisyUI presets mogą używać CDN-loaded DaisyUI/Tailwind browser assets i małego
theme controller script dla light/dark/theme switching. Custom DaisyUI theme
tokens trzymaj w preset theme CSS file.

## Preset Config

Preset-specific settings trzymaj w `core/custom/config/presets/<preset>.php`.
Używaj ich dla theme defaults, visible theme lists, feature flags i starter route
defaults. Secrets nie należą do preset config.

## Seeders

Seeders powinny tworzyć tylko starter state:

- default site template;
- template alias dla starter Blade view;
- starter resources dla content-rich presets;
- idempotent operations.

Nie dodawaj dużych demo records, które każdy realny site musi usuwać.

## README Contract

README preset powinien opisywać:

- site purpose;
- included files;
- install flow;
- required Extras;
- frontend build requirements;
- locations for views/theme/config and PHP site logic;
- next project step.

## Validation

Przed release utwórz fresh project z preset.

```console
evo install preset-check \
  --cli \
  --branch=3.5.x \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-username=admin \
  --admin-email=admin@example.com \
  --admin-password=change-me \
  --admin-directory=manager \
  --language=uk \
  --preset=evolution-cms-presets/preset-name
```

Następnie sprawdź first page, manager login, required Extras, Composer autoload,
routes/controllers, theme assets, idempotent seeders i generated project
`.gitignore`.

## Release Checklist

Sprawdź:

- lowercase kebab-case name;
- README;
- project-layer files only;
- `core/custom/composer.json`;
- small service provider;
- site-specific controllers/routes;
- renderable views;
- theme assets;
- no secrets in config;
- idempotent seeders;
- installer remote reference.
