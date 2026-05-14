# Creer Un Preset

[Extras Et Packages](README.md) / Creer Un Preset

Les presets sont des ready-site scaffolds pour les projets Evolution CMS. Un
package ajoute une component au project; un preset cree la forme initiale du
project lui-meme.

Utilisez un preset pour livrer un site baseline repetable: views, theme assets,
controllers, starter config, required Extras et optional seeders.

## Preset Ou Package

| Besoin | Utiliser |
| --- | --- |
| Reusable manager module, editor, integration, parser element ou service. | Package |
| Reusable frontend/backend capability pour plusieurs projets. | Package |
| Nouveau project avec layout, theme, views, config et required Extras connus. | Preset |
| Blog starter, landing-page starter, shop starter ou agency baseline. | Preset |

Un preset peut contenir un petit custom package pour site-specific controllers,
routes, seeders ou service provider wiring. Il reste un project-layer scaffold.

## Installer Un Preset

Les presets sont appliques par le standalone installer pendant la creation du
project.

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

Pour preset development, utilisez une local preset reference:

```console
evo install preset-check \
  --branch=3.5.x \
  --preset=path/to/preset
```

## Preset Layout

Un modern preset contient seulement le project layer copie par installer.

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

Ne commitez pas Evolution core, manager files, runtime cache, local databases,
local secrets ou IDE workspace files dans un preset.

## Project Composer

`core/custom/composer.json` decrit project-layer autoloading et required Composer
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

Ajoutez required Extras seulement si le starter site ne fonctionne pas sans eux.
Les optional Extras restent optional dans installer.

## Custom Package Layer

Un petit custom package dans `core/custom/packages` sert au site-layer PHP:

- service provider registration;
- frontend routes;
- controllers;
- starter seeders;
- tiny support classes.

Generic manager modules, reusable APIs, tables et integration logic doivent
rester dans des packages separes.

## Service Provider

Le preset service provider doit rester petit.

Responsibilities recommandees:

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

Les views definissent le starter frontend:

- `views/layouts/base.blade.php`;
- `views/home.blade.php`;
- `views/partials/*`;
- site-type specific views, par exemple `blog.blade.php` ou
  `contact.blade.php`.

Les controllers doivent rester proches du starter use case. Un default preset a
souvent seulement besoin de `HomeController`. Un blog preset peut ajouter blog,
post et contact controllers, car ils font partie du site baseline.

## Theme Assets

Theme assets vont dans `themes/<preset-name>/`. Le preset doit fonctionner juste
apres install; un Node build ne doit pas etre requis pour le premier rendu.

DaisyUI presets peuvent utiliser CDN-loaded DaisyUI/Tailwind browser assets et
un petit theme controller script pour light/dark/theme switching. Les custom
DaisyUI theme tokens vont dans un preset theme CSS file.

## Preset Config

Preset-specific settings vont dans `core/custom/config/presets/<preset>.php`.
Utilisez-les pour theme defaults, visible theme lists, feature flags et starter
route defaults. Les secrets ne doivent pas etre dans preset config.

## Seeders

Les seeders creent seulement le starter state:

- default site template;
- template alias pour starter Blade view;
- starter resources pour content-rich presets;
- idempotent operations.

Evitez les gros demo records que chaque vrai site devra supprimer.

## README Contract

Le README doit decrire:

- site purpose;
- included files;
- install flow;
- required Extras;
- frontend build requirements;
- emplacements pour views/theme/config/PHP site logic;
- next project step.

## Validation

Avant release, creez un fresh project depuis le preset.

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

Ensuite, verifiez first page, manager login, required Extras, Composer autoload,
routes/controllers, theme assets, idempotent seeders et generated project
`.gitignore`.

## Release Checklist

Verifiez:

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
