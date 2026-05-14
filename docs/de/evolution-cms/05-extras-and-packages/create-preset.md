# Preset Erstellen

[Extras Und Pakete](README.md) / Preset Erstellen

Presets sind ready-site scaffolds fuer Evolution CMS Projekte. Ein package fuegt
einem project eine component hinzu; ein preset erstellt die Startform des
project selbst.

Nutze ein preset fuer wiederholbare site baselines: views, theme assets,
controllers, starter config, required Extras und optional seeders.

## Preset Oder Package

| Bedarf | Nutze |
| --- | --- |
| Reusable manager module, editor, integration, parser element oder service. | Package |
| Reusable frontend/backend capability fuer mehrere Projekte. | Package |
| Neues project mit bekanntem layout, theme, views, config und required Extras. | Preset |
| Blog starter, landing-page starter, shop starter oder agency baseline. | Preset |

Ein preset kann ein kleines custom package fuer site-specific controllers,
routes, seeders oder service provider wiring enthalten. Es bleibt trotzdem ein
project-layer scaffold.

## Preset Installieren

Presets werden vom standalone installer waehrend der project creation
angewendet.

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

Fuer preset development kann eine local preset reference genutzt werden:

```console
evo install preset-check \
  --branch=3.5.x \
  --preset=path/to/preset
```

## Preset Layout

Ein modern preset enthaelt nur den project layer, den der installer kopiert.

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

Committe keine Evolution core files, manager files, runtime cache, local
databases, local secrets oder IDE workspace files in ein preset.

## Project Composer

`core/custom/composer.json` beschreibt project-layer autoloading und required
Composer Extras.

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

Required Extras nur verwenden, wenn der starter site ohne sie nicht funktioniert.
Optional Extras bleiben optional im installer.

## Custom Package Layer

Ein kleines custom package in `core/custom/packages` ist fuer site-layer PHP:

- service provider registration;
- frontend routes;
- controllers;
- starter seeders;
- tiny support classes.

Generic manager modules, reusable APIs, tables und integration logic gehoeren in
separate packages.

## Service Provider

Der preset service provider sollte klein bleiben.

Empfohlene responsibilities:

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

Views definieren das starter frontend:

- `views/layouts/base.blade.php`;
- `views/home.blade.php`;
- `views/partials/*`;
- site-type specific views, zum Beispiel `blog.blade.php` oder
  `contact.blade.php`.

Controllers sollten nah am starter use case bleiben. Ein default preset braucht
normalerweise nur `HomeController`. Ein blog preset kann blog, post und contact
controllers ergaenzen, weil sie Teil der site baseline sind.

## Theme Assets

Theme assets liegen in `themes/<preset-name>/`. Das preset sollte direkt nach
install funktionieren; ein Node build darf nicht fuer den ersten Render noetig
sein.

DaisyUI presets koennen CDN-loaded DaisyUI/Tailwind browser assets und ein
kleines theme controller script fuer light/dark/theme switching nutzen. Custom
DaisyUI theme tokens gehoeren in eine preset theme CSS file.

## Preset Config

Preset-specific settings gehoeren in `core/custom/config/presets/<preset>.php`.
Nutze sie fuer theme defaults, visible theme lists, feature flags und starter
route defaults. Secrets gehoeren nicht in preset config.

## Seeders

Seeders erzeugen nur starter state:

- default site template;
- template alias fuer starter Blade view;
- starter resources fuer content-rich presets;
- idempotent operations.

Keine grossen demo records hinzufuegen, die jede reale site loeschen muss.

## README Contract

Das README beschreibt:

- site purpose;
- included files;
- install flow;
- required Extras;
- frontend build requirements;
- Orte fuer views/theme/config/PHP site logic;
- next project step.

## Validation

Vor release ein fresh project aus dem preset erstellen.

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

Danach first page, manager login, required Extras, Composer autoload,
routes/controllers, theme assets, idempotent seeders und generated project
`.gitignore` pruefen.

## Release Checklist

Pruefen:

- lowercase kebab-case name;
- README;
- nur project-layer files;
- `core/custom/composer.json`;
- small service provider;
- site-specific controllers/routes;
- renderable views;
- theme assets;
- no secrets in config;
- idempotent seeders;
- installer remote reference.
